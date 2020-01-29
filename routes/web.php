<?php

Route::group(['middleware'=>['guest']],function(){

    Route::get('/','Auth\LoginController@showLoginForm'); 
    Route::post('/login', 'Auth\LoginController@login')->name('login');   
});
 

Route::group(['middleware'=>['auth']],function(){

    Route::post('/logout', 'Auth\LoginController@logout')->name('logout');
    Route::get('/dashboard','DashboardController'); 
     
    Route::get('/main', function () {
        return view('contenido/contenido');
    })->name('main');

    Route::group(['middleware' => ['Administrador']], function () {

        Route::get('/user', 'UserController@index');
        Route::post('/user/registrar', 'UserController@store');
        Route::put('/user/actualizar', 'UserController@update');
        Route::put('/user/desactivar', 'UserController@desactivar');
        Route::put('/user/activar', 'UserController@activar');

        Route::get('/rol', 'RolController@index');
        Route::post('/rol/registrar', 'RolController@store');
        Route::put('/rol/actualizar', 'RolController@update');
        Route::put('/rol/eliminar', 'RolController@destroy');
        Route::put('/rol/desactivar', 'RolController@desactivar');
        Route::put('/rol/activar', 'RolController@activar');
        Route::get('/rol/selectRol', 'RolController@selectRol');

        Route::get('/alumno', 'AlumnoController@index');
        Route::post('/alumno/registrar', 'AlumnoController@store');
        Route::put('/alumno/actualizar', 'AlumnoController@update');
        Route::get('/alumno/selectAlumno', 'AlumnoController@selectAlumno');

        Route::get('/cliente', 'ClienteController@index');
        Route::post('/cliente/registrar', 'ClienteController@store');
        Route::put('/cliente/actualizar', 'ClienteController@update');                
        Route::get('/cliente/selectCliente', 'ClienteController@selectCliente');

        Route::get('/proveedor', 'ProveedorController@index');
        Route::post('/proveedor/registrar', 'ProveedorController@store');
        Route::put('/proveedor/actualizar', 'ProveedorController@update');        
        Route::get('/proveedor/selectProveedor', 'ProveedorController@selectProveedor');

        Route::get('/profesor', 'ProfesorController@index');
        Route::post('/profesor/registrar', 'ProfesorController@store');
        Route::put('/profesor/actualizar', 'ProfesorController@update');        
        Route::get('/profesor/selectProveedor', 'ProfesorController@selectProfesor');

        Route::get('/ingreso', 'IngresoController@index');
        Route::post('/ingreso/registrar', 'IngresoController@store');        
        Route::put('/ingreso/desactivar', 'IngresoController@desactivar');        
        Route::get('/ingreso/obtenerCabecera', 'IngresoController@obtenerCabecera');
        Route::get('/ingreso/obtenerDetalles', 'IngresoController@obtenerDetalles');

        Route::get('/venta', 'VentaController@index');
        Route::post('/venta/registrar', 'VentaController@store');        
        Route::put('/venta/desactivar', 'VentaController@desactivar');        
        Route::get('/venta/obtenerCabecera', 'VentaController@obtenerCabecera');
        Route::get('/venta/obtenerDetalles', 'VentaController@obtenerDetalles');
        Route::get('/venta/pdf/{id}', 'VentaController@pdf')->name('venta_pdf');

        Route::get('/inscripcion', 'InscripcionController@index');
        Route::post('/inscripcion/registrar', 'InscripcionController@store');
        Route::put('/inscripcion/actualizar', 'InscripcionController@update');        
        Route::put('/inscripcion/desactivar', 'InscripcionController@desactivar'); 

        Route::get('/especialidad', 'EspecialidadController@index');
        Route::post('/especialidad/registrar', 'EspecialidadController@store');
        Route::put('/especialidad/actualizar', 'EspecialidadController@update');
        Route::put('/especialidad/eliminar', 'EspecialidadController@destroy');
        Route::put('/especialidad/desactivar', 'EspecialidadController@desactivar');
        Route::put('/especialidad/activar', 'EspecialidadController@activar');
        Route::get('/especialidad/selectEspecialidad', 'EspecialidadController@selectEspecialidad');

        Route::get('/profesion', 'ProfesionController@index');
        Route::post('/profesion/registrar', 'ProfesionController@store');
        Route::put('/profesion/actualizar', 'ProfesionController@update');
        Route::put('/profesion/desactivar', 'ProfesionController@desactivar');
        Route::put('/profesion/activar', 'ProfesionController@activar');
        Route::get('/profesion/selectProfesion', 'ProfesionController@selectProfesion');

        Route::get('/universidad', 'UniversidadController@index');
        Route::post('/universidad/registrar', 'UniversidadController@store');
        Route::put('/universidad/actualizar', 'UniversidadController@update');
        Route::put('/universidad/desactivar', 'UniversidadController@desactivar');
        Route::put('/universidad/activar', 'UniversidadController@activar');
        Route::get('/universidad/selectUniversidad', 'UniversidadController@selectUniversidad');

        Route::get('/provincia', 'ProvinciaController@index');
        Route::post('/provincia/registrar', 'ProvinciaController@store');
        Route::put('/provincia/actualizar', 'ProvinciaController@update');
        Route::put('/provincia/desactivar', 'ProvinciaController@desactivar');
        Route::put('/provincia/activar', 'ProvinciaController@activar');
        Route::get('/provincia/selectProvincia', 'ProvinciaController@selectProvincia');

        Route::get('/canton', 'CantonController@index');
        Route::post('/canton/registrar', 'CantonController@store');
        Route::put('/canton/actualizar', 'CantonController@update');
        Route::put('/canton/desactivar', 'CantonController@desactivar');
        Route::put('/canton/activar', 'CantonController@activar');
        Route::get('/canton/selectCanton', 'CantonController@selectCanton');

        Route::get('/articulo', 'ArticuloController@index');
        Route::post('/articulo/registrar', 'ArticuloController@store');
        Route::put('/articulo/actualizar', 'ArticuloController@update');
        Route::put('/articulo/eliminar', 'ArticuloController@destroy');
        Route::put('/articulo/desactivar', 'ArticuloController@desactivar');
        Route::put('/articulo/activar', 'ArticuloController@activar');
        Route::get('/articulo/buscarArticulo', 'ArticuloController@buscarArticulo');
        Route::get('/articulo/buscarArticuloVenta', 'ArticuloController@buscarArticuloVenta');
        Route::get('/articulo/listarArticulo', 'ArticuloController@listarArticulo');        
        Route::get('/articulo/listarArticuloVenta', 'ArticuloController@listarArticuloVenta');
        Route::get('/articulo/listarPDF', 'ArticuloController@listarPDF')->name('articulos_pdf');
                
        Route::get('/categoria', 'CategoriaController@index');
        Route::post('/categoria/registrar', 'CategoriaController@store');
        Route::put('/categoria/actualizar', 'CategoriaController@update');
        Route::put('/categoria/eliminar', 'CategoriaController@destroy');
        Route::put('/categoria/desactivar', 'CategoriaController@desactivar');
        Route::put('/categoria/activar', 'CategoriaController@activar');
        Route::get('/categoria/selectCategoria', 'CategoriaController@selectCategoria');
        Route::get('/categoria/selectCategoriaB', 'CategoriaController@selectCategoriaB');

        Route::get('/modalidad', 'ModalidadController@index');
        Route::post('/modalidad/registrar', 'ModalidadController@store');
        Route::put('/modalidad/actualizar', 'ModalidadController@update');
        Route::put('/modalidad/eliminar', 'ModalidadController@destroy');
        Route::put('/modalidad/desactivar', 'ModalidadController@desactivar');
        Route::put('/modalidad/activar', 'ModalidadController@activar');
        Route::get('/modalidad/selectModalidad', 'ModalidadController@selectModalidad');

    });

    Route::group(['middleware' => ['Operador']], function () {

    });

    Route::group(['middleware' => ['Alumno']], function () {
        
    });

    Route::group(['middleware' => ['Profesor']], function () {
        
    });
});




Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');
