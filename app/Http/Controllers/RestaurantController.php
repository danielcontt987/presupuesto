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

    public function addToAccount(Request $request)
    {

        $products = json_decode($request->input('items'), true);
        $tableId = $request->input('table_id');
        $items = $products;
        $total = $request->input('total');
        $user = Auth::user()->id;

        if (!$tableId || !$items || !$total) {
            return response()->json(['status' => 400, 'message' => 'Faltan datos obligatorios']);
        }

        $result = $this->restaurantService->addToAccount($tableId, $items, $total, $user);

        if ($result['success']) {
            return response()->json(['status' => 200, 'message' => 'Producto agregado a la cuenta', 'item' => $result['item']]);
        } else {
            dd($result);
            return response()->json(['status' => 500, 'message' => 'Error al agregar el producto a la cuenta']);
        }
    }

    public function listItemCook()
    {
        return response()->json(['status' => 200, 'items' => $this->restaurantService->listItemCook()]);
    }

    public function updateItemStatus(Request $request)
    {
        $commandId = $request->input('id');
        $oldStatus = $request->input('oldStatus');
        $newStatus = $request->input('newStatus');

        if (!$commandId || !$newStatus) {
            return response()->json(['status' => 400, 'message' => 'Faltan datos obligatorios']);
        }

        $result = $this->restaurantService->updateItemStatus($commandId, $newStatus);

        if ($result['success']) {
            return response()->json(['status' => 200, 'message' => 'Estado del item actualizado', 'item' => $result['item']]);
        } else {
            return response()->json(['status' => 500, 'message' => 'Error al actualizar el estado del item']);
        }
    }
}
