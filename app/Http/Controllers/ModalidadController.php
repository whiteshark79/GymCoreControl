<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Modalidad; 

class ModalidadController extends Controller
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
            $modalidades = Modalidad::orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $modalidades = Modalidad::where($criterio, 'like', '%'. $buscar . '%')->orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        

        return [
            'pagination' => [
                'total'        => $modalidades->total(),
                'current_page' => $modalidades->currentPage(),
                'per_page'     => $modalidades->perPage(),
                'last_page'    => $modalidades->lastPage(),
                'from'         => $modalidades->firstItem(),
                'to'           => $modalidades->lastItem(),
            ],
            'modalidades' => $modalidades
        ];
    } 
  
    public function selectModalidad(Request $request){
        if (!$request->ajax()) return redirect('/');
        $modalidades = Modalidad::where('condicion','=','1')
        ->select('id','nombre','duracion','precio')
        ->orderBy('nombre', 'asc')->get();
        return ['modalidades' => $modalidades];
    }    
   
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $modalidad = new Modalidad();
        $modalidad->nombre = $request->nombre;
        $modalidad->descripcion = $request->descripcion;
        $modalidad->duracion = $request->duracion;
        $modalidad->precio = $request->precio;
        $modalidad->condicion = '1';
        $modalidad->save();
    }
  
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $modalidad = Modalidad::findOrFail($request->id);
        $modalidad->nombre = $request->nombre;
        $modalidad->descripcion = $request->descripcion;
        $modalidad->duracion = $request->duracion;
        $modalidad->precio = $request->precio;
        $modalidad->condicion = '1';
        $modalidad->save();
    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $modalidad = Modalidad::findOrFail($request->id);        
        $modalidad->delete();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $modalidad = Modalidad::findOrFail($request->id);
        $modalidad->condicion = '0';
        $modalidad->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $modalidad = Modalidad::findOrFail($request->id);
        $modalidad->condicion = '1';
        $modalidad->save();
    }
}
