<?php

namespace App;
 
use Illuminate\Database\Eloquent\Model;
 
class Horario extends Model
{
    protected $fillable =['idlocal','hora_ini','hora_fin','periodo','descripcion','condicion'];

    public $timestamps = false;
}
