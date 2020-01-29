<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->increments('id');
            $table->string('nombre',30);
            $table->string('descripcion',60)->nullable();
            $table->boolean('condicion')->default(1);
        });
        DB::table('roles')->insert(array('id'=>'1','nombre'=>'Administrador', 'descripcion'=>'Administradores de área'));
        DB::table('roles')->insert(array('id'=>'2','nombre'=>'Alumno', 'descripcion'=>'Alumno'));
        DB::table('roles')->insert(array('id'=>'3','nombre'=>'Profesor', 'descripcion'=>'Profesor/Coach'));
        DB::table('roles')->insert(array('id'=>'4','nombre'=>'Operador', 'descripcion'=>'Usuario del sistema'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
