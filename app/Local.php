<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Local extends Model
{
    protected $table = 'locales';
    protected $fillable = ['idempresa','nombre','descripcion','telefono','direccion','condicion'];

    public $timestamps = false; 

    public function empresa(){
        return $this->belongsTo('App\Empresa');
    } 
}
