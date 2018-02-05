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
        return response()->json($listMember);
    }

    public function destroy(Request $request)
    {
        $id = $request->id;
        if ($member = Member::find($id)) {
            $member->delete();
            $listMember = Member::all() ->toArray();
            return response()->json([
                'message' => 'Delete success Member '.$id
            ]);
        }
        return response()->json(['message' => 'Dont exit member'.$id], 404);
    }

    public function update(StoreCreateMember $request)
    {
        $data = $request->all();
        if ($memberEdit = Member::find($data['id'])) {
            $memberEdit->name = $data['name'];
            $memberEdit->phone_number = $data['phone_number'];
            if (isset($data['information'])) {
                $memberEdit->information = $data['information'];
            } else {
                $memberEdit->information =null;
            }
            $memberEdit->birthday = $data['birthday'];
            $countPosition = DB::table('positions')->where('id', $data['position_id'])->count();
            if ($countPosition > 0) {
                $memberEdit->position_id = $data['position_id'];
                $memberEdit->gender = $data['gender'];
                if ($request->hasFile('avatar')) {
                    $file = $request->avatar;
                    $file->move("img", $file->getClientOriginalName());
                    $memberEdit->avatar = $file->getClientOriginalName();
                }
                $memberEdit->save();
                return response()->json($memberEdit);
            } else {
                return response()->json(['message' => 'Dont exit Position_id'], 404);
            }
        }
        return response()->json([
                'message' => 'Member does not exist: '.$data['id']
            ]);
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
                $newMember->avatar = $file->getClientOriginalName();
            }
            $newMember->save();
            return response()->json($newMember);
        }
        return response()->json(['message' => 'Dont exit Position_id'], 404);
    }
}
