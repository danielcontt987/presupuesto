<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectController extends Controller
{
    public function list()
    {
        $businessId = Auth::user()->getBusiness();
        $projects = Project::where('business_id', $businessId)->get();
        return response()->json(['projects' => $projects, 'status' => 'success'], 200);
    }
}
