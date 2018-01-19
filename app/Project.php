<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MemberProject;

class Project extends Model
{
    protected $table="projects";
    public function projectMember()
    {
        return $this->belongsTo('App\MemberProject', 'project_id', 'id');
    }
}
