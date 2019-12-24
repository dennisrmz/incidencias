<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    public function states(){
        return $this->belongsToMany('App\State', 'user_incident')->withPivot('state_id');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'user_incident')->withPivot('user_id');
    }
}
