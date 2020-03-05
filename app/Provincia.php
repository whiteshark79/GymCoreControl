<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Provincia extends Model
{
    protected $fillable = ['nombre','condicion'];

    public $timestamps = false;

    public function cantones(){
        return $this->hasMany('App\Canton');
    }
}
