<?php

namespace App\Services;

use App\Models\Command;
use App\Models\Product;
use App\Models\Table;

class RestaurantService
{
    public function list(int $businessId)
    {
        return Table::with(['waiter'])
            ->where('business_id', $businessId)
            ->get();
    }

    public function listProducts(int $businessId)
    {
        return Product::with(['category', 'inventoryDetail'])
            ->where('business_id', $businessId)
            ->get();
    }

    public function listItems(int $tableId)
    {
        return Command::where('table_id', $tableId)->get();
    }
}
