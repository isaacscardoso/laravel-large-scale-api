<?php

namespace App\Services;

use App\Models\Category;
use Illuminate\Database\Eloquent\{Model, Builder};
use App\Http\Requests\{CategoryStoreRequest, CategoryUpdateRequest};
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CategoryService
{
    /**
     * Returns a paginated list of Categories.
     *
     * @return LengthAwarePaginator
     */
    public function list(): LengthAwarePaginator
    {
        return Category::query()->paginate(10);
    }

    /**
     * Adds a valid category to the database.
     *
     * @param CategoryStoreRequest $request
     * @return Model|Builder
     */
    public function store(CategoryStoreRequest $request): Model|Builder
    {
        return Category::query()->create($request->validated());
    }

    /**
     * Updates the valid category data in the database.
     *
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @return Category
     */
    public function update(CategoryUpdateRequest $request, Category $category): Category
    {
        $category->update($request->validated());
        return $category;
    }

    /**
     * Removes the data of a category from the database.
     *
     * @param Category $category
     * @return bool
     */
    public function destroy(Category $category): bool
    {
        return $category->delete();
    }
}
