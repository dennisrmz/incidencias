<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    public function users(){
        return $this->hasMany('App/User');
      }
}
