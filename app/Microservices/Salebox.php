<?php

namespace App\Microservices;

use App\Models\Salebox as ModelsSalebox;

class Salebox extends Microservice
{
    public static function list($business_id)
    {
        $saleboxes = ModelsSalebox::where('business_id', $business_id)->get();
        return $saleboxes;
    }
}
