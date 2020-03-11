<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{    
    protected $fillable =['ruc','razon_social','nombre','slogan',
    'email','web','nombre_propietario','celular_propietario','condicion'];

    public $timestamps = false; 

    public function locales(){
        return $this->hasMany('App\Local');
    } 
}
