<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Member;
use App\Project;

class MemberProject extends Model
{
    protected $table = "member_projects";
    protected $hidden = array('created_at', 'updated_at');

    public function member()
    {
        return $this->hasMany('App\Member', 'member_id', 'id');
    }
    
    public function project()
    {
        return $this->hasMany('App\Project', 'project_id', 'id');
    }
}
