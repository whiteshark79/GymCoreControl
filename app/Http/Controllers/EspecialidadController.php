<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Especialidad; 

class EspecialidadController extends Controller
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
            $especialidades = Especialidad::orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $especialidades = Especialidad::where($criterio, 'like', '%'. $buscar . '%')->orderBy($ordenado, $ascdesc)->paginate($paginado);
        }        

        return [
            'pagination' => [
                'total'        => $especialidades->total(),
                'current_page' => $especialidades->currentPage(),
                'per_page'     => $especialidades->perPage(),
                'last_page'    => $especialidades->lastPage(),
                'from'         => $especialidades->firstItem(),
                'to'           => $especialidades->lastItem(),
            ],
            'especialidades' => $especialidades
        ];
    }

    public function selectEspecialidad(Request $request){
        if (!$request->ajax()) return redirect('/');
        $especialidades = Especialidad::where('condicion','=','1')
        ->select('id','nombre')
        ->orderBy('nombre', 'asc')->get();
        return ['especialidades' => $especialidades];
    }
   
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $especialidad = new Especialidad();
        $especialidad->nombre = $request->nombre;
        $especialidad->descripcion = $request->descripcion;
        $especialidad->condicion = '1';
        $especialidad->save();
    }
  
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $especialidad = Especialidad::findOrFail($request->id);
        $especialidad->nombre = $request->nombre;
        $especialidad->descripcion = $request->descripcion;
        $especialidad->condicion = '1';
        $especialidad->save();
    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $especialidad = Especialidad::findOrFail($request->id);        
        $especialidad->delete();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $especialidad = Especialidad::findOrFail($request->id);
        $especialidad->condicion = '0';
        $especialidad->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $especialidad = Especialidad::findOrFail($request->id);
        $especialidad->condicion = '1';
        $especialidad->save();
    }
}
