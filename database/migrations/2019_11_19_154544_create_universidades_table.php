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
            $table->integer('idcanton')->unsigned();
            $table->boolean('condicion')->default(1);

            $table->timestamps();

            $table->foreign('idprovincia')->references('id')->on('provincias');
            $table->foreign('idcanton')->references('id')->on('cantones');
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
