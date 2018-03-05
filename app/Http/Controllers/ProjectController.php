<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCreateProject;
use App\Http\Requests\StoreEditProject;
use App\Project;
use Illuminate\Support\Facades\Response;

class ProjectController extends Controller
{
    public function index(Request $request)
    {
        $listProject = Project::all()->toArray();
        return response()->json($listProject);
    }

    public function destroy($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();
        return response()->json(['message'=>'Project Deleted Successfully.']);
    }

    public function store(StoreCreateProject $request)
    {
        $data = $request->all();
        $project = new Project();
        $project->deadline = $data['deadline'];
        $project->information = $data['information'];
        $project->name = $data['name'];
        $project->type = $data['type'];
        $project->status = $data['status'];
        $project->save();
        return response()->json($project);
    }

    public function update(StoreCreateProject $request, $id)
    {
        $project = Project::find($id);
        $data = $request->all();
        $project->deadline = $data['deadline'];
        $project->information = $data['information'];
        $project->name = $data['name'];
        $project->type = $data['type'];
        $project->status = $data['status'];
        $project->save();
        return response()->json('Project Updated Successfully.');
    }

    public function show($id)
    {
        $project = Project::find($id);
        return response()->json($project);
    }
}
