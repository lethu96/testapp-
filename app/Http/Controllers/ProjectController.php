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

    public function update(StoreCreateProject $request)
    {
        $data = $request->all();
        if ($editProject = Project::find($data['id'])) {
            if (isset($data['information'])) {
                $editProject->information = $data['information'];
            } else {
                $editProject->information =null;
            }
            if (isset($data['deadline'])) {
                $editProject->deadline = $data['deadline'];
            } else {
                $editProject->deadline = null;
            }
            $editProject->name = $data['name'];
            $editProject->type = $data['type'];
            $editProject->status = $data['status'];
            $editProject->save();
            return response()->json($editProject);
        }
        return response()->json(['message' => 'Project does not exist: '.$data['id']]);
    }
    public function edit($id)
    {
        $project = Project::find($id);
        return response()->json($project);
    }

}
