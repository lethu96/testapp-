<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Position;
use App\MemberProject;

class Member extends Model
{
    protected $table="members";
    public function positon()
    {
        return $this->belongsTo('App\Position', 'position_id', 'id');
    }
    public function memberProject()
    {
        return $this->belongsTo('App\MemberProject', 'meber_id', 'id');
    }
}
