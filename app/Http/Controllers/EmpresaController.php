<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Empresa; 

class EmpresaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $paginado = $request->paginado;
        $ordenado = $request->ordenado;
        $ascdesc = $request->ascdesc;
        
        
        if ($buscar==''){
            $empresas = Empresa::orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $empresas = Empresa::where($criterio, 'like', '%'. $buscar . '%')->orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        

        return [
            'pagination' => [
                'total'        => $empresas->total(),
                'current_page' => $empresas->currentPage(),
                'per_page'     => $empresas->perPage(),
                'last_page'    => $empresas->lastPage(),
                'from'         => $empresas->firstItem(),
                'to'           => $empresas->lastItem(),
            ],
            'empresas' => $empresas
        ];
    }

    public function selectEmpresa(Request $request){
        if (!$request->ajax()) return redirect('/');
        $empresas = Empresa::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['empresas' => $empresas];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = new Empresa();
        $empresa->ruc = $request->ruc;
        $empresa->razon_social = $request->razon_social;
        $empresa->nombre = $request->nombre;
        $empresa->slogan = $request->slogan;
        $empresa->email = $request->email;
        $empresa->web = $request->web;        
        $empresa->nombre_propietario = $request->nombre_propietario;
        $empresa->celular_propietario = $request->celular_propietario;
        $empresa->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = Empresa::findOrFail($request->id);
        $empresa->ruc = $request->ruc;
        $empresa->razon_social = $request->razon_social;
        $empresa->nombre = $request->nombre;
        $empresa->slogan = $request->slogan;
        $empresa->email = $request->email;
        $empresa->web = $request->web;        
        $empresa->nombre_propietario = $request->nombre_propietario;
        $empresa->celular_propietario = $request->celular_propietario;
        $empresa->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = Empresa::findOrFail($request->id);
        $empresa->condicion = '0';
        $empresa->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $empresa = Empresa::findOrFail($request->id);
        $empresa->condicion = '1';
        $empresa->save();
    }
}
