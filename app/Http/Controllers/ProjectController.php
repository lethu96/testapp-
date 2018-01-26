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

    public function destroy(Request $request)
    {
        $id = $request->id;
        if ($project = Project::find($id)) {
            $project->delete();
            $listProject = Project::all()->toArray();
            return $listProject;
        }
        return ["message" => "Doesn't exit this item"];
    }

    public function store(StoreCreateProject $request)
    {
        $data = $request->all();
        $newProject = new Project();
        $newProject->name = $data['name'];
        $newProject->information = $data['information'];
        $newProject->deadline = $data['deadline'];
        $newProject->type = $data['type'];
        $newProject->status = $data['status'];
        $newProject->save();
        return $newProject;
    }

    public function update(StoreCreateProject $request)
    {
        $data = $request->all();
        if ($editProject = Project::find($data['id'])) {
            $editProject->name = $data['name'];
            $editProject->information = $data['information'];
            $editProject->deadline = $data['deadline'];
            $editProject->type = $data['type'];
            $editProject->status = $data['status'];
            $editProject->save();
            return $editProject;
        }
        return ["message" => "Doesn't Exit item Project"];
    }
}
