<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use App\Microservices\Product;
use App\Models\Category;
use App\Models\Inventory;
use App\Models\InventoryDetail;
use App\Models\Product as ModelsProduct;
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

    public function listByCategory(Request $request)
    {
        $categoryId = $request->input('category_id');
        $businessId = Auth::user()->getBusiness();

        $products = $this->productService->listByCategory($businessId, $categoryId);

        return response()->json(['status' => 200, 'products' => $products]);
    }


    public function importExcel(Request $request)
    {
        $document = $request->file('file');
        $businessId = Auth::user()->getBusiness();

        $inputFileType = ucfirst($document->getClientOriginalExtension());
        $reader = \PhpOffice\PhpSpreadsheet\IOFactory::createReader($inputFileType);
        $reader->setReadDataOnly(true);
        $spreadsheet = $reader->load($document);

        $worksheet = $spreadsheet->getActiveSheet();
        $highestRow = $worksheet->getHighestRow();

        $isValid = ($highestRow >= 2) ? true : false;
        // $message = ($highestRow >= 2) ? "Falta llenar los campos: <br/>" : "El archivo no tiene registros, está vacio";
        // $array = [2, 4, 6, 7, 9];



        DB::beginTransaction();

        try {

            if ($isValid) {
                for ($row = 2; $row <= $highestRow; $row++) {
                    $categorySearch = Category::where('business_id', $businessId)->where('name', '=', $worksheet->getCell("E{$row}")->getValue())->first();
                    if ($categorySearch == null) {
                        $category = Category::create([
                            'name' => $worksheet->getCell("E{$row}")->getValue(),
                            'description' => 'NA',
                            'business_id' => $businessId,
                            'user_id' => Auth::user()->id,
                        ]);
                    } else {
                        $category = $worksheet->getCell("E{$row}")->getValue();
                    }
                    $name       = $worksheet->getCell("A{$row}")->getValue();
                    $folio      = $worksheet->getCell("B{$row}")->getValue();
                    $barcode    = $worksheet->getCell("C{$row}")->getValue();
                    $desc       = $worksheet->getCell("D{$row}")->getValue() ?? 'NA';
                    $categoryId = $category->id ?? $categorySearch->id;
                    $price_shop = $worksheet->getCell("F{$row}")->getValue();
                    $price_s_shop = $worksheet->getCell("G{$row}")->getValue();
                    $price_sale   = $worksheet->getCell("H{$row}")->getValue();
                    $price_s_sale = $worksheet->getCell("I{$row}")->getValue();
                    $weight     = $worksheet->getCell("M{$row}")->getValue();
                    $type       = $worksheet->getCell("K{$row}")->getValue();
                    $stock      = $worksheet->getCell("L{$row}")->getValue();

                    $product = ModelsProduct::create([
                        'name' => $name,
                        'folio' => $folio,
                        'barcode' => $barcode,
                        'description' => $desc,
                        'is_service' => 0,
                        'price_shop' => $price_shop,
                        'price_s_shop' => $price_s_shop,
                        'price_sale' => $price_sale,
                        'price_s_sale' => $price_s_sale,
                        'iva' => ($price_sale * .16),
                        'business_id' => Auth::user()->getBusiness(),
                        'user_id' => Auth::id(),
                        'weight' => $weight,
                        'type' => $type,
                        'category_id' => $categoryId,
                    ]);

                    $inventory = Inventory::where('area_id', Auth::user()->getArea())->first();

                    if (!$inventory) {
                        $inventoryNew = Inventory::create([
                            'name' => "General",
                            'area_id' => Auth::user()->getArea(),
                        ]);

                        InventoryDetail::create([
                            'product_id' => $product->id,
                            'inventory_id' => $inventoryNew->id,
                            'stock' => $stock,
                            'min' => 1,
                            'max' => 5,
                        ]);
                    } else {
                        InventoryDetail::create([
                            'product_id' => $product->id,
                            'inventory_id' => $inventory->id,
                            'stock' => $stock,
                            'min' => 1,
                            'max' => 5,
                        ]);
                    }
                }
            }
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, 'message' => 'Error al importar los productos: ' . $e->getMessage()], 500);
        }

        return response()->json(['status' => 200, 'message' => 'Productos importados correctamente']);
    }
}
