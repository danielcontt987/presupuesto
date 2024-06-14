<?php

namespace App\Microservices;

use App\Models\Business;

class Setting extends Microservice
{
    public static function get($id)
    {
        return Business::where('id', $id)->first();
    }
}
