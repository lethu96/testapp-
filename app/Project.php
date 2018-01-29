<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\MemberProject;

class Project extends Model
{
    protected $table = "projects";
    protected $hidden = array('created_at', 'updated_at');
    
    public function projectMember()
    {
        return $this->belongsTo('App\MemberProject', 'project_id', 'id');
    }
}
