<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\ProjectColums;
use App\Models\ProjectDetail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Svg\Tag\Rect;

class ProjectController extends Controller
{
    public function list()
    {
        $businessId = Auth::user()->getBusiness();
        $projects = Project::where('business_id', $businessId)->get();
        return response()->json(['projects' => $projects, 'status' => 'success'], 200);
    }

    public function get(Request $request)
    {
        $id = $request->input('id');
        $id = intval($id);
        $project = Project::where('id', $id)->with(['columns' => function ($query) {
            $query->with('details');
            $query->orderBy('id', 'desc');
        }])->first();
        if ($project) {
            return response()->json(['project' => $project, 'status' => 'success'], 200);
        } else {
            return response()->json(['message' => 'Project not found', 'status' => 'error'], 404);
        }
    }

    public function updateCard(Request $request)
    {
        $cardId = $request->input('cardId');
        $sourceColId = $request->input('sourceColId');
        $targetColId = $request->input('targetColId');


        $projectDetail = ProjectDetail::where('id', $cardId)->first();
        if (!$projectDetail) {
            return response()->json(['message' => 'Card not found', 'status' => 'error'], 404);
        }
        $projectDetail->project_colums_id = $targetColId;
        $projectDetail->save();
        return response()->json(['message' => 'Card updated successfully', 'status' => 'success'], 200);
    }

    public function store(Request $request)
    {

        $businessId = Auth::user()->getBusiness();
        $project = new Project();
        $project->name = $request->input('name');
        $project->description = $request->input('description');
        $project->name_client = $request->input('client_name');
        $project->business_id = $businessId;
        $project->save();

        ProjectColums::create([
            'name' => 'Por hacer',
            'project_id' => $project->id,
            'project_detail_id' => $project->id,
        ]);

        ProjectColums::create([
            'name' => 'pending',
            'project_id' => $project->id,
            'project_detail_id' => $project->id,
        ]);

        ProjectColums::create([
            'name' => 'En progreso',
            'status' => 'in_progress',
            'project_id' => $project->id,
            'project_detail_id' => $project->id,
        ]);

        ProjectColums::create([
            'name' => 'En revisión',
            'status' => 'in_review',
            'project_id' => $project->id,
            'project_detail_id' => $project->id,
        ]);

        ProjectColums::create([
            'name' => 'Finalizado',
            'status' => 'done',
            'project_id' => $project->id,
            'project_detail_id' => $project->id,
        ]);

        return response()->json(['message' => 'Project created successfully', 'status' => 'success'], 200);
    }
}
