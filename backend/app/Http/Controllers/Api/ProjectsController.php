<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProjectResource;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectsController extends Controller
{
    public function index(Request $request)
    {
        $projects = Project::with(['category:id,name'])->latest()->simplePaginate($request->get('limit', 6));

        return ProjectResource::collection($projects);
    }

    public function show(Request $request, Project $project)
    {
        $project->load(['category:id,name']);

        return new ProjectResource($project);
    }
}
