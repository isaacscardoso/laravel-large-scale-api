<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Gate;
use App\Services\BrandService;
use App\Http\Requests\{BrandStoreRequest, BrandUpdateRequest};
use App\Models\Brand;

class BrandController extends Controller
{
    public function __construct(protected BrandService $brandService)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        /** BrandPolicy rules to view all. */
        Gate::authorize('viewAny', Brand::class);

        $brands = $this->brandService->list();
        return response()->json($brands);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BrandStoreRequest $request
     * @return JsonResponse
     */
    public function store(BrandStoreRequest $request): JsonResponse
    {
        /** BrandPolicy rules for creation. */
        Gate::authorize('create', Brand::class);

        $request = $this->brandService->store($request);
        return response()->json($request);
    }

    /**
     * Display the specified resource.
     *
     * @param Brand $brand
     * @return JsonResponse
     */
    public function show(Brand $brand): JsonResponse
    {
        /** BrandPolicy rules for specific visualization. */
        Gate::authorize('view', $brand);

        return response()->json($brand);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BrandUpdateRequest $request
     * @param Brand $brand
     * @return JsonResponse
     */
    public function update(BrandUpdateRequest $request, Brand $brand): JsonResponse
    {
        /** BrandPolicy rules for updating. */
        Gate::authorize('update', $brand);

        $request = $this->brandService->update($request, $brand);
        return response()->json($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Brand $brand
     * @return JsonResponse
     */
    public function destroy(Brand $brand): JsonResponse
    {
        /** BrandPolicy rules for deletion. */
        Gate::authorize('delete', $brand);

        $request = $this->brandService->destroy($brand);
        if ($request) return response()->json(['message' => 'Brand deleted.']);
        return response()->json(['message' => 'Brand not deleted.']);
    }
}
