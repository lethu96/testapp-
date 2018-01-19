<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCreateMemberProject;
use App\MemberProject;

class MemberProjectController extends Controller
{
    public function listMemberProject()
    {
        $listMemberProject=MemberProject::all()->toArray();
        return $listMemberProject;
    }
    public function deleteMemberProject($id)
    {
        $deleteMemberProject=MemberProject::find($id);
        $deleteMemberProject->delete();
        return "delete item successful";
    }
    public function createMemberProject(StoreCreateMemberProject $request)
    {
        $data= $request->all();
        $newMp=new MemberProject();
        $newMp->meber_id=$data['member_id'];
        $newMp->project_id=$data['project_id'];
        $newMp->role=$data['role'];
        $newMp->save();
        return $newMp;
    }
    public function getEditMemberProject($id)
    {
             $item=MemberProject::find($id)->toArray();
             return view('test_edit', ['id'=>$id, 'item'=>$item]);
    }
    public function editMemberProject(StoreCreateMemberProject $request)
    {
        $data=$request->all();
        $editMp=MemberProject::find($data['id']);
        $editMp->meber_id=$data['member_id'];
        $editMp->project_id=$data['project_id'];
        $editMp->role=$data['role'];
        $editMp->save();
        return $editMp;
    }
}
