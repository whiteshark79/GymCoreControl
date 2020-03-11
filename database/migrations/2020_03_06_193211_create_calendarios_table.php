<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCalendariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('calendarios', function (Blueprint $table) {
            $table->increments('id');
            $table->date('fecha_hora');
            $table->date('fecha_ini');
            $table->date('fecha_fin');
            $table->integer('idlocal')->unsigned();
            $table->foreign('idlocal')->references('id')->on('locales');            
            $table->boolean('condicion')->default(1);
            $table->timestamps();
        });
    }

    /** 
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('calendarios');
    }
}
