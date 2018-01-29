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
        $listMember= Member::all()->toArray();
        return $listMember;
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if ($member = Member::find($id)) {
            $member->delete();
            $listMember = Member::all() ->toArray();
            return response()->json([
                'message' => 'Delete success '.$id
            ]);
        }
        return response()->json([
                'status' => '404'
            ], 404);
    }

    public function update(StoreCreateMember $request)
    {
        $data = $request->all();
        if ($memberEdit = Member::find($data['id'])) {
            $memberEdit->name = $data['name'];
            $memberEdit->phone_number = $data['phone_number'];
            $memberEdit->information = $data['information'];
            $memberEdit->birthday = $data['birthday'];
            $memberEdit->position_id = $data['position_id'];
            $memberEdit->gender = $data['gender'];
            if ($request->hasFile('avatar')) {
                $file = $request->avatar;
                $file->move("img", $file->getClientOriginalName());
                $memberEdit->avatar = $file->getClientOriginalName();
            }
            $memberEdit->save();
            return response()->json($memberEdit);
        }
        return response()->json([
                'message' => 'Member does not exist: '.$data['id']
            ]);
    }

    public function store(StoreCreateMember $request)
    {
        $data = $request->all();
        $newMember = new Member();
        $newMember->name = $data['name'];
        $newMember->phone_number = $data['phone_number'];
        $newMember->information = $data['information'];
        $newMember->birthday = $data['birthday'];
        $newMember->position_id = $data['position_id'];
        $newMember->gender = $data['gender'];
        if ($request->hasFile('avatar')) {
            $file = $request->avatar;
            $file->move("img", $file->getClientOriginalName());
            $newMember->avatar = $file->getClientOriginalName();
        }
        $newMember->save();
        return response()->json($newMember);
    }
}
