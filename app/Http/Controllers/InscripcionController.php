<?php

namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Inscripcion;

class InscripcionController extends Controller
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
            $inscripciones = Inscripcion::join('personas','inscripciones.idalumno','=','personas.id')
            ->join('users','inscripciones.idusuario','=','users.id')
            ->join('modalidades','inscripciones.idmodalidad','=','modalidades.id')
            ->select('inscripciones.id','inscripciones.fecha_ini','inscripciones.fecha_fin','inscripciones.idalumno',
            'inscripciones.idusuario','inscripciones.idmodalidad','inscripciones.abono','inscripciones.saldo',
            'inscripciones.impuesto','inscripciones.total','inscripciones.observaciones','inscripciones.estado',
            'personas.nombre','modalidades.nombre as modalidad_nombre','modalidades.duracion as modalidad_duracion',
            'users.usuario')
            ->orderBy('inscripciones.'.$ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $inscripciones = Inscripcion::join('personas','inscripciones.idalumno','=','personas.id')
            ->join('users','inscripciones.idusuario','=','users.id')
            ->join('modalidades','inscripciones.idmodalidad','=','modalidades.id')
            ->select('inscripciones.id','inscripciones.fecha_ini','inscripciones.fecha_fin','inscripciones.idalumno',
            'inscripciones.idusuario','inscripciones.idmodalidad','inscripciones.abono','inscripciones.saldo',
            'inscripciones.impuesto','inscripciones.total','inscripciones.observaciones','inscripciones.estado',
            'personas.nombre','modalidades.nombre as modalidad_nombre','modalidades.duracion as modalidad_duracion',
            'users.usuario')
            ->where('inscripciones.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('inscripciones.'.$ordenado, $ascdesc)->paginate($paginado);
        }
         
        return [
            'pagination' => [
                'total'        => $inscripciones->total(),
                'current_page' => $inscripciones->currentPage(),
                'per_page'     => $inscripciones->perPage(),
                'last_page'    => $inscripciones->lastPage(),
                'from'         => $inscripciones->firstItem(),
                'to'           => $inscripciones->lastItem(),
            ],
            'inscripciones' => $inscripciones
        ];
    }

    public function listarAlumnoMes(Request $request){
        if (!$request->ajax()) return redirect('/');        
        
        $inscripcionesM = Inscripcion::join('personas','inscripciones.idalumno','=','personas.id')
        ->select('inscripciones.id','inscripciones.fecha_ini','inscripciones.fecha_fin','inscripciones.idalumno','personas.nombre as alumno')
        ->orderBy('inscripciones.fecha_fin', 'asc')
        ->take(10)
        ->get();  
 
        return ['inscripcionesM' => $inscripcionesM];
    }

    public function listarInscripcionesAlumno(Request $request){
        if (!$request->ajax()) return redirect('/');        
        
        $id = \Auth::user()->id;

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $paginado = $request->paginado;

        if ($buscar==''){
            $inscripcionesA = Inscripcion::join('personas','inscripciones.idalumno','=','personas.id')
            ->join('modalidades','inscripciones.idmodalidad','=','modalidades.id')
            ->select('inscripciones.id','inscripciones.fecha_ini','inscripciones.fecha_fin', 'modalidades.nombre as modalidad',
            'inscripciones.abono','inscripciones.saldo','inscripciones.total','inscripciones.estado')
            ->where('personas.id',$id)
            ->orderBy('inscripciones.fecha_fin', 'desc')->paginate($paginado);
        }else{
            $inscripcionesA = Inscripcion::join('personas','inscripciones.idalumno','=','personas.id')
            ->join('modalidades','inscripciones.idmodalidad','=','modalidades.id')
            ->select('inscripciones.id','inscripciones.fecha_ini','inscripciones.fecha_fin', 'modalidades.nombre as modalidad',
            'inscripciones.abono','inscripciones.saldo','inscripciones.total','inscripciones.estado')
            ->where('personas.id',$id)
            ->where('inscripciones.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('inscripciones.fecha_fin', 'desc')->paginate($paginado);
        }
 
        return [
            'pagination' => [
                'total'        => $inscripcionesA->total(),
                'current_page' => $inscripcionesA->currentPage(),
                'per_page'     => $inscripcionesA->perPage(),
                'last_page'    => $inscripcionesA->lastPage(),
                'from'         => $inscripcionesA->firstItem(),
                'to'           => $inscripcionesA->lastItem(),
            ],
            'inscripcionesA' => $inscripcionesA
        ];
    }
      
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $fecha_ini = Carbon::now();
        $fecha_fin = Carbon::now();
        $fecha_fin = $fecha_fin->addDays($request->duracion);

        try{
            DB::beginTransaction();
            $inscripcion = new Inscripcion();
            $inscripcion->fecha_ini = $fecha_ini;
            $inscripcion->fecha_fin = $fecha_fin;
            $inscripcion->idalumno = $request->idalumno;
            $inscripcion->idusuario = \Auth::user()->id;
            $inscripcion->idmodalidad = $request->idmodalidad;
            $inscripcion->abono = $request->abono;
            $inscripcion->saldo = $request->saldo;
            $inscripcion->impuesto = $request->impuesto;
            $inscripcion->total = $request->total;
            $inscripcion->observaciones = $request->observaciones;
            $inscripcion->estado = 'Registrado';
            $inscripcion->save();

            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
            
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();           

            $inscripcion = Inscripcion::findOrFail($request->id);

            $fecha_fin= Carbon::createFromFormat("Y-m-d H:i:s", $request->fecha_ini.' 00:00:00');
            $fecha_fin= $fecha_fin->addDays($request->duracion);

            $inscripcion->fecha_ini = $request->fecha_ini;
            $inscripcion->fecha_fin = $fecha_fin;
            $inscripcion->idalumno = $request->idalumno;
            $inscripcion->idusuario = \Auth::user()->id;
            $inscripcion->idmodalidad = $request->idmodalidad;
            $inscripcion->abono = $request->abono;
            $inscripcion->saldo = $request->saldo;
            $inscripcion->impuesto = $request->impuesto;
            $inscripcion->total = $request->total;
            $inscripcion->observaciones = $request->observaciones;
            $inscripcion->estado = 'Registrado';
            $inscripcion->save();

            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
    }
 
    public function activar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $inscripcion = Inscripcion::findOrFail($request->id);
        $inscripcion->estado = 'Registrado';
        $inscripcion->save();
    }
    
    public function desactivar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $inscripcion = Inscripcion::findOrFail($request->id);
        $inscripcion->estado = 'Anulado';
        $inscripcion->save();
    }
}
