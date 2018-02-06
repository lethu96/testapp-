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
        return $listProject;
    }

    public function destroy($id)
    {
        $project = Project::find($id);
        $project->delete();
        return response()->json('Project Deleted Successfully.');
    }

    public function store(StoreCreateProject $request)
    {
        $data = $request->all();
        $newProject = new Project();
        $newProject->name = $data['name'];
        if (isset($data['information'])) {
            $newProject->information = $data['information'];
        } else {
            $newProject->information =null;
        }
        if (isset($data['deadline'])) {
            $newProject->deadline = $data['deadline'];
        } else {
            $newProject->deadline =null;
        }
        $newProject->type = $data['type'];
        $newProject->status = $data['status'];
        $newProject->save();
        return response()->json($newProject);
    }

    public function update(StoreCreateProject $request, $id)
    {
            $project = Project::find($id);
            $project->deadline = $data['deadline'];
            $project->information = $data['information'];
            $project->name = $data['name'];
            $project->type = $data['type'];
            $project->status = $data['status'];
            $project->save();
             return response()->json('Project Updated Successfully.');
    }

    public function edit($id)
    {
        $project = Project::find($id);
        return response()->json($project);
    }

}
