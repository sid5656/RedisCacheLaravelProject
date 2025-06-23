<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;


use App\Models\Project;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;

class ProjectController extends Controller
{
    public function index()
    {
        $page = request()->get('page', 1);
        return Cache::remember('projects.page.' . $page, 60, function () {
            return Project::paginate(10);
        });
    }

    public function store(StoreProjectRequest $request)
    {   
        
        $project = Project::create($request->validated());
        return response()->json($project, 201);
    }

    public function show(Project $project)
    {
        return $project;
    }

    public function update(UpdateProjectRequest $request, Project $project)
    { 
        $project->update($request->validated());
        return $project;
    }

    public function destroy(Project $project)
    {
        $project->delete();
        return response()->noContent();
    }
    
}
