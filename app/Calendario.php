<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Calendario extends Model
{
    protected $fillable = ['fecha_hora','idlocal','idhorario','idprofesor','idespecialidad','descripcion','condicion'];

    public function local(){
        return $this->belongsTo('App\Local');
    }

    public function profesor(){
        return $this->belorgsTo('App\Profesor');
    }

    public function especialidad(){
        return $this->belongsTo('App\Especialidad');
    }
}
