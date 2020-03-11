<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration; 

class CreateProfesoresTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('profesores', function (Blueprint $table) {
            $table->integer('id')->unsigned();
			$table->foreign('id')->references('id')->on('personas')->onDelete('cascade');
            $table->string('horario', 1)->nullable(); 
            $table->integer('idespecialidad')->unsigned();
			$table->foreign('idespecialidad')->references('id')->on('especialidades');
            $table->decimal('sueldo_hora', 11, 2);        

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('profesores');
    }
}
