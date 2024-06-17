<?php

namespace App\Http\Controllers;

use App\Microservices\Area as AreaMS;
use App\Models\AreaUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AreaController extends Controller
{
    public function get()
    {
        return response()->json([
            'area' => AreaMS::get(Auth::user()->getBusiness()),
            'users' => AreaMS::getUser(Auth::user()->getBusiness()),
        ], 200);
    }
}
