<?php

namespace App\Http\Controllers;

use App\Microservices\Salebox;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class SaleBoxController extends Controller
{
    public function list()  
    {
        DB::beginTransaction();
        try {
            $business_id = Auth::user()->getBusiness();
            $saleBoxes = Salebox::list($business_id);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }

        DB::commit();
        return response()->json(["status" => "200", "saleboxes" => $saleBoxes]);
    }
}
