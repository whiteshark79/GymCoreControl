<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Asistencia extends Model
{
    protected $fillable =['idinscripcion','fecha_hora','contador']; 

    public $timestamps = false;

    public function inscripcion(){
        return $this->belongsTo('App\Inscripcion');
    }

    public function alumno(){
        return $this->belongsTo('App\Alumno');
    }
}
 