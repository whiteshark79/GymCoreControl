<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Caja extends Model
{
    protected $table = 'cuadres_caja';
    protected $fillable = ['fecha_hora','inscripciones','gastos','ventas','compras','total'];
}
