<?php

namespace App\Http\Controllers;

use App\Microservices\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;

class UserController extends Controller
{
    public function login(Request $request) 
    {
        $credentials = $request->only('email', 'password');
        
        if (Auth::attempt($credentials)) {
            Redirect::to('/admin');
            return response()->json(['status' => 200]);
        }
    
        return response()->json(['status' => 401], 401);
    }

    public function logout(Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return response()->json(['status' => 200]);
    } 
}
