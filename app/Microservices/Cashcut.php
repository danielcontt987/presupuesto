<?php

namespace App\Microservices;

use App\Models\CashCut as ModelsCashCut;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class Cashcut extends Microservice
{
    public static function store($request)
    {
        $folio = 0;
        $count = ModelsCashCut::where('user_id', $request->user_id)->where('salebox_id', $request->salebox_id)->count();
        if ($count > 0) {
            $folio = $count + 1;
        }else{
            $folio = 1;
        }
        $cashcut = ModelsCashCut::create([
            'user_id' => Auth::user()->id,
            'salebox_id' => $request->salebox_id,
            'real_mount' => 0,
            'current_mount' => 0,
            'difference' => 0,
            'little_box' => $request->amount,
            'observations' => $request->comment,
            'date_opening' => Carbon::now(),
            'folio' => $folio,
        ]);
        
        return $cashcut;
    }

    public static function get($id)
    {
        $cashcuts = ModelsCashCut::where('date_cute', null)
        ->where('user_id', Auth::user()->id)
        ->with(['salebox', 'user'])
        ->orderBy("id", 'desc')->first();
        return $cashcuts;
    }
}
