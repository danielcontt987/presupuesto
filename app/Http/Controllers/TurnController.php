<?php

namespace App\Http\Controllers;

use App\Models\Turn;
use Illuminate\Http\Request;

class TurnController extends Controller
{
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $turn = Turn::create($request->all());
        return response()->json($turn, 201);
    }

    /**
     * Display a listing of the resource.
     */
    public function list(Request $request)
    {
        $turns = Turn::all();
        return response()->json($turns, 200);
    }
}
