<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
 
class Alumno extends Model 
{
    protected $fillable = ['id','sexo','estado_civil','hijos','sector','idprofesion','idlocal','sit_laboral','empresa','cargo',
        'estudiante','iduniversidad','edad','peso','estatura','nivel_actividad','tipo_actividad','objetivo'];

    public $timestamps = false;

    public function persona(){
        return $this->belongsTo('App\Persona');
    }

    public function profesion(){
        return $this->belongsTo('App\Profesion');
    }

    public function universidad(){
        return $this->belongsTo('App\Universidad');
    }

    public function local(){
        return $this->belongsTo('App\Local');
    }
     
}
