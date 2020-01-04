<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Incident extends Model
{
    protected $fillable = ['nombre','codigo', 'usuario_asigno', 'descripcion', 'estado_aprobacion', 'fecha_asignacion'];

    public function states(){
        return $this->belongsToMany('App\State', 'user_incident')->withPivot('state_id');
    }

    public function users(){
        return $this->belongsToMany('App\User', 'user_incident')->withPivot('fecha_finalizacion');
    }
}
