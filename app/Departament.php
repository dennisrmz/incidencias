<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Departament extends Model
{
  protected $fillable = ['nombre', 'id_lider', 'activo'];

  public function users()
  {
    return $this->hasMany('App/User');
  }

  public function equipment()
  {
    return $this->hasMany('App/Equipment');
  }
}
