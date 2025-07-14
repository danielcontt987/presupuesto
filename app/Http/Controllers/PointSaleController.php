<?php

namespace App\Http\Controllers;

use App\Microservices\Cashcut;
use App\Microservices\Sale;
use App\Models\CashCut as ModelsCashCut;
use App\Models\Sale as ModelsSale;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
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

    public function list()
    {
        $business_id = Auth::user()->getBusiness();
        $sale = Sale::list($business_id);
    }

    public function print($id)
    {
        // // Ruta de la imagen
        // $imagePath = public_path('img/logoPDF.jpeg');

        // // Convertir la imagen a Base64
        // $imageData = base64_encode(file_get_contents($imagePath));

        // // Crear el URI base64 para incluir en el HTML
        // $base64Image = 'data:image/jpeg;base64,' . $imageData;

        // $sale = ModelsSale::find($id);
        // $date = Carbon::parse($sale->saledate)->format('d/m/Y');
        // $user = Auth::user()->fullName();
        // $saleDetails = SaleDetail::with(['product'])->where('sale_id', $id)->get();
        // $data = [
        //     'title' => 'Presupuesto', 
        //     'sale' => $sale, 
        //     'saleDetails' => $saleDetails, 
        //     'img' => $base64Image,
        //     'date' => $date,
        //     'user' => $user,
        //     'folio' => $sale->folio,
        // ];
        $ticketData = [
            'empresa' => 'Mi Tienda S.A.',
            'direccion' => 'Calle Falsa 123',
            'telefono' => '555-123-4567',
            'ticket_id' => 1001,
            'fecha' => now()->format('d/m/Y H:i'),
            'productos' => [
                ['nombre' => 'Coca-Cola', 'cantidad' => 2, 'precio' => 15.00],
                ['nombre' => 'Pan Bimbo', 'cantidad' => 1, 'precio' => 35.00],
                ['nombre' => 'Queso', 'cantidad' => 1, 'precio' => 60.00],
            ],
            'total' => 125.00,
        ];
        $pdf = PDF::loadView('printers.document', $ticketData);
        $pdf->setPaper([0, 0, 226.77, 566.93], 'portrait');
        return $pdf->stream('prosupuesto.pdf');  // Usamos stream en lugar de download



        // Http::post('http://localhost:5000/api/print', [
        //     'html' => $ticketHtml,
        //     'printer' => '58k',
        // ]);
    }
}
