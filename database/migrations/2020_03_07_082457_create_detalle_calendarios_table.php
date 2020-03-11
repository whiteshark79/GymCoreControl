<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleCalendariosTable extends Migration
{
    /**
     * Run the migrations.
     * 
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_calendarios', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idcalendario')->unsigned();
            $table->foreign('idcalendario')->references('id')->on('calendarios')->onDelete('cascade');
            $table->integer('idhorario')->unsigned();
            $table->foreign('idhorario')->references('id')->on('horarios');
            $table->date('dia');
            $table->integer('idprofesor')->unsigned();
            $table->foreign('idprofesor')->references('id')->on('profesores');
            $table->integer('idrutina')->unsigned();
            $table->foreign('idrutina')->references('id')->on('rutinas'); 
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_calendarios');
    }
}
