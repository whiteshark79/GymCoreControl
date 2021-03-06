<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Canton extends Model
{
    protected $table = 'cantones';
    protected $fillable = ['nombre','idprovincia','condicion'];

    public $timestamps = false;

    public function provincia(){
        return $this->belongsTo('App\Provincia');
    }
}
