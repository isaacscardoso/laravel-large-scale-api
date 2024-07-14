<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Services\ProductService;
use App\Http\Requests\{ProductStoreRequest, ProductUpdateRequest};
use App\Models\Product;

class ProductController extends Controller
{
    public function __construct(protected ProductService $productService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        /** ProductPolicy rules to view all. */
        Gate::authorize('viewAny', Product::class);

        $products = $this->productService->list();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ProductStoreRequest $request
     * @return JsonResponse
     */
    public function store(ProductStoreRequest $request): JsonResponse
    {
        /** ProductPolicy rules for creation. */
        Gate::authorize('create', Product::class);

        $product = $this->productService->store($request);
        return response()->json($product);
    }

    /**
     * Display the specified resource.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function show(Product $product): JsonResponse
    {
        /** ProductPolicy rules for specific visualization. */
        Gate::authorize('view', $product);

        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ProductUpdateRequest $request
     * @param Product $product
     * @return JsonResponse
     */
    public function update(ProductUpdateRequest $request, Product $product): JsonResponse
    {
        /** ProductPolicy rules for updating. */
        Gate::authorize('update', $product);

        $product = $this->productService->update($request, $product);
        return response()->json($product);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Product $product
     * @return JsonResponse
     */
    public function destroy(Product $product): JsonResponse
    {
        /** ProductPolicy rules for deletion. */
        Gate::authorize('delete', $product);

        $request = $this->productService->destroy($product);
        if ($request) return response()->json(['message' => 'Product deleted.']);
        return response()->json(['message' => 'Product not deleted.']);
    }
}
