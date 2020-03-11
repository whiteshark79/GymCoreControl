<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateEmpresasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('empresas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('ruc',15);
            $table->string('razon_social', 60);
            $table->string('nombre', 60);
            $table->string('slogan', 100)->nullable();            
            $table->string('email', 50);
            $table->string('web', 60)->nullable();
            $table->string('nombre_propietario', 60)->nullable(); 
            $table->string('celular_propietario', 15)->nullable(); 
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
        Schema::dropIfExists('empresas');
    }
}
