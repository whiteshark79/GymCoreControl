<?php
 
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Clasificacion;

class ClasificacionController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $paginado = '10';
        $ordenado = 'id';
        $ascdesc = 'asc';

        
        if ($buscar==''){
            $clasificaciones = Clasificacion::orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $clasificaciones = Clasificacion::where($criterio, 'like', '%'. $buscar . '%')->orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        

        return [
            'pagination' => [
                'total'        => $clasificaciones->total(),
                'current_page' => $clasificaciones->currentPage(),
                'per_page'     => $clasificaciones->perPage(),
                'last_page'    => $clasificaciones->lastPage(),
                'from'         => $clasificaciones->firstItem(),
                'to'           => $clasificaciones->lastItem(),
            ],
            'clasificaciones' => $clasificaciones
        ];
    }

    public function selectClasificacion(Request $request){
        if (!$request->ajax()) return redirect('/');
        $clasificaciones = Clasificacion::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['clasificaciones' => $clasificaciones];
    }
 
    public function selectClasificacionB(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        $clasificaciones = Clasificacion::where('nombre', 'like', '%'. $filtro . '%')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get(); 
        return ['clasificaciones' => $clasificaciones];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $clasificacion = new Clasificacion();
        $clasificacion->nombre = $request->nombre;
        $clasificacion->descripcion = $request->descripcion;
        $clasificacion->condicion = '1';
        $clasificacion->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $clasificacion = Clasificacion::findOrFail($request->id);
        $clasificacion->nombre = $request->nombre;
        $clasificacion->descripcion = $request->descripcion;
        $clasificacion->condicion = '1';
        $clasificacion->save();
    }    

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $clasificacion = Clasificacion::findOrFail($request->id);
        $clasificacion->condicion = '0';
        $clasificacion->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $clasificacion = Clasificacion::findOrFail($request->id);
        $clasificacion->condicion = '1';
        $clasificacion->save();
    }
}
