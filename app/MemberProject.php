<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Member;
use App\Project;

class MemberProject extends Model
{
    public function member()
    {
        return $this->hasMany('App\Member', 'meber_id', 'id');
    }
    public function project()
    {
        return $this->hasMany('App\Project', 'project_id', 'id');
    }
}
