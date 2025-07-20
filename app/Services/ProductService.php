<?php

namespace App\Services;

use App\Models\Area;
use App\Models\Inventory;
use App\Models\InventoryDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;

class ProductService
{
    public function store(array $data): Product
    {
        $areaId = Auth::user()->getArea();
        $area = Area::findOrFail($areaId);

        $existingProductsCount = Product::where('business_id', Auth::user()->getBusiness())->count();
        $folioAutomatic = $area->folio . '-' . str_pad($existingProductsCount + 1, 5, "0", STR_PAD_LEFT);

        $product = Product::create([
            'folio' => $folioAutomatic,
            'folio_personality' => $data['folio'],
            'name' => $data['name'],
            'barcode' => $data['barcode'] ?? null,
            'description' => $data['description'] ?? 'NA',
            'is_service' => 0,
            'price_shop' => $data['price_shop'],
            'price_s_shop' => $data['price_s_shop'],
            'price_sale' => $data['price'],
            'price_s_sale' => $data['price_s_iva'],
            'iva' => ($data['price'] * .16),
            'business_id' => Auth::user()->getBusiness(),
            'user_id' => Auth::id(),
            'weight' => $data['weight'],
            'type' => $data['type'],
            'category_id' => $data['category_id'],
        ]);

        $inventory = Inventory::where('area_id', $areaId)->firstOrFail();

        InventoryDetail::create([
            'product_id' => $product->id,
            'inventory_id' => $inventory->id,
            'stock' => $data['stock'],
            'min' => 1,
            'max' => 5,
        ]);

        return $product;
    }

    public function list(int $businessId)
    {
        return Product::with(['category', 'inventoryDetail'])
            ->where('business_id', $businessId)
            ->get();
    }

    public function search(int $businessId, string $search)
    {
        return Product::with(['category', 'inventoryDetail'])
            ->where('business_id', $businessId)
            ->where('name', 'like', '%' . $search . '%')
            ->get();
    }

    public function listByCategory(int $businessId, int $categoryId)
    {
        return Product::with(['category', 'inventoryDetail'])
            ->where('business_id', $businessId)
            ->where('category_id', $categoryId)
            ->get();
    }
}
