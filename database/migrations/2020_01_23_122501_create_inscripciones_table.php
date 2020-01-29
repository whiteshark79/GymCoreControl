<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateInscripcionesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('inscripciones', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha_ini');
            $table->dateTime('fecha_fin');
            $table->integer('idalumno')->unsigned();
            $table->foreign('idalumno')->references('id')->on('personas');
            $table->integer('idusuario')->unsigned();
            $table->foreign('idusuario')->references('id')->on('users');
            $table->integer('idmodalidad')->unsigned();
            $table->foreign('idmodalidad')->references('id')->on('modalidades');            
            $table->decimal('abono', 4, 2);
            $table->decimal('saldo', 4, 2);
            $table->decimal('impuesto', 4, 2);
            $table->decimal('total', 11, 2);
            $table->string('observaciones', 50);
            $table->string('estado', 20);
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
        Schema::dropIfExists('inscripciones');
    }
}
