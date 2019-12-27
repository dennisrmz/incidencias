<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Equipment extends Model
{
    protected $fillable = ['nombre'];
    
    public function users(){
        return $this->hasMany('App/User');
      }

      public function departament(){
        return $this->belongsTo(Departament::class);
    }
}
