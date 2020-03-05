<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Universidad extends Model
{
    protected $table = 'universidades';
    protected $fillable = ['nombre','idprovincia','idcanton','condicion'];

    public $timestamps = false;

    public function personas(){
        return $this->hasMany('App\Persona');
    }
}
