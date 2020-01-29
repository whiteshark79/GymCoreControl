<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Inscripcion extends Model
{
    protected $table = 'inscripciones';
    protected $fillable =[
        'fecha_ini',
        'fecha_fin',
        'idalumno', 
        'idusuario',
        'idmodalidad',        
        'abono',
        'saldo',
        'impuesto',
        'total',
        'observaciones',
        'estado'
    ];
}
