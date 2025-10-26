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
            'name' => $request->input('name'),
            'telephone1' => $request->input('cellphone1'),
            'telephone2' => $request->input('cellphone2'),
            'whatsapp' => $request->input('whatsapp'),
            'email_company' => $request->input('email_company'),
        ]);

        return response()->json(['business' => $business], 200);
    }

    public function documentType(Request $request)
    {
        $business = Business::where('id', Auth::user()->getBusiness())->update([
            'type_doc' => $request->input('type_doc'),
        ]);
        return response()->json(['business' => $business], 200);
    }

    public function updateUbication(Request $request)
    {
        $business = Business::where('id', Auth::user()->getBusiness())->update([
            'lat' => $request->input('lat'),
            'log' => $request->input('long'),
        ]);

        return response()->json(['business' => $business], 200);
    }
}
