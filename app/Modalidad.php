<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Modalidad extends Model
{
    protected $table = 'modalidades';
    protected $fillable =['nombre','descripcion','duracion','precio','condicion'];
}
