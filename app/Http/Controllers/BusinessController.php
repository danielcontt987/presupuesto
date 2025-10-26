<?php

namespace App\Http\Controllers;

use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BusinessController extends Controller
{
    public function list()
    {
        $business = Business::where('id', Auth::user()->getBusiness())->with('turn')->first();
        return response()->json(['business' => $business]);
    }
}
