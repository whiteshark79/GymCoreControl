<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

use Illuminate\Http\Request;
use App\Caja;
use App\Inscripcion;
use App\Gasto;
use App\Venta;
use App\Ingreso;

 
class CajaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $paginado = $request->paginado;

        $fechaActual= date('Y-m-d'); 

        if ($buscar==''){
            $cajas = Caja::select('id','fecha_hora','inscripciones','gastos','ventas','compras','total')
            ->orderBy('fecha_hora', 'asc')->paginate($paginado);
        }else{  
            $cajas = Caja::select('id','fecha_hora','inscripciones','gastos','ventas','compras','total')
            ->where($criterio, 'like', $buscar.'%') 
            ->orderBy('cuadres_caja.fecha_hora', 'asc')->paginate($paginado);    
        }    
        
        $cnt = $cajas->count();
        
        if($cnt>0){
            $lastRow = DB::table('cuadres_caja')->latest('fecha_hora')->first();
            if($lastRow->fecha_hora == $fechaActual){$activo = 1;}else{$activo = 0;}
        }else{
            $activo = 0;
        }

        return [
            'pagination' => [
                'total'        => $cajas->total(),
                'current_page' => $cajas->currentPage(),
                'per_page'     => $cajas->perPage(),
                'last_page'    => $cajas->lastPage(),
                'from'         => $cajas->firstItem(),
                'to'           => $cajas->lastItem(),
            ],
            'cajas' => $cajas,
            'activo' => $activo
        ];
    }  

    public function InsOuts(Request $request){
        if (!$request->ajax()) return redirect('/'); 
  
        $fechaActual= date('Y-m-d'); 
        $fecha_hora = $request->fecha;
        if($fecha_hora){$fecha = $fecha_hora;}else{$fecha = $fechaActual;} 

        $ventasValorMes = DB::table('ventas')->where('estado', '!=','Anulado')->whereDate('fecha_hora', $fecha)->sum('total'); 
        $ventasDeudaMes = DB::table('ventas')->where('estado', '!=','Anulado')->whereDate('fecha_hora', $fecha)->sum('abono');   

        $inscripcionesValorMes = DB::table('inscripciones')->where('estado', '!=','Anulado')->whereDate('fecha_ini', $fecha)->sum('total');
        $inscripcionesDeudaMes = DB::table('inscripciones')->where('estado', '!=','Anulado')->whereDate('fecha_ini', $fecha)->sum('abono'); 

        
        $gastosValorMes = DB::table('gastos')->where('estado', '!=','Anulado')->whereDate('fecha_hora', $fecha)->sum('total'); 
        $gastosDeudaMes = DB::table('gastos')->where('estado', '!=','Anulado')->whereDate('fecha_hora', $fecha)->sum('abono');
        
        $ingresosValorMes = DB::table('ingresos')->where('estado', '!=','Anulado')->whereDate('fecha_hora', $fecha)->sum('total');
        $ingresosDeudaMes = DB::table('ingresos')->where('estado', '!=','Anulado')->whereDate('fecha_hora', $fecha)->sum('abono');


        $ingresosCancelado = 
            array([
                'ventasValorMes' => $ventasValorMes,
                'inscripcionesValorMes' => $inscripcionesValorMes
            ]);
        
        $ingresosDeuda = 
            array([
                'ventasDeudaMes' => $ventasDeudaMes,
                'inscripcionesDeudaMes' => $inscripcionesDeudaMes
            ]);

        $egresosCancelado = 
            array([
                'gastosValorMes' => $gastosValorMes,
                'ingresosValorMes' => $ingresosValorMes
            ]);
        
        $egresosDeuda = 
            array([
                'gastosDeudaMes' => $gastosDeudaMes,
                'ingresosDeudaMes' => $ingresosDeudaMes
            ]);
        
        return ['ingresosCancelado'=>$ingresosCancelado, 'ingresosDeuda'=>$ingresosDeuda, 'egresosCancelado'=>$egresosCancelado, 'egresosDeuda'=>$egresosDeuda]; 
    } 

    public function pdf(Request $request, $fecha){    
        
        $fechaActual= date('Y-m-d');

        $inscripcionesDia = Inscripcion::join('personas','inscripciones.idalumno','=','personas.id')
        ->select('personas.nombre as insalumno', 'inscripciones.impuesto as insimpuesto', 'inscripciones.abono as insabono','inscripciones.total as instotal')
        ->whereDate('inscripciones.fecha_ini', $fecha)
        ->whereIn('inscripciones.estado',['Cancelado','Debe'])
        ->orderBy('inscripciones.id', 'desc')->get();

        $ventasDia = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->select('personas.nombre as vencliente', 'ventas.impuesto as venimpuesto', 'ventas.total as ventotal', 'ventas.abono as venabono')
        ->whereDate('ventas.fecha_hora', $fecha)
        ->whereIn('ventas.estado',['Cancelado','Debe'])
        ->orderBy('ventas.id', 'desc')->get(); 

        $gastosDia = Gasto::join('personas','gastos.idproveedor','=','personas.id')
        ->select('personas.nombre as gasproveedor', 'gastos.impuesto as gasimpuesto', 'gastos.total as gastotal','gastos.abono as gasabono')
        ->whereDate('gastos.fecha_hora', $fecha)
        ->whereIn('gastos.estado',['Cancelado','Debe'])
        ->orderBy('gastos.id', 'desc')->get();  

        $ingresosDia = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
        ->select('personas.nombre as ingproveedor', 'ingresos.impuesto as ingimpuesto', 'ingresos.total as ingtotal', 'ingresos.abono as ingabono')
        ->whereDate('ingresos.fecha_hora', $fecha)
        ->whereIn('ingresos.estado',['Cancelado','Debe'])  
        ->orderBy('ingresos.fecha_hora', 'desc')->get(); 

        $ventasValorMes = DB::table('ventas')->where('estado', '!=','Anulado')->whereDate('fecha_hora', $fecha)->sum('total'); 
        $ventasDeudaMes = DB::table('ventas')->where('estado', '!=','Anulado')->whereDate('fecha_hora', $fecha)->sum('abono');   

        $inscripcionesValorMes = DB::table('inscripciones')->where('estado', '!=','Anulado')->whereDate('fecha_ini', $fecha)->sum('total');
        $inscripcionesDeudaMes = DB::table('inscripciones')->where('estado', '!=','Anulado')->whereDate('fecha_ini', $fecha)->sum('abono'); 
        
        $gastosValorMes = DB::table('gastos')->where('estado', '!=','Anulado')->whereDate('fecha_hora', $fecha)->sum('total'); 
        $gastosDeudaMes = DB::table('gastos')->where('estado', '!=','Anulado')->whereDate('fecha_hora', $fecha)->sum('abono');
        
        $ingresosValorMes = DB::table('ingresos')->where('estado', '!=','Anulado')->whereDate('fecha_hora', $fecha)->sum('total');
        $ingresosDeudaMes = DB::table('ingresos')->where('estado', '!=','Anulado')->whereDate('fecha_hora', $fecha)->sum('abono');   
        

        $inscnt = $inscripcionesDia->count();
        $vencnt = $ventasDia->count();
        $gascnt = $gastosDia->count();
        $ingcnt = $ingresosDia->count();
        $numcuadre=Caja::select('id')->where('fecha_hora',$fecha)->get();

        $pdf=\PDF::loadview('pdf.cuadre',['inscripcionesDia'=>$inscripcionesDia,'gastosDia'=>$gastosDia,'ingresosDia'=>$ingresosDia,'ventasDia'=>$ventasDia,
                                          'inscnt'=>$inscnt,'vencnt'=>$vencnt,'gascnt'=>$gascnt,'ingcnt'=>$ingcnt,
                                          'ventasValorMes'=>$ventasValorMes,'ventasDeudaMes'=>$ventasDeudaMes,
                                          'inscripcionesValorMes'=>$inscripcionesValorMes,'inscripcionesDeudaMes'=>$inscripcionesDeudaMes,
                                          'gastosValorMes'=>$gastosValorMes,'gastosDeudaMes'=>$gastosDeudaMes,
                                          'ingresosValorMes'=>$ingresosValorMes,'ingresosDeudaMes'=>$ingresosDeudaMes                                          
                                          ]);

        return $pdf->download('caja_'.$numcuadre[0]->id.'-'.$fecha.'.pdf');        

    } 

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');   
        
        $mytime= Carbon::now();
        
        try{
            DB::beginTransaction();
            $caja = new Caja();            
            $caja->fecha_hora = $mytime;
            $caja->inscripciones = $request->inscripciones;
            $caja->gastos = $request->gastos;
            $caja->ventas = $request->ventas;
            $caja->compras = $request->compras;
            $caja->total = $request->total;
            $caja->save();      
           
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
                
    }


}
