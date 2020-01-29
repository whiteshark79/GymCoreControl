<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Profesion extends Model
{
    protected $table = 'profesiones';
    //protected $primarykey = 'id';
    protected $fillable = ['codigo','nombre','provincia_id','canton_id','condicion'];

    public function personas(){
        return $this->hasMany('App\Persona');
    }
}
