<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RestaurantController extends Controller
{
    protected $restaurantService;

    public function __construct(\App\Services\RestaurantService $restaurantService)
    {
        $this->restaurantService = $restaurantService;
    }

    public function list()
    {
        $businessId = Auth::user()->getBusiness();
        return response()->json(['status' => 200, 'tables' => $this->restaurantService->list($businessId)]);
    }

    public function listProduct()
    {
        $businessId = Auth::user()->getBusiness();
        return response()->json(['status' => 200, 'tables' => $this->restaurantService->listProducts($businessId)]);
    }

    public function items(Request $request)
    {

        $tableId = $request->input('table_id');
        return response()->json(['status' => 200, 'items' => $this->restaurantService->listItems($tableId)]);
    }

    public function listCategories()
    {
        $businessId = Auth::user()->getBusiness();
        return response()->json(['status' => 200, 'categories' => $this->restaurantService->listCategories($businessId)]);
    }
}
