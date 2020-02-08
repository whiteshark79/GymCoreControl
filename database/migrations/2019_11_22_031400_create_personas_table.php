<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePersonasTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('personas', function (Blueprint $table) {
            $table->increments('id');
            $table->string('tipo_documento', 2);
            $table->string('num_documento',20)->unique();
            $table->string('nombre', 60)->nullable();
            $table->string('fec_nacimiento', 12)->nullable();
            $table->string('direccion', 70)->nullable();
            $table->string('celular', 15)->nullable();            
            $table->string('email', 50)->nullable();
            $table->string('perfil', 10)->nullable();
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
        Schema::dropIfExists('personas');
    }
}
