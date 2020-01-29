<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Canton;

class CantonController extends Controller
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
            $cantones = Canton::join('provincias','cantones.idprovincia','=','provincias.id')
            ->select('cantones.id','cantones.nombre','cantones.idprovincia','provincias.nombre as nombre_provincia','cantones.condicion')
            ->orderBy('cantones.'.$ordenado, $ascdesc)->paginate($paginado);
        }else{  
            $cantones = Canton::join('provincias','cantones.idprovincia','=','provincias.id')
            ->select('cantones.id','cantones.nombre','cantones.idprovincia','provincias.nombre as nombre_provincia','cantones.condicion')
            ->where($criterio.'.nombre', 'like', '%'.$buscar.'%')
            ->orderBy('cantones.'.$ordenado, $ascdesc)->paginate($paginado);       
        }
        

        return [
            'pagination' => [
                'total'        => $cantones->total(),
                'current_page' => $cantones->currentPage(),
                'per_page'     => $cantones->perPage(),
                'last_page'    => $cantones->lastPage(),
                'from'         => $cantones->firstItem(),
                'to'           => $cantones->lastItem(),
            ],
            'cantones' => $cantones
        ];
    }    

    public function selectCanton(Request $request){
        if (!$request->ajax()) return redirect('/');
        $cantones = Canton::where('condicion','=','1')
        ->select('id','nombre','idprovincia')->orderBy('nombre', 'asc')->get();
        return ['cantones' => $cantones];
    }
    
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $canton = new Canton();
        $canton->nombre = $request->nombre;
        $canton->idprovincia = $request->idprovincia;
        $canton->condicion = '1';
        $canton->save();
    }  

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $canton = Canton::findOrFail($request->id);
        $canton->nombre = $request->nombre;
        $canton->idprovincia = $request->idprovincia;
        $canton->condicion = '1';
        $canton->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $canton = Canton::findOrFail($request->id);
        $canton->condicion = '0';
        $canton->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $canton = Canton::findOrFail($request->id);
        $canton->condicion = '1';
        $canton->save();
    }
  
}