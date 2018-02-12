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
    public function index(Request $request)
    {
        $listMember= Member::all();
        foreach ($listMember as $key => $position_name) {
            $position_name->position->name;
        }
        return response()->json($listMember);
    }

    public function destroy($id)
    {
        $member = Member::findOrFail($id);
        $member->delete();
        return response()->json('Member Deleted Successfully.');
    }
    public function update(StoreCreateMember $request,$id)
    {
        $member = Member::find($id);
        $data = $request->all();
        if (isset($data['information'])) {
            $member->information = $data['information'];
        } else {
            $member->information =null;
        }
        $member->name = $data['name'];
        $member->phone_number = $data['phone_number'];
        $member->birthday = $data['birthday'];
        $countPosition = DB::table('positions')->where('id', $data['position_id'])->count();
        if ($countPosition > 0) {
                $member->position_id = $data['position_id'];
                $member->gender = $data['gender'];
            if ($request->hasFile('avatar')) {
                $file = $request->avatar;
                $file->move("img", $file->getClientOriginalName());
                $member->avatar ="/img/".$file->getClientOriginalName();
            }
            $member->save();
            return response()->json($member);
        }
        return response()->json(['message' => 'Dont exit Position_id'], 404);
    }

    public function store(StoreCreateMember $request)
    {
        $data = $request->all();
        $newMember = new Member();
        if (isset($data['information'])) {
            $newMember->information = $data['information'];
        } else {
            $newMember->information =null;
        }
        $newMember->name = $data['name'];
        $newMember->phone_number = $data['phone_number'];
        $newMember->birthday = $data['birthday'];
        $countPosition = DB::table('positions')->where('id', $data['position_id'])->count();
        if ($countPosition > 0) {
                $newMember->position_id = $data['position_id'];
                $newMember->gender = $data['gender'];
            if ($request->hasFile('avatar')) {
                $file = $request->avatar;
                $file->move("img", $file->getClientOriginalName());
                $newMember->avatar ="/img/".$file->getClientOriginalName();
            }
            $newMember->save();
            return response()->json($newMember);
        }
        return response()->json(['message' => 'Dont exit Position_id'], 404);
    }

        public function edit($id)
    {
        $member = Member::find($id);
        return response()->json($member);
    }
}
