<?php

namespace App\Microservices;

use App\Models\Area;
use App\Models\Inventory;
use App\Models\InventoryDetail;
use App\Models\Product as ModelsProduct;
use Illuminate\Support\Facades\Auth;

class Product extends Microservice
{
    public static function store($request)
    {
        $name = $request->input('product')['name'];
        $barcode = $request->input('product')['barcode'];
        $description = $request->input('product')['description'];
        $category_id = $request->input('product')['category_id'];
        $price_s_shop = $request->input('product')['price_s_shop'];
        $price_shop = $request->input('product')['price_shop'];
        $price = $request->input('product')['price'];
        $price_s_iva = $request->input('product')['price_s_iva'];
        $type = $request->input('product')['type'];
        $stock = $request->input('product')['stock'];
        $weight = $request->input('product')['weight'];
        $folioPersonality = $request->input('product')['folio'];

        if (isset($description)) {
            $description =  "NA";
        }

        $folio = ModelsProduct::where('business_id', Auth::user()->getBusiness())->get();
        $areaId = Auth::user()->getArea();

        $area = Area::where('id', $areaId)->first();
        if (count($folio) > 0) {
            $folioAutomatic = $area->folio . '-' . str_pad((count($folio) + 1), 5, "0", STR_PAD_LEFT);
        }else{
            $folioAutomatic = $area->folio . '-' . str_pad((1), 5, "0", STR_PAD_LEFT);
        }


        $product = ModelsProduct::create([
            'folio' => $folioAutomatic,
            'folio_personality' => $folioPersonality,
            'name' => $name,
            'barcode' => $barcode,
            'description' => $description,
            'is_service' => 0,
            'price_shop' => $price_shop,
            'price_s_shop' => $price_s_shop,
            'price_sale' => $price,
            'price_s_sale' => $price_s_iva,
            'iva' => ($price * .16),
            'business_id' => Auth::user()->getBusiness(),
            'user_id' =>  Auth::user()->id,
            'weight' => $weight,
            'type' => $type,
            'category_id' => $category_id,
        ]);

        $inventory = Inventory::where('area_id', $areaId)->first();

        InventoryDetail::create([
            'product_id' => $product->id,
            'inventory_id' => $inventory->id,
            'stock' => $stock,
            'min' => 1,
            'max' => 5,
        ]);
        return $product;
    }

    public static function list($businessId)
    {
        $products = ModelsProduct::with('category')->where('business_id', $businessId)->get();
        return $products;
    }
}
