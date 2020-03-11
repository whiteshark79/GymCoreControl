<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Especialidad extends Model
{
    protected $table = 'especialidades';
    protected $fillable =['nombre','descripcion','condicion'];

    public $timestamps = false;

    public function profesor(){
        return $this->hasMany('App\Profesor');
    }
}
