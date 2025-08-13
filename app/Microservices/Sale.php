<?php

namespace App\Microservices;

use App\Models\Sale as ModelsSale;
use App\Models\Salebox;
use Illuminate\Support\Facades\Auth;

class Sale extends Microservice
{
    public static function list($request)
    {
        dd($request);
        return $sales;
    }
}
