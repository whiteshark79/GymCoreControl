<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Proveedor extends Model
{
    protected $table = 'proveedores';
    protected $fillable = ['id','nombre_contacto','celular_contacto','email_contacto'];

    public $timestamps = false;

    public function persona()
    {
        return $this->belongsTo('App\Persona');
    } 
}
