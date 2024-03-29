<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateServiciosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('servicios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idclasificacion')->unsigned();
            $table->foreign('idclasificacion')->references('id')->on('clasificaciones'); 
            $table->string('codigo', 50)->nullable();
            $table->string('nombre', 100)->unique();
            $table->string('descripcion', 60)->nullable();
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
        Schema::dropIfExists('servicios');
    }
}
