<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Services\CategoryService;
use App\Http\Requests\{CategoryStoreRequest, CategoryUpdateRequest};
use App\Models\Category;

class CategoryController extends Controller
{
    public function __construct(protected CategoryService $categoryService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        /** CategoryPolicy rules to view all. */
        Gate::authorize('viewAny', Category::class);

        $categories = $this->categoryService->list();
        return response()->json($categories);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CategoryStoreRequest $request
     * @return JsonResponse
     */
    public function store(CategoryStoreRequest $request): JsonResponse
    {
        /** CategoryPolicy rules for creation. */
        Gate::authorize('create', Category::class);

        $category = $this->categoryService->store($request);
        return response()->json($category);
    }

    /**
     * Display the specified resource.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function show(Category $category): JsonResponse
    {
        /** CategoryPolicy rules for specific visualization. */
        Gate::authorize('view', $category);

        return response()->json($category);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryUpdateRequest $request
     * @param Category $category
     * @return JsonResponse
     */
    public function update(CategoryUpdateRequest $request, Category $category): JsonResponse
    {
        /** CategoryPolicy rules for updating. */
        Gate::authorize('update', $category);

        $category = $this->categoryService->update($request, $category);
        return response()->json($category);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Category $category
     * @return JsonResponse
     */
    public function destroy(Category $category): JsonResponse
    {
        /** CategoryPolicy rules for deletion. */
        Gate::authorize('delete', $category);

        $request = $this->categoryService->destroy($category);
        if ($request) return response()->json(['message' => 'Category deleted.']);
        return response()->json(['message' => 'Category not deleted.']);
    }
}
