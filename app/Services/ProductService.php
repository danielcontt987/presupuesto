<?php

namespace App\Services;

use App\Helpers\FolioGenerator;
use App\Models\Area;
use App\Models\Inventory;
use App\Models\InventoryDetail;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class ProductService
{
    public function store(array $data, $user)
    {
        return DB::transaction(function () use ($data, $user) {
            $areaId = $user->getArea();
            $businessId = $user->getBusiness();
            $area = Area::findOrFail($areaId);

            $existingCount = Product::where('business_id', $businessId)->count();
            $folioAutomatic = FolioGenerator::generate($area->folio, $existingCount);
            $description = $data['description'] ?? 'NA';

            $product = Product::create([
                'folio' => $folioAutomatic,
                'folio_personality' => $data['folio'],
                'name' => $data['product']['name'],
                'barcode' => $data['barcode'],
                'description' => $description,
                'is_service' => 0,
                'price_shop' => $data['price_shop'],
                'price_s_shop' => $data['price_s_shop'],
                'price_sale' => $data['price'],
                'price_s_sale' => $data['price_s_iva'],
                'iva' => $data['price'] * 0.16,
                'business_id' => $businessId,
                'user_id' => $user->id,
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
        });
    }
}
