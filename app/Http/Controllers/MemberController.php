<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreCreateMember;
use App\Member;
use App\User;
use App\Position;
use Validator;
use DB;

class MemberController extends Controller
{
    public function listMember(Request $request)
    {
        $listMember= Member::all()->toArray();
        return $listMember ;
    }

    public function deleteMember($id)
    {
        $member=Member::find($id);
        $member ->delete();
        return "xóa thành công" ;
    }

    public function getCreateMember()
    {
        return view('test');
    }

    public function getEditMember($id)
    {
        $item = Member::find($id)->toArray();
        return view('test', ['id'=>$id, 'item'=>$item]);
    }

    public function editMember(StoreCreateMember $request)
    {
        $data=$request->all();
        $memberEdit=Member::find($data['id']);
        $memberEdit->name=$data['name'];
        $memberEdit->phone_number=$data['phone_number'];
        $memberEdit->information=$data['information'];
        $memberEdit->birthday=$data['birthday'];
        $memberEdit->position_id=$data['position_id'];
        $memberEdit->gender=$data['gender'];
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $file->move("img", $file->getClientOriginalName());
            $memberEdit->avatar = $file->getClientOriginalName();
        }
        $memberEdit->save();
        return $memberEdit;
    }

    public function addMember(StoreCreateMember $request)
    {
        $data=$request->all();
        $newMember=new Member();
        $newMember->name=$data['name'];
        $newMember->phone_number=$data['phone_number'];
        $newMember->information=$data['information'];
        $newMember->birthday=$data['birthday'];
        $newMember->position_id=$data['position_id'];
        $newMember->gender=$data['gender'];
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $file->move("img", $file->getClientOriginalName());
            $newMember->avatar = $file->getClientOriginalName();
        }
        $newMember->save();
        return $newMember;
    }
}
