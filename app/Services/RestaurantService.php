<?php

namespace App\Services;

use App\Models\Category as ModelsCategory;
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

    public function listCategories(int $businessId)
    {
        $categories = ModelsCategory::where('business_id', $businessId)
            ->orderBy('name')
            ->get();
        return $categories->map(function ($category) {
            return [
                'id' => $category->id,
                'name' => $category->name,
            ];
        })->prepend(['id' => 0, 'name' => 'Ver todo']);
    }
}
