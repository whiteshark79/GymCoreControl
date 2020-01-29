<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesor extends Model 
{
    protected $table = 'profesores';
    protected $fillable = ['id','horario','idespecialidad','sueldo_hora'];

    public $timestamps = false;

    public function persona(){
        return $this->belongsTo('App\Persona');
    }

    public function especialidad(){
        return $this->belongsTo('App\Especialidad');
    }
}
