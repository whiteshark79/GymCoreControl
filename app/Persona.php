<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;

class Persona extends Model
{
    protected $fillable =['tipo_documento','num_documento', 'nombres','apellidos','fec_nacimiento','direccion','celular','email','perfil'];

     public function profesor(){
         return $this->hasOne('App\Profesor');
     }

     public function alumno(){
         return $this->hasOne('App\Alumno');
     }

     public function proveedor(){
         return $this->hasOne('App\Proveedor');
    }

    public function user(){
        return $this->hasOne('App\User');
    }
}

