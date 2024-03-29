<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateHorariosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('horarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idlocal')->unsigned();
            $table->foreign('idlocal')->references('id')->on('locales');
            $table->time('hora_ini');
            $table->time('hora_fin');
            $table->string('periodo',10);
            $table->string('descripcion',60)->nullable();
            $table->boolean('condicion')->default(1); 
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('horarios');
    }
}
