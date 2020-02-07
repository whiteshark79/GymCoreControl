<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDetalleGastosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('detalle_gastos', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idgasto')->unsigned();
            $table->foreign('idgasto')->references('id')->on('gastos')->onDelete('cascade');
            $table->integer('idservicio')->unsigned();
            $table->foreign('idservicio')->references('id')->on('servicios');
            $table->integer('cantidad');
            $table->decimal('precio', 11, 2);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('detalle_gastos');
    }
}
