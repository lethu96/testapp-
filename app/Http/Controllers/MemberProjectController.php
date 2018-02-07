<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCreateMemberProject;
use App\Http\Requests\StoreEditMemberProject;
use App\MemberProject;
use App\Member;
use App\Project;
use DB;

class MemberProjectController extends Controller
{
    public function index()
    {
        $listMemberProject = MemberProject::all()->toArray();
        return $listMemberProject;
    }

    public function store(StoreCreateMemberProject $request)
    {
        $data = $request->all();
        $newMp = new MemberProject();
        $countCreate = MemberProject::where('member_id', $data['member_id'])
                                    ->where('project_id', $data['project_id'])->count();
        if ($countCreate > 0) {
            return response()->json(['message'=>'this member_id and project_id have exit']);
        }
        $countMemberId = DB::table('members')->where('id', $data['member_id'])->count();
        $countProjectId = DB::table('projects')->where('id', $data['project_id'])->count();
        if ($countMemberId>0 && $countProjectId >0) {
                $newMp->member_id = $data['member_id'];
                $newMp->project_id = $data['project_id'];
                $newMp->role = $data['role'];
                $newMp->save();
                return response()->json($newMp);
        }
            return response()->json(['message'=>'this member_id or project_id don t exit']);
    }

    public function update(StoreCreateMemberProject $request)
    {
        $data = $request->all();
        $memberId = $data['member_id'];
        $projectId = $data['project_id'];
        $countDelete = MemberProject::where('member_id', $memberId)
                                    ->where('project_id', $projectId)->count();
        if ($countDelete > 0) {
            $newcountEdit = MemberProject::where('member_id', $data['new_member_id'])
                                        ->where('project_id', $data['new_project_id'])->count();
            if ($newcountEdit > 0) {
                return response()->json(['message' => 'Member Project have exit'], 404);
            } else {
                $countMemberId = DB::table('members')->where('id', $data['new_member_id'])->count();
                $countProjectId = DB::table('projects')->where('id', $data['new_project_id'])->count();
                if ($countMemberId > 0 && $countProjectId > 0) {
                    MemberProject::where('member_id', $memberId)
                                ->where('project_id', $projectId)->delete();
                    $editMp = new MemberProject();
                    $editMp->member_id = $data['new_member_id'];
                    $editMp->project_id = $data['new_project_id'];
                    $editMp->role = $data['role'];
                    $editMp->save();
                    return response()->json($editMp);
                } else {
                    return response()->json(['message' => 'this member_id or project_id don t exit'], 404);
                }
            }
        } else {
            return response()->json(['message' => 'dont exit Member Project you find'], 404);
        }
    }

    public function destroy(Request $request)
    {
        $data = $request->all();
        if (isset($data['member_id']) && isset($data['project_id'])) {
            $memberId = $data['member_id'];
            $projectId = $data['project_id'];
            $countDelete = MemberProject::where('member_id', $memberId)
            ->where('project_id', $projectId)->count();
            if ($countDelete > 0) {
                MemberProject::where('member_id', $memberId)
                ->where('project_id', $projectId)->delete();
                return response()->json([
                    'message' => 'Delete Item Sucess'
                ]);
            }
            return response()->json(['message' => 'dont exit memberproject you find'], 404);
        }
        return response()->json(['message' => 'please enter member_id and project_id you want delete']);
    }
}
