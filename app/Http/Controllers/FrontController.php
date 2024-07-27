<?php

namespace App\Http\Controllers;

use Illuminate\Http\{JsonResponse, Request, Response};
use App\Models\{Brand, Category, Product};

class FrontController extends Controller
{
    /**
     * @return Response
     */
    public function buildMenu(): Response
    {
        $brands = Brand::all();
        $categories = Category::with('products')->get();

        return response([
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }

    /**
     * @return Response
     */
    public function home(): Response
    {
        $brads = Brand::query()->where('is_featured', 1)->get();
        $categories = Category::query()->where('is_featured', 1)->get();
        $products = Product::with('sku.images')->where('is_featured', 1)->get();

        return response([
            'brads' => $brads,
            'categories' => $categories,
            'products' => $products,
        ]);
    }

    /**
     * @return Response
     */
    public function productAccessories(): Response
    {
        $brands = Brand::all();
        $categories = Category::with('products')->get();

        return response([
            'brands' => $brands,
            'categories' => $categories,
        ]);
    }

    /**
     * @param Product $product
     * @return JsonResponse
     */
    public function product(Product $product): JsonResponse
    {
        $product = $product->load('sku.images');
        return response()->json($product);
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function productList(Request $request): JsonResponse
    {
        $products = Product::with('sku.images');

        if ($request->filled('category_id')) {
            $products->where('category_id', $request->get('category_id'));
        }

        if ($request->filled('brand_id')) {
            $products->where('brand_id', $request->get('brand_id'));
        }
        
        if ($request->filled('value_type') && $request->filled('price')) {
            $products->whereHas('skus', function ($query) use ($request) {
                $query->where('price', $request['value_type'], $request->get('price'));
            });
        }

        $products = $products->paginate(12);
        return response()->json($products);
    }
}
