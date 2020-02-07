<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Servicio extends Model
{
    protected $fillable =['idclasificacion','codigo','nombre','descripcion','condicion'];

    public function clasificacion(){
        return $this->belongsTo('App\Clasificacion');
    }
} 
