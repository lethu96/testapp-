<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCreateMemberProject;
use App\Http\Requests\StoreEditMemberProject;
use App\MemberProject;

class MemberProjectController extends Controller
{
    public function index()
    {
        $listMemberProject = MemberProject::all()->toArray();
        return $listMemberProject;
    }

    public function create()
    {
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function store(StoreCreateMemberProject $request)
    {
        $data = $request->all();
        $newMp = new MemberProject();
        $newMp->meber_id = $data['meber_id'];
        $newMp->project_id = $data['project_id'];
        $newMp->role = $data['role'];
        $newMp->save();
        return $newMp;
    }

    public function update(StoreCreateMemberProject $request)
    {
        $data = $request->all();
        if ($editMp = MemberProject::find($data['id'])) {
            $editMp->meber_id = $data['meber_id'];
            $editMp->project_id = $data['project_id'];
            $editMp->role = $data['role'];
            $editMp->save();
            return $editMp;
        }
        return ["message" => "Doesn't Exit item"];
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if ($deleteMp = MemberProject::find($id)) {
            $deleteMp->delete();
        $listMemberProject = MemberProject::all()->toArray();
        return $listMemberProject;
        }
        return ["message" => "Doesn't Exit item MemberProject"];
    }
}
