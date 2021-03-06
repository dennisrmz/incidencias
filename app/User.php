<?php

namespace App;

use Caffeinated\Shinobi\Traits\ShinobiTrait;
use Illuminate\Notifications\Notifiable;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{
    use Notifiable;
    use ShinobiTrait;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'username', 'es_lider', 'departaments_id', 'equipments_id',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    public function equipment(){
        return $this->belongsTo(Equipment::class);
    }

    public function departament(){
        return $this->belongsTo(Departament::class);
    }

    public function incidents(){
        return $this->belongsToMany('App\Incident', 'user_incident')->withPivot('fecha_finalizacion');
    }
}
