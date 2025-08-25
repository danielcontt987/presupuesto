<?php

namespace App\Http\Controllers;

use App\Microservices\Cashcut;
use App\Microservices\Sale;
use App\Models\CashCut as ModelsCashCut;
use App\Models\Sale as ModelsSale;
use App\Models\Salebox;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use PDF;

class PointSaleController extends Controller
{
    public function store(Request $request)
    {
        $folio = ModelsSale::where('user_id', Auth::user()->id)->count();
        $folioSale = str_pad(($folio + 1), 5, "0", STR_PAD_LEFT);
        $products = $request->input('products');
        $salebox_id = $request->input('salebox_id');
        $client_id = 0;
        $cashcut_id = $request->input('cashcut_id');
        $user_id = Auth::user()->id;
        $status = "Finalizado";
        $status_ticket = "Vigente";
        $json_concept = json_decode($products);
        $saledate = Carbon::now('America/Mazatlan');
        $total = $request->input('total');
        $subtotal = $request->input('subtotal');
        $iva = $request->input('iva');

        $sale = ModelsSale::create([
            'folio' => $folioSale,
            'client_id' => $client_id,
            'user_id' => $user_id,
            'salebox_id' => $salebox_id,
            'cashcut_id' => $cashcut_id,
            'status' => $status,
            'status_ticket' => $status_ticket,
            'json_concept' => $products,
            'saledate' => $saledate,
            'total' => $total,
            'subtotal' => $subtotal,
            'iva' => $iva,
        ]);

        foreach ($json_concept as $product) {
            SaleDetail::create([
                'sale_id' => $sale['id'],
                'product_id' => $product->id,
                'inventory_id' => 0,
                'quantity' => $product->quantity,
                'total' => $product->price_sale,
                'inventory_id' => 0,
                'iva' => $product->price_sale * .16,
                'discount' => 0,
                'subtotal' => $product->price_sale / 1.16,
            ]);
        }

        return response()->json(["status" => "201", "sale" => $sale]);

        // Aquí va el código de la función...

        /*folio
            client_id
            user_id
            salebox_id
            cashcut_id
            status
            status_ticket
            json_concept
            saledate
            total*/
        // $sale = new Sale();
        // $sale->name = $request->name;
        // $sale->address = $request->address;
        // $sale->phone = $request->phone;
        // $sale->save();
        // return response()->json(["status" => "201", "pointSale" => $pointSale]);
    }

    public function list(Request $request)
    {
        $business_id = Auth::user()->getBusiness();
        $salebox = Salebox::where('business_id', $business_id)->first()['business_id'];
        $sales = ModelsSale::where('salebox_id', $salebox)->with(['client' => function ($query) {
            $query->select('id', 'name', 'lastname');
        }])
            ->whereBetween('saledate', [$request->date1 . ' ' . '00:00:00', $request->date2 . ' ' . '23:59:59'])->get(['id', 'folio', 'saledate', 'total', 'status', 'status_ticket', 'client_id']);

        return response()->json(["status" => "200", "sales" => $sales, "total" => $sales->count(), "last" => $sales->last(), "totalAmount" => $sales->sum('total')]);
    }

    public function print($id)
    {
        // dd("$");
        // Ruta de la imagen
        $imagePath = public_path('img/logoPDF.jpeg');

        // Convertir la imagen a Base64
        $imageData = base64_encode(file_get_contents($imagePath));

        // Crear el URI base64 para incluir en el HTML
        $base64Image = 'data:image/jpeg;base64,' . $imageData;

        $sale = ModelsSale::find($id);
        $date = Carbon::parse($sale->saledate)->format('d/m/Y');
        $user = Auth::user()->fullName();
        $saleDetails = SaleDetail::with(['product'])->where('sale_id', $id)->get();
        $data = [
            'title' => 'Presupuesto',
            'sale' => $sale,
            'saleDetails' => $saleDetails,
            'img' => $base64Image,
            'date' => $date,
            'user' => $user,
            'folio' => $sale->folio,
        ];
        $pdf = PDF::loadView('printers.ticket', $data);
        return $pdf->stream('prosupuesto.pdf');  // Usamos stream en lugar de download
    }

    public function get($id)
    {
        $id = intval($id);
        $sale = ModelsSale::where('id', $id)->select(
            'id',
            'folio',
            'client_id',
            'salebox_id',
            'user_id',
            'saledate',
            'total',
            'subtotal',
            'iva',
            'transfer',
            'card',
            'cash',
            'check',
        )->with(['details' => function ($query) {
            $query->select(
                "id",
                "sale_id",
                "product_id",
                "inventory_id",
                "quantity",
                "total",
                "subtotal",
                "iva",
                "discount",
            )->with(['product' => function ($query) {
                $query->select('id', 'name', 'barcode', 'category_id');
            }]);
        }])->with(['user' => function ($query) {
            $query->select('id', 'name', 'lastname');
        }])->with(['salebox' => function ($query) {
            $query->select('id', 'name');
        }])->first();
        return response()->json(["status" => "200", "sale" => $sale]);
    }
}
