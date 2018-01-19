<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Member;

class Position extends Model
{
    public function member()
    {
        return $this->hasMany('App\Member', 'position_id', 'id');
    }
}
