<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MemberProject;
use App\Member;

class Project extends Model
{
    protected $table = "projects";
    protected $hidden = array('created_at', 'updated_at');

    public function memberproject()
    {
        return $this->belongsTo('App\MemberProject', 'member_id', 'id');
    }

            public function member()
    {
        return $this->belongsToMany('App\Member', 'member_projects', 'project_id', 'member_id');
    }
}
