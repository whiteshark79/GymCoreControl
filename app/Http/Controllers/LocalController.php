<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Local;
 
class LocalController extends Controller
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
            $locales = Local::join('empresas','locales.idempresa','=','empresas.id')
            ->select('locales.id','locales.idempresa','empresas.nombre as empresa','locales.nombre',
            'locales.descripcion','locales.telefono','locales.direccion','locales.condicion')
            ->orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $locales = Local::join('empresas','locales.idempresa','=','empresas.id')
            ->select('locales.id','locales.idempresa','empresas.nombre as empresa','locales.nombre',
            'locales.descripcion','locales.telefono','locales.direccion','locales.condicion')
            ->where('locales.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        

        return [
            'pagination' => [
                'total'        => $locales->total(),
                'current_page' => $locales->currentPage(),
                'per_page'     => $locales->perPage(),
                'last_page'    => $locales->lastPage(),
                'from'         => $locales->firstItem(),
                'to'           => $locales->lastItem(),
            ],
            'locales' => $locales
        ];
    } 

    public function selectLocal(Request $request){
        if (!$request->ajax()) return redirect('/');
        $locales = Local::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['locales' => $locales];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $local = new Local();
        $local->idempresa = $request->idempresa;
        $local->nombre = $request->nombre;
        $local->descripcion = $request->descripcion;
        $local->telefono = $request->telefono;
        $local->direccion = $request->direccion;
        $local->condicion = '1';
        $local->save();
    }
    
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $local = Local::findOrFail($request->id);
        $local->idempresa = $request->idempresa;
        $local->nombre = $request->nombre;
        $local->descripcion = $request->descripcion;
        $local->telefono = $request->telefono;
        $local->direccion = $request->direccion;
        $local->condicion = '1';
        $local->save();
    }
    
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $local = Local::findOrFail($request->id);
        $local->condicion = '0';
        $local->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $local = Local::findOrFail($request->id);
        $local->condicion = '1';
        $local->save();
    }
}
