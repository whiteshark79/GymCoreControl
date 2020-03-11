<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
use App\Rutina;

class RutinaController extends Controller
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
            $rutinas = Rutina::orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $rutinas = Rutina::where($criterio, 'like', '%'. $buscar . '%')->orderBy($ordenado, $ascdesc)->paginate($paginado);
        }        

        return [
            'pagination' => [
                'total'        => $rutinas->total(),
                'current_page' => $rutinas->currentPage(),
                'per_page'     => $rutinas->perPage(),
                'last_page'    => $rutinas->lastPage(),
                'from'         => $rutinas->firstItem(),
                'to'           => $rutinas->lastItem(),
            ],
            'rutinas' => $rutinas
        ];
    }

    public function selectRutina(Request $request){
        if (!$request->ajax()) return redirect('/');
        $rutinas = Rutina::where('condicion','=','1')
        ->select('id','nombre')
        ->orderBy('nombre', 'asc')->get();
        return ['rutinas' => $rutinas];
    }
   
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $rutina = new Rutina();
        $rutina->nombre = $request->nombre;
        $rutina->descripcion = $request->descripcion;
        $rutina->condicion = '1';
        $rutina->save();
    }
  
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $rutina = Rutina::findOrFail($request->id);
        $rutina->nombre = $request->nombre;
        $rutina->descripcion = $request->descripcion;
        $rutina->condicion = '1';
        $rutina->save();
    }    

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $rutina = Rutina::findOrFail($request->id);
        $rutina->condicion = '0';
        $rutina->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $rutina = Rutina::findOrFail($request->id);
        $rutina->condicion = '1';
        $rutina->save();
    }
}
