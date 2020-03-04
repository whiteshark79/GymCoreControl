<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCuadresCajaTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('cuadres_caja', function (Blueprint $table) {
            $table->increments('id');
            $table->dateTime('fecha_hora');
            $table->decimal('inscripciones', 11, 2);
            $table->decimal('gastos', 11, 2);
            $table->decimal('ventas', 11, 2);
            $table->decimal('compras', 11, 2);
            $table->decimal('total', 11, 2);
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
        Schema::dropIfExists('cuadres_caja');
    }
}
