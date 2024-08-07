<?php

namespace App\Services;

use Illuminate\Database\Eloquent\{Model, Builder};
use App\Http\Requests\{BrandStoreRequest, BrandUpdateRequest};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use App\Models\Brand;

class BrandService
{
    /**
     * Returns a paginated list of Brands.
     *
     * @return LengthAwarePaginator
     */
    public function list(): LengthAwarePaginator
    {
        return Brand::paginate(10);
    }

    /**
     * Adds a valid brand to the database.
     *
     * @param BrandStoreRequest $request
     * @return Model|Builder
     */
    public function store(BrandStoreRequest $request): Model|Builder
    {
        return Brand::create($request->validated());
    }

    /**
     * Updates the valid brand data in the database.
     *
     * @param BrandUpdateRequest $request
     * @param Brand $brand
     * @return Brand
     */
    public function update(BrandUpdateRequest $request, Brand $brand): Brand
    {
        $brand->update($request->validated());
        return $brand;
    }

    /**
     * Removes the data of a brand from the database.
     *
     * @param Brand $brand
     * @return bool
     */
    public function destroy(Brand $brand): bool
    {
        return $brand->delete();
    }
}
