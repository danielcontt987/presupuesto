<?php

namespace App\Http\Controllers;

use App\Microservices\Module as ModuleMS;
use Illuminate\Http\Request;

class ModuleController extends Controller
{
    public function list ()
    {
        return response()->json(
            ModuleMS::list(),
            200
        );
    }

    public function store (Request $request)
    {
        return response()->json(
            ModuleMS::store($request->name),
            200
        );
    }
}
