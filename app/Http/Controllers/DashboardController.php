<?php
 
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB;
 
use Illuminate\Http\Request;
 
class DashboardController extends Controller
{
    public function grafInOuts(Request $request){
        if (!$request->ajax()) return redirect('/');

        $anio=date('Y');
        
        $ingresos=DB::table('ingresos as i')
        ->select(DB::raw('DATE_FORMAT(i.fecha_hora, "%b") as mes'),
            DB::raw('YEAR(i.fecha_hora) as anio'),
            DB::raw('SUM(i.total) as total'))
        ->whereYear('i.fecha_hora',$anio)
        ->groupBy(DB::raw('DATE_FORMAT(i.fecha_hora, "%b")'),DB::raw('YEAR(i.fecha_hora)'))
        ->orderBy(DB::raw('i.id'), 'asc')
        ->get();
 
        $ventas=DB::table('ventas as v')
        ->select(DB::raw('DATE_FORMAT(v.fecha_hora, "%b") as mes'),
            DB::raw('YEAR(v.fecha_hora) as anio'),
            DB::raw('SUM(v.total) as total'))
        ->whereYear('v.fecha_hora',$anio)
        ->groupBy(DB::raw('DATE_FORMAT(v.fecha_hora, "%b")'),DB::raw('YEAR(v.fecha_hora)'))
        ->orderBy(DB::raw('v.id'), 'asc')
        ->get();

        $inscripciones=DB::table('inscripciones as in')
        ->select(DB::raw('DATE_FORMAT(in.fecha_ini, "%b") as mes'),
            DB::raw('YEAR(in.fecha_ini) as anio'),
            DB::raw('SUM(in.total) as total'))
        ->whereYear('in.fecha_ini',$anio)
        ->groupBy(DB::raw('DATE_FORMAT(in.fecha_ini, "%b")'),DB::raw('YEAR(in.fecha_ini)'))
        ->orderBy(DB::raw('in.id'), 'asc')
        ->get();

        $gastos=DB::table('gastos as g')
        ->select(DB::raw('DATE_FORMAT(g.fecha_hora, "%b") as mes'),
            DB::raw('YEAR(g.fecha_hora) as anio'),
            DB::raw('SUM(g.total) as total'))
        ->whereYear('g.fecha_hora',$anio)
        ->groupBy(DB::raw('DATE_FORMAT(g.fecha_hora, "%b")'),DB::raw('YEAR(g.fecha_hora)'))
        ->orderBy(DB::raw('g.id'), 'asc')
        ->get();
 
        return ['ingresos'=>$ingresos,'ventas'=>$ventas, 'inscripciones'=>$inscripciones, 'gastos'=>$gastos, 'anio'=>$anio];     
    }
    
    public function grafArticulo(Request $request){
        //if (!$request->ajax()) return redirect('/');

        $anio=date('Y');

        $articulos=DB::table('detalle_ventas')
        ->join('ventas','detalle_ventas.idventa','=','ventas.id')
        ->join('articulos','detalle_ventas.idarticulo','=','articulos.id')
        ->select(DB::raw('articulos.nombre as articulo'),
                DB::raw('SUM(detalle_ventas.subtotal) as subtotal'))
        ->whereYear('ventas.fecha_hora',$anio)
        ->groupBy(DB::raw('articulos.nombre'))
        ->orderBy(DB::raw('ventas.fecha_hora'), 'asc')
        ->take(5)
        ->get();

        return ['articulos'=>$articulos];   

    }

    public function widgetInOuts(Request $request){
        if (!$request->ajax()) return redirect('/');

        $fechaActual= date('m');        

        $ingresosValorTotal = DB::table('ingresos')->sum('total');
        $ingresosValorMes = DB::table('ingresos')->whereMonth('fecha_hora', $fechaActual)->sum('total');        
        $ingresosQtxTotal = DB::table('ingresos')->count();
        $ingresosQtxMes = DB::table('ingresos')->whereMonth('fecha_hora', $fechaActual)->count(); 

        $ventasValorTotal = DB::table('ventas')->sum('total');
        $ventasValorMes = DB::table('ventas')->whereMonth('fecha_hora', $fechaActual)->sum('total');        
        $ventasQtxTotal = DB::table('ventas')->count();
        $ventasQtxMes = DB::table('ventas')->whereMonth('fecha_hora', $fechaActual)->count();

        $inscripcionesValorTotal = DB::table('inscripciones')->sum('total');
        $inscripcionesValorMes = DB::table('inscripciones')->whereMonth('fecha_ini', $fechaActual)->sum('total');        
        $inscripcionesQtxTotal = DB::table('inscripciones')->count();
        $inscripcionesQtxMes = DB::table('inscripciones')->whereMonth('fecha_ini', $fechaActual)->count();        

        $gastosValorTotal = DB::table('gastos')->sum('total');
        $gastosValorMes = DB::table('gastos')->whereMonth('fecha_hora', $fechaActual)->sum('total');        
        $gastosQtxTotal = DB::table('gastos')->count();
        $gastosQtxMes = DB::table('gastos')->whereMonth('fecha_hora', $fechaActual)->count(); 

        $wingresos = 
            array([
                'i_val_total' => $ingresosValorTotal,
                'i_val_mes' => $ingresosValorMes,
                'i_qtx_total' => $ingresosQtxTotal,
                'i_qtx_mes' => $ingresosQtxMes,
                'i_msj' => 'Compras'
            ]);

        $wventas = 
            array([
                'v_val_total' => $ventasValorTotal,
                'v_val_mes' => $ventasValorMes,
                'v_qtx_total' => $ventasQtxTotal,
                'v_qtx_mes' => $ventasQtxMes,
                'v_msj' => 'Ventas'
            ]);

        $winscripciones = 
            array([
                'in_val_total' => $inscripcionesValorTotal,
                'in_val_mes' => $inscripcionesValorMes,
                'in_qtx_total' => $inscripcionesQtxTotal,
                'in_qtx_mes' => $inscripcionesQtxMes,
                'in_msj' => 'Inscripciones'
            ]);
        
        $wgastos = 
            array([
                'g_val_total' => $gastosValorTotal,
                'g_val_mes' => $gastosValorMes,
                'g_qtx_total' => $gastosQtxTotal,
                'g_qtx_mes' => $gastosQtxMes,
                'g_msj' => 'Gastos'
            ]);
        
        return ['wingresos'=>$wingresos, 'wventas'=>$wventas, 'winscripciones'=>$winscripciones, 'wgastos'=>$wgastos]; 
    }    

    public function widgetAlumnos(Request $request){
        //if (!$request->ajax()) return redirect('/');

        $alumnosM=DB::table('alumnos as a')
        ->select('a.sexo')
        ->where('a.sexo','=','M')     
        ->count();

        $alumnosH=DB::table('alumnos as a')
        ->select('a.sexo')
        ->where('a.sexo','=','H')     
        ->count();

        $alumnos = 
            array([
                'alumnosM'=>$alumnosM,
                'alumnosH'=>$alumnosH,
                'a_msj'=>'Alumnos'
            ]);

        return ['alumnos'=>$alumnos]; 
    }


}