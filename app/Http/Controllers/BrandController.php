<?php

namespace App\Http\Controllers;

use Illuminate\Http\JsonResponse;
use App\Services\BrandServices;
use App\Http\Requests\{BrandStoreRequest, BrandUpdateRequest};
use App\Models\Brand;

class BrandController extends Controller
{
    public function __construct(protected BrandServices $brandServices)
    {
    }

    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        $brands = $this->brandServices->list();
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
        $request = $this->brandServices->store($request);
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
        $request = $this->brandServices->update($request, $brand);
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
        $request = $this->brandServices->destroy($brand);
        if ($request) return response()->json(['message' => 'Brand deleted.']);
        return response()->json(['message' => 'Brand not deleted.']);
    }
}
