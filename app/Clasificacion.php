<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Clasificacion extends Model
{
    protected $table = 'clasificaciones';
    protected $fillable = ['nombre','descripcion','condicion'];

    public function servicios(){
       return $this->hasMany('App\Servicio');
   } 
}
