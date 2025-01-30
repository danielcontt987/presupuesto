<?php

namespace App\Http\Controllers;

use App\Microservices\Cashcut;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CashCutController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $cashcut = Cashcut::store($request);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }

        DB::commit();
        return response()->json(["status" => "200", "cashcut" => $cashcut]);
    }

    public function get() 
    {
        DB::beginTransaction();
        try {
            $id = Auth::user()->id;
            $cashcuts = Cashcut::get($id);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 500, "error" => $e->getMessage()], 500);
        }

        DB::commit();
        return response()->json(["status" => "200", "cashcuts" => $cashcuts]);
    }
}
