<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresaTable extends Migration
{
   
    public function up()
    {
        Schema::create('empresa', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('ruc');
            $table->string('nombre', 60);
            $table->string('slogan', 150);
            $table->string('direccion', 100);
            $table->string('telefono', 15)->nullable(); 
            $table->string('email', 50)->nullable();
            $table->string('web', 60)->nullable();

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('empresa');
    }
}
