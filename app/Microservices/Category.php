<?php

namespace App\Microservices;

use App\Models\Category as CategoryModel;
use Illuminate\Support\Facades\Auth;

class Category extends Microservice
{
    public static function list() 
    {
        return CategoryModel::where('business_id', Auth::user()->getBusiness())->get();
    }
    
    public static function store($request) 
    {
        return CategoryModel::create([
            'name' => $request->name,
            'business_id' => Auth::user()->getBusiness(),
        ]);
    }
}
