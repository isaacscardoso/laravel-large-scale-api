<?php

namespace App\Services;

use Illuminate\Support\Str;
use Illuminate\Support\Facades\{DB, Storage};
use Illuminate\Database\Eloquent\{Model, Builder};
use App\Http\Requests\{ProductStoreRequest, ProductUpdateRequest};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Product;

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
                $path = Storage::put('products', $image['url']);
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
        $product->update($request->validated());
        return $product;
    }

    /**
     * Removes the data of a product from the database.
     *
     * @param Product $product
     * @return bool
     */
    public function destroy(Product $product): bool
    {
        return $product->delete();
    }
}
