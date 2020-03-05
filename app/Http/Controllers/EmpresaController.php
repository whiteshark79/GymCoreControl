<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa; 

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');    
       
        $empresas = Empresa::select('nombre','slogan','direccion','telefono','email','web')->get();       

        return ['empresas' => $empresas ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = new Empresa();
        $empresa->nombre = $request->nombre;
        $empresa->slogan = $request->slogan;
        $empresa->direccion = $request->direccion;
        $empresa->telefono = $request->telefono;
        $empresa->email = $request->email;
        $empresa->web = $request->web;
        $empresa->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = Empresa::findOrFail($request->id);
        $empresa->nombre = $request->nombre;
        $empresa->slogan = $request->slogan;
        $empresa->direccion = $request->direccion;
        $empresa->telefono = $request->telefono;
        $empresa->email = $request->email;
        $empresa->web = $request->web;
        $empresa->save();
    }
}
