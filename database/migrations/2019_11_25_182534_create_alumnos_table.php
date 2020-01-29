<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration; 

class CreateAlumnosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alumnos', function (Blueprint $table) {
            $table->integer('id')->unsigned();
            $table->string('cod_socio',20);
            $table->string('sexo',2)->nullable();
            $table->string('estado_civil',2)->nullable();
            $table->string('hijos',1)->nullable();
            $table->string('sector', 1)->nullable();
            $table->integer('idprofesion')->unsigned();
            $table->string('sit_laboral', 1)->nullable();
            $table->string('empresa', 50)->nullable();
            $table->string('cargo', 30)->nullable(); 
            $table->string('estudiante', 2)->nullable();
            $table->integer('iduniversidad')->unsigned();
            $table->string('edad', 3)->nullable();
            $table->string('peso', 3)->nullable();
            $table->string('estatura', 3)->nullable();
            $table->string('nivel_actividad', 2)->nullable();
            $table->string('tipo_actividad', 2)->nullable();
            $table->string('objetivo', 2)->nullable();

            $table->foreign('id')->references('id')->on('personas')->onDelete('cascade');
            $table->foreign('idprofesion')->references('id')->on('profesiones');
            $table->foreign('iduniversidad')->references('id')->on('universidades');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alumnos');
    }
}
