<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\{DB, Storage};
use Illuminate\Database\Eloquent\{Model, Builder};
use App\Http\Requests\{ProductStoreRequest, ProductUpdateRequest};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\{Image, Product, Sku};

class ProductService
{
    /**
     * Returns a paginated list of Products.
     *
     * @return LengthAwarePaginator
     */
    public function list(): LengthAwarePaginator
    {
        return Product::paginate(10);
    }

    /**
     * @param Product $product
     * @param ProductStoreRequest $request
     * @return void
     */
    private function storeSku(Product $product, ProductStoreRequest $request): void
    {
        $skusData = $request['sku'];
        $skus = $product->skus()->createMany($skusData);
        $imagesToInsert = collect();

        $skus->each(function ($item, $key) use ($skusData, &$imagesToInsert) {
            $images = collect($skusData[$key]['images'])->map(function ($image, $index) use ($item) {
                $path = $image['url']->store('products');
                return [
                    'sku_id' => $item->id,
                    'url' => $path,
                    'is_cover' => $index == 0,
                ];
            });
            $imagesToInsert = $imagesToInsert->merge($images);
        });

        DB::table('images')->insert($imagesToInsert->toArray());
    }

    /**
     * @param Product $product
     * @param ProductUpdateRequest $request
     * @return void
     */
    private function updateSku(Product $product, ProductUpdateRequest $request): void
    {
        $skusData = collect($request['sku']);
        $existingSkuIds = $product->skus()->pluck('id')->toArray();

        $skusData->each(function ($value) use ($product) {
            $sku = $product->skus()->updateOrCreate(['id' => $value['id'] ?? 0], $value);
            if (isset($value['images'])) {
                $this->updateSkuImages($sku, $value['images']);
            }
        });

        $skusToDelete = array_diff($existingSkuIds, $skusData->pluck('id')->filter()->toArray());
        $product->skus()->whereIn('id', $skusToDelete)->delete();
    }

    /**
     * @param Model|Sku $sku
     * @param array $images
     * @return void
     */
    private function updateSkuImages(Model|Sku $sku, array $images): void
    {
        $imageData = array_map(function ($image, $index) {
            return [
                'url' => $image['url']->store('products', 's3'),
                'is_featured' => $index == 0,
            ];
        }, $images, array_keys($images));

        $sku->images()->delete();
        $sku->images()->createMany($imageData);
    }

    /**
     * Adds a valid product to the database.
     *
     * @param ProductStoreRequest $request
     * @return Model|Builder
     */
    public function store(ProductStoreRequest $request): Model|Builder
    {
        return DB::transaction(function () use ($request) {
            $data = $request->except('sku');
            $data['slug'] = Str::slug($data['name']);
            $product = Product::create($data);

            $this->storeSku($product, $request);

            return $product->load('skus.images');
        });
    }

    /**
     * Updates the valid product data in the database.
     *
     * @param ProductUpdateRequest $request
     * @param Product $product
     * @return Product
     */
    public function update(ProductUpdateRequest $request, Product $product): Product
    {
        return DB::transaction(function () use ($request, $product) {
            $data = $request->except('sku');
            $data['slug'] = Str::slug($data['name']);
            $product->update($data);

            $this->updateSku($product, $request);

            return $product->load('skus.images');
        });
    }

    /**
     * Removes the data of a product from the database.
     *
     * @param Product $product
     * @return bool
     */
    public function destroy(Product $product): bool
    {
        return DB::transaction(function () use ($product) {
            $product->load('skus.images');
            $skuIds = $product->skus->pluck('id');

            Image::query()->whereIn('sku_id', $skuIds)->each(fn($image) => $image->delete());
            Sku::query()->whereIn('id', $skuIds)->delete();

            return $product->delete();
        });
    }

//    /**
//     * Removes the data of a product from the database.
//     *
//     * @param Product $product
//     * @return bool
//     */
//    public function destroy(Product $product): bool
//    {
//        return DB::transaction(function () use ($product) {
//            $product->load('skus.images');
//            $imageUrls = $product->skus->flatMap(fn($sku) => $sku->images->pluck('url'))->all();
//
//            Storage::delete($imageUrls);
//
//            $skuIds = $product->skus->pluck('id');
//
//            Image::query()->whereIn('sku_id', $skuIds)->delete();
//            Sku::query()->whereIn('id', $skuIds)->delete();
//
//            return $product->delete();
//        });
//    }
}
