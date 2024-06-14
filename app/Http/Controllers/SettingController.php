<?php

namespace App\Http\Controllers;

use App\Microservices\Setting as SettingMS;
use App\Models\Business;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SettingController extends Controller
{
    public function get()
    {
        $businessId = Auth::user()->getBusiness();
        return response()->json(
            SettingMS::get($businessId),
            200
        );
    }

    public function updateInfo(Request $request)
    {
        $business = Business::where('id', Auth::user()->getBusiness())->update([
            'name' => $request->input('name')
        ]);

        return response()->json(['business' => $business], 200);
    }
}
