<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUniversidadesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('universidades', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre', 100);
            $table->integer('idprovincia')->unsigned();
            $table->foreign('idprovincia')->references('id')->on('provincias');
            $table->integer('idcanton')->unsigned();
            $table->foreign('idcanton')->references('id')->on('cantones');
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
        Schema::dropIfExists('universidades');
    }
}
