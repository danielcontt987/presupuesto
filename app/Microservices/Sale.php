<?php

namespace App\Microservices;

use App\Models\Sale as ModelsSale;
use Illuminate\Support\Facades\Auth;

class Sale extends Microservice
{
    public static function list($request)
    {
        $business_id = Auth::user()->getBusiness();
        $sales = ModelsSale::where('business_id', $business_id)->get();
        return $sales;
    }
}
