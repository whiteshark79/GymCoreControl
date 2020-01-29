<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Profesion;

class ProfesionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $paginado = $request->paginado;
        $ordenado = $request->ordenado;
        $ascdesc = $request->ascdesc;
        
        if ($buscar==''){
            $profesiones = Profesion::orderBy($ordenado, $ascdesc)->paginate($paginado);

        }
        else{
            $profesiones = Profesion::where($criterio, 'like', '%'. $buscar . '%')->orderBy($ordenado, $ascdesc)->paginate($paginado);

        }
        

        return [
            'pagination' => [
                'total'        => $profesiones->total(),
                'current_page' => $profesiones->currentPage(),
                'per_page'     => $profesiones->perPage(),
                'last_page'    => $profesiones->lastPage(),
                'from'         => $profesiones->firstItem(),
                'to'           => $profesiones->lastItem(),
            ],
            'profesiones' => $profesiones
        ];
    }    

    public function selectProfesion(Request $request){
        if (!$request->ajax()) return redirect('/');
        $profesiones = Profesion::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['profesiones' => $profesiones];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $profesion = new Profesion();
        $profesion->nombre = $request->nombre;
        $profesion->descripcion = $request->descripcion;
        $profesion->condicion = '1';
        $profesion->save();
    }
  

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $profesion = Profesion::findOrFail($request->id);
        $profesion->nombre = $request->nombre;
        $profesion->descripcion = $request->descripcion;
        $profesion->condicion = '1';
        $profesion->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $profesion = Profesion::findOrFail($request->id);
        $profesion->condicion = '0';
        $profesion->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $profesion = Profesion::findOrFail($request->id);
        $profesion->condicion = '1';
        $profesion->save();
    }

    
}
