<?php

namespace App\Http\Controllers;

use App\Microservices\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function list(Request $request) 
    {
        try {
            return Category::list();
        } catch (\Exception $e) {
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
    }
    
    public function store(Request $request) 
    {
        try {
            return Category::store($request);
        } catch (\Exception $e) {
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }
    }
}
