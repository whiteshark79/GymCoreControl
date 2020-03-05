<?php

namespace App\Http\Controllers;
  
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Inscripcion;
use App\Asistencia;
use App\User;
use App\Notifications\NotifyAdmin;

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

        if($criterio == 'idalumno' && $buscar != ''){$filtro = $buscar;}else{$filtro = '%'. $buscar . '%';}
         
        if ($buscar==''){
            $inscripciones = Inscripcion::join('personas','inscripciones.idalumno','=','personas.id')
            ->join('users','inscripciones.idusuario','=','users.id')
            ->join('modalidades','inscripciones.idmodalidad','=','modalidades.id')
            ->select('inscripciones.id','inscripciones.fecha_ini','inscripciones.fecha_fin','inscripciones.idalumno',
            'inscripciones.idusuario','inscripciones.idmodalidad','inscripciones.idhorario','inscripciones.abono',
            'inscripciones.saldo', 'inscripciones.impuesto','inscripciones.total','inscripciones.observaciones',
            'inscripciones.estado', 'personas.nombre as nombre','modalidades.nombre as modalidad_nombre','modalidades.duracion as modalidad_duracion',
            'users.usuario')
            ->orderBy('inscripciones.'.$ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $inscripciones = Inscripcion::join('personas','inscripciones.idalumno','=','personas.id')
            ->join('users','inscripciones.idusuario','=','users.id')
            ->join('modalidades','inscripciones.idmodalidad','=','modalidades.id')
            ->select('inscripciones.id','inscripciones.fecha_ini','inscripciones.fecha_fin','inscripciones.idalumno',
            'inscripciones.idusuario','inscripciones.idmodalidad','inscripciones.idhorario','inscripciones.abono',
            'inscripciones.saldo', 'inscripciones.impuesto','inscripciones.total','inscripciones.observaciones',
            'inscripciones.estado', 'personas.nombre as nombre','modalidades.nombre as modalidad_nombre','modalidades.duracion as modalidad_duracion',
            'users.usuario')
            ->where('inscripciones.'.$criterio, 'like', $filtro )  
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
 
    public function listarInscripcionAlumno(Request $request){ 
        if (!$request->ajax()) return redirect('/');
         
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $paginado = $request->paginado;

        $fecha_hoy = Carbon::now();
        $fecha_hoy =$fecha_hoy->format('Y-m-d');             

        if($criterio == 'fecha_fin' && $buscar == 0){ $buscar = $fecha_hoy; }   

        if ($buscar==''){        
            $inscripcionesM = Inscripcion::join('personas','inscripciones.idalumno','=','personas.id')
            ->join('modalidades','inscripciones.idmodalidad','=','modalidades.id')
            ->select('inscripciones.id','inscripciones.fecha_ini','inscripciones.fecha_fin', 
            'modalidades.nombre as modalidad','personas.nombre as alumno')
            ->orderBy('inscripciones.id', 'desc')->paginate($paginado);            
        }else{ 
            $inscripcionesM = DB::table('inscripciones')
            ->join('personas','inscripciones.idalumno','=','personas.id')
            ->join('modalidades','inscripciones.idmodalidad','=','modalidades.id')
            ->select('inscripciones.id','inscripciones.fecha_ini','inscripciones.fecha_fin', 
            'modalidades.nombre as modalidad','personas.nombre as alumno')
            ->where('inscripciones.'.$criterio, $buscar )                                 
            ->orderBy('inscripciones.id', 'desc')->paginate($paginado);
    
        }         

        
 
        return [
            'pagination' => [
                'total'        => $inscripcionesM->total(),
                'current_page' => $inscripcionesM->currentPage(),
                'per_page'     => $inscripcionesM->perPage(),
                'last_page'    => $inscripcionesM->lastPage(),
                'from'         => $inscripcionesM->firstItem(),
                'to'           => $inscripcionesM->lastItem(),
            ],
            'inscripcionesM' => $inscripcionesM
        ];
        
    }

    public function listarInscripcionDetalleAlumno(Request $request){
        if (!$request->ajax()) return redirect('/');        
        
        $id = $request->id;        

        $datosInscripcionAlumno = Inscripcion::join('personas','inscripciones.idalumno','=','personas.id')
        ->join('modalidades','inscripciones.idmodalidad','=','modalidades.id')
        ->select('inscripciones.fecha_ini','inscripciones.fecha_fin','personas.nombre as alumno','modalidades.nombre as modalidad')
        ->where('inscripciones.id',$id)
        ->first(); 
           

        $noClasesModalidad = Inscripcion::join('modalidades','inscripciones.idmodalidad','=','modalidades.id')
        ->select('modalidades.clases')
        ->where('inscripciones.id',$id)
        ->first(); 

 
        return ['fecha_ini' => $datosInscripcionAlumno->fecha_ini,
                'fecha_fin' => $datosInscripcionAlumno->fecha_fin,
                'alumno' => $datosInscripcionAlumno->alumno, 
                'modalidad' => $datosInscripcionAlumno->modalidad, 
                'clases' => $noClasesModalidad->clases];
    }

    public function listarInscripcionesAlumnoId(Request $request){
        if (!$request->ajax()) return redirect('/');        
         
        $id = \Auth::user()->id;

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $paginado = $request->paginado;

        if($criterio == 'idalumno' && $buscar != ''){$filtro = $buscar;}else{$filtro = '%'. $buscar . '%';}

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
            ->where('inscripciones.'.$criterio, 'like', $filtro )
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

    public function listarInscripcionesDiario(Request $request){
        if (!$request->ajax()) return redirect('/');        
        
        $fechaActual= date('Y-m-d'); 
        $fecha_hora = $request->fecha;
        if($fecha_hora){$fecha = $fecha_hora;}else{$fecha = $fechaActual;}  

        $inscripcionesDia = Inscripcion::join('personas','inscripciones.idalumno','=','personas.id')
        ->select('inscripciones.id','inscripciones.fecha_ini', 'personas.nombre as alumno', 'inscripciones.impuesto', 'inscripciones.abono','inscripciones.total','inscripciones.estado')
        ->whereDate('inscripciones.fecha_ini', $fecha)
        ->whereIn('inscripciones.estado',['Cancelado','Debe'])
        ->orderBy('inscripciones.fecha_ini', 'desc')->get();         
 
         return [ 'inscripcionesDia' => $inscripcionesDia ];
    }
       
    public function store(Request $request)
    {
       // if (!$request->ajax()) return redirect('/');
 
        $fecha_ini = Carbon::now();
        $fecha_fin = Carbon::now();
        $fecha_fin = $fecha_fin->addDays($request->duracion);

        if($request->abono != $request->total){$estado = 'Debe';}else{$estado = 'Cancelado';}

        try{
            DB::beginTransaction();
            $inscripcion = new Inscripcion();
            $inscripcion->fecha_ini = $fecha_ini;
            $inscripcion->fecha_fin = $fecha_fin;
            $inscripcion->idalumno = $request->idalumno;
            $inscripcion->idusuario = \Auth::user()->id;
            $inscripcion->idmodalidad = $request->idmodalidad;
            $inscripcion->idhorario = $request->idhorario;
            $inscripcion->abono = $request->abono;
            $inscripcion->saldo = $request->saldo;
            $inscripcion->impuesto = $request->impuesto;
            $inscripcion->total = $request->total;
            $inscripcion->observaciones = $request->observaciones;
            $inscripcion->estado = $estado;
            $inscripcion->save();

            $asistencia = new Asistencia();
            $asistencia->idinscripcion = $inscripcion->id;
            $asistencia->fecha_hora = $fecha_ini; 
            $asistencia->contador = 0;        
            $asistencia->save();                
            
            $fechaActual= date('Y-m-d');
            $numInscripciones = DB::table('inscripciones')->whereDate('created_at',$fechaActual)->count(); 
            $numGastos = DB::table('gastos')->whereDate('created_at',$fechaActual)->count(); 
            $numVentas = DB::table('ventas')->whereDate('created_at', $fechaActual)->count(); 
            $numIngresos = DB::table('ingresos')->whereDate('created_at',$fechaActual)->count(); 
            

            $arregloDatos = [ 
                'inscripciones' => [ 
                    'numero' => $numInscripciones, 
                    'msj' => 'Inscripciones' 
                ],
                'gastos' => [ 
                    'numero' => $numGastos, 
                    'msj' => 'Gastos' 
                ],
                'ventas' => [ 
                    'numero' => $numVentas, 
                    'msj' => 'Ventas' 
                ],
                'ingresos' => [ 
                    'numero' => $numIngresos, 
                    'msj' => 'Compras' 
                ]
                
            ];
                            
            $allUsers = User::all();

            foreach ($allUsers as $notificar) { 
                User::findOrFail($notificar->id)->notify(new NotifyAdmin($arregloDatos)); 
            } 


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
            $asistencia = Asistencia::where('idinscripcion', $inscripcion->id)->firstOrFail();

            $fecha_fin= Carbon::createFromFormat("Y-m-d H:i:s", $request->fecha_ini.' 00:00:00');
            $fecha_fin= $fecha_fin->addDays($request->duracion);

            if($request->abono != $request->total){$estado = 'Debe';}else{$estado = 'Cancelado';}

            $inscripcion->fecha_ini = $request->fecha_ini;
            $inscripcion->fecha_fin = $fecha_fin;
            $inscripcion->idalumno = $request->idalumno;
            $inscripcion->idusuario = \Auth::user()->id;
            $inscripcion->idmodalidad = $request->idmodalidad;
            $inscripcion->idhorario = $request->idhorario;
            $inscripcion->abono = $request->abono;
            $inscripcion->saldo = $request->saldo;
            $inscripcion->impuesto = $request->impuesto;
            $inscripcion->total = $request->total;
            $inscripcion->observaciones = $request->observaciones;
            $inscripcion->estado = $estado;
            $inscripcion->save();            
            
            $asistencia->fecha_hora = $request->fecha_ini; 
            $asistencia->save();

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
