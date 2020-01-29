<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Provincia; 

class ProvinciaController extends Controller
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
            $provincias = Provincia::orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $provincias = Provincia::where($criterio, 'like', '%'. $buscar . '%')->orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        
        return [
            'pagination' => [
                'total'        => $provincias->total(),
                'current_page' => $provincias->currentPage(),
                'per_page'     => $provincias->perPage(),
                'last_page'    => $provincias->lastPage(),
                'from'         => $provincias->firstItem(),
                'to'           => $provincias->lastItem(),
            ],
            'provincias' => $provincias
        ];
    }    

    public function selectProvincia(Request $request){
        if (!$request->ajax()) return redirect('/');
        $provincias = Provincia::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['provincias' => $provincias];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $provincia = new Provincia();
        $provincia->nombre = $request->nombre;
        $provincia->condicion = '1';
        $provincia->save();
    }  

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $provincia = Provincia::findOrFail($request->id);
        $provincia->nombre = $request->nombre;
        $provincia->condicion = '1';
        $provincia->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $provincia = Provincia::findOrFail($request->id);
        $provincia->condicion = '0';
        $provincia->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $provincia = Provincia::findOrFail($request->id);
        $provincia->condicion = '1';
        $provincia->save();
    }
    
}
