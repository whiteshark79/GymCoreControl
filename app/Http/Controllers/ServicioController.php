<?php 

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Servicio; 

class ServicioController extends Controller
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
            $servicios = Servicio::join('clasificaciones','servicios.idclasificacion','=','clasificaciones.id')
            ->select('servicios.id','servicios.idclasificacion','servicios.codigo','servicios.nombre','clasificaciones.nombre as nombre_clasificacion','servicios.descripcion','servicios.condicion')
            ->orderBy('servicios.'.$ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $servicios = Servicio::join('clasificaciones','servicios.idclasificacion','=','clasificaciones.id')
            ->select('servicios.id','servicios.idclasificacion','servicios.codigo','servicios.nombre','clasificaciones.nombre as nombre_clasificacion','servicios.descripcion','servicios.condicion')
            ->where('servicios.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('servicios.'.$ordenado, $ascdesc)->paginate($paginado);
        }
        

        return [
            'pagination' => [
                'total'        => $servicios->total(),
                'current_page' => $servicios->currentPage(),
                'per_page'     => $servicios->perPage(),
                'last_page'    => $servicios->lastPage(),
                'from'         => $servicios->firstItem(),
                'to'           => $servicios->lastItem(),
            ],
            'servicios' => $servicios
        ];
    }

    public function listarServicio(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $servicios = Servicio::join('clasificaciones','servicios.idclasificacion','=','clasificaciones.id')
            ->select('servicios.id','servicios.idclasificacion','servicios.codigo','servicios.nombre','clasificaciones.nombre as nombre_clasificacion','servicios.descripcion','servicios.condicion')
            ->orderBy('servicios.nombre', 'desc')->paginate(10);
        }
        else{
            $servicios = Servicio::join('clasificaciones','servicios.idclasificacion','=','clasificaciones.id')
            ->select('servicios.id','servicios.idclasificacion','servicios.codigo','servicios.nombre','clasificaciones.nombre as nombre_clasificacion','servicios.descripcion','servicios.condicion')
            ->where('servicios.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('servicios.nombre', 'desc')->paginate(10);
        }         
 
        return ['servicios' => $servicios];
    }

    public function listarServicioGasto(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
         
        if ($buscar==''){
            $servicios = Servicio::join('clasificaciones','servicios.idclasificacion','=','clasificaciones.id')
            ->select('servicios.id','servicios.idclasificacion','servicios.codigo','servicios.nombre','clasificaciones.nombre as nombre_clasificacion','servicios.descripcion','servicios.condicion')
            ->orderBy('servicios.nombre', 'desc')->paginate(10);
        }
        else{
            $servicios = Servicio::join('clasificaciones','servicios.idclasificacion','=','clasificaciones.id')
            ->select('servicios.id','servicios.idclasificacion','servicios.codigo','servicios.nombre','clasificaciones.nombre as nombre_clasificacion','servicios.descripcion','servicios.condicion')
            ->where('servicios.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('servicios.nombre', 'desc')->paginate(10);
        }         
 
        return ['servicios' => $servicios];
    }
    
    public function buscarServicio(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        $servicios = Servicio::where('codigo','=', $filtro)
        ->select('id','nombre','descripcion')
        ->orderBy('nombre', 'asc')
        ->take(1)->get();
 
        return ['servicios' => $servicios];
    } 

    public function buscarServicioGasto(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        $servicios = Servicio::where('codigo','=', $filtro)
        ->select('id','nombre','descripcion')
        ->orderBy('nombre', 'asc')
        ->take(1)->get();
 
        return ['servicios' => $servicios];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $servicio = new Servicio();
        $servicio->idclasificacion = $request->idclasificacion;
        $servicio->codigo = $request->codigo;
        $servicio->nombre = $request->nombre;
        $servicio->descripcion = $request->descripcion;
        $servicio->condicion = '1';
        $servicio->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $servicio = Servicio::findOrFail($request->id);
        $servicio->idclasificacion = $request->idclasificacion;
        $servicio->codigo = $request->codigo;
        $servicio->nombre = $request->nombre;
        $servicio->descripcion = $request->descripcion;
        $servicio->condicion = '1';
        $servicio->save();
    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $servicio = Servicio::findOrFail($request->id);        
        $servicio->delete();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $servicio = Servicio::findOrFail($request->id);
        $servicio->condicion = '0';
        $servicio->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $servicio = Servicio::findOrFail($request->id);
        $servicio->condicion = '1';
        $servicio->save();
    }
}
