<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocalesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locales', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idempresa')->unsigned();
            $table->foreign('idempresa')->references('id')->on('empresas');
            $table->string('nombre',30);
            $table->string('descripcion',60)->nullable();
            $table->string('telefono',15)->nullable();
            $table->string('direccion',60);
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
        Schema::dropIfExists('locales');
    }
}
