<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Position;
use App\MemberProject;
use App\Project;

class Member extends Model
{
    protected $table = "members";
    protected $hidden = array('created_at', 'updated_at');

    public function position()
    {
        return $this->belongsTo('App\Position', 'position_id', 'id');
    }

    public function project()
    {
        return $this->belongsToMany('App\Project', 'member_projects', 'member_id', 'project_id');
    }
}
