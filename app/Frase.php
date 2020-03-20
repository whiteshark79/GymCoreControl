<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Frase extends Model
{
    protected $fillable =['descripcion','autor','condicion'];

    public $timestamps = false;
}
