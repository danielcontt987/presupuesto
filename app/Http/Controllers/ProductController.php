<?php

namespace App\Http\Controllers;

use App\Microservices\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            return Product::store($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }

        DB::commit();
        return response()->json(["status" => "201"]);
    }

    public function list() 
    {
        DB::beginTransaction();
        try {
            $business_id = Auth::user()->getBusiness();
            $products = Product::list($business_id);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }

        DB::commit();
        return response()->json(["status" => "201", "products" => $products]);
    }
}
