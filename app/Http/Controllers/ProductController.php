<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Microservices\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'product.name' => 'required|string',
            'product.barcode' => 'nullable|string',
            'product.description' => 'nullable|string',
            'product.category_id' => 'required|integer|exists:categories,id',
            'product.price_s_shop' => 'required|numeric',
            'product.price_shop' => 'required|numeric',
            'product.price' => 'required|numeric',
            'product.price_s_iva' => 'required|numeric',
            'product.type' => 'required|string',
            'product.stock' => 'required|numeric',
            'product.weight' => 'required|numeric',
            'product.folio' => 'nullable|string',
        ]);

        try {
            DB::beginTransaction();

            $product = $this->productService->store($validated['product']);

            DB::commit();
            return response()->json(['status' => 201, 'product' => $product], 201);
        } catch (\Throwable $e) {
            DB::rollBack();
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function list()
    {
        $businessId = Auth::user()->getBusiness();

        $products = $this->productService->list($businessId);

        return response()->json(['status' => 200, 'products' => $products]);
    }


    public function search(Request $request)
    {
        $search = $request->input('search');
        $businessId = Auth::user()->getBusiness();

        $products = $this->productService->search($businessId, $search);

        return response()->json(['status' => 200, 'products' => $products]);
    }
}
