<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresa extends Model
{
    protected $table = 'empresa';
    protected $fillable =['nombre','slogan','direccion','telefono','email','web'];

    public $timestamps = false;
}
