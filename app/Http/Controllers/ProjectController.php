<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCreateProject;
use App\Project;

class ProjectController extends Controller
{
    public function listProject(Request $request)
    {
        $listProject= Project::all()->toArray();
        return $listProject;
    }
    public function deleteProject($id)
    {
        $member=Project::find($id);
        $member ->delete();
        return "xóa thành công" ;
    }
    public function createProject(StoreCreateProjectS $request)
    {

        $data=$request->all();
        $newProject=new Project();
        $newProject->name=$data['name'];
        $newProject->information=$data['information'];
        $newProject->deadline=$data['deadline'];
        $newProject->type=$data['type'];
        $newProject->status=$data['status'];
        $newProject->save();
        return response()->json($newProject);
    }
    public function getEditProject($id)
    {
        $item=Project::find($id)->toArray();
        return view('editproject', ['id'=>$id, 'item'=>$item]);
    }
    public function editProject(StoreCreateProject $request)
    {
        $data=$request->all();
        $editProject=Project::find($data['id']);
        $editProject->name=$data['name'];
        $editProject->information=$data['information'];
        $editProject->deadline=$data['deadline'];
        $editProject->type=$data['type'];
        $editProject->status=$data['status'];
        $editProject->save();
        return $editProject;
    }
}
