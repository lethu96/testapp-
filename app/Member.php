<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Position;
use App\MemberProject;

class Member extends Model
{
    protected $table = "members";
    protected $hidden = array('created_at', 'updated_at');

    public function position()
    {
        return $this->belongsTo('App\Position', 'position_id', 'id');
    }
    
    public function memberProject()
    {
        return $this->belongsTo('App\MemberProject', 'member_id', 'id');
    }
}
