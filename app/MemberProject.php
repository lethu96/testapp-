<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Member;
use App\Project;

class MemberProject extends Model
{
    public $timestamps = false;
    protected $table = "member_projects";
    protected $hidden = array('id', 'created_at', 'updated_at');

    public function showMember($id)
    {
        $project=Project::find($id)->member;
        return $project;
    }
}
