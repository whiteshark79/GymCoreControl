<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Collection;

use App\Calendario;

class CalendarioController extends Controller
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
            $calendarios = Calendario::join('locales','calendarios.idlocal','=','locales.id')
            ->select('calendarios.id','calendarios.fecha_hora','calendarios.fecha_ini','calendarios.fecha_fin',
            'calendarios.idlocal','locales.nombre as local', 'calendarios.condicion')
            ->orderBy('calendarios.'.$ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $calendarios = Calendario::join('locales','calendarios.idlocal','=','locales.id')
            ->select('calendarios.id','calendarios.fecha_hora','calendarios.fecha_ini','calendarios.fecha_fin',
            'calendarios.idlocal','locales.nombre as local', 'calendarios.condicion')
            ->where('calendarios.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('calendarios.'.$ordenado, $ascdesc)->paginate($paginado);
        }   
            

        return [
            'pagination' => [
                'total'        => $calendarios->total(),
                'current_page' => $calendarios->currentPage(),
                'per_page'     => $calendarios->perPage(),
                'last_page'    => $calendarios->lastPage(),
                'from'         => $calendarios->firstItem(),
                'to'           => $calendarios->lastItem(),
            ],
            'calendarios' => $calendarios
        ];
    } 

    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $calendario = Calendario::join('locales','calendarios.idlocal','=','locales.id')
        ->select('calendarios.id','calendarios.fecha_hora as fecha','calendarios.fecha_ini','calendarios.fecha_fin',
            'calendarios.idlocal','locales.nombre as local', 'calendarios.condicion')
        ->where('calendarios.id','=',$id)
        ->orderBy('calendarios.id', 'desc')->take(1)->get();
         
        return ['calendario' => $calendario];
    } 

    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');        
 
        $id = $request->id;
        $detalles = DetalleCalendario::join('horarios','detalle_calendarios.idhorario','=','horarios.id')
        ->join('personas','detalle_calendarios.idprofesor','=','personas.id')
        ->join('rutinas','detalle_calendarios.idrutina','=','rutinas.id')
        ->select('detalle_calendarios.dia','detalle_calendarios.idcalendario','detalle_calendarios.idhorario',
        'horarios.hora_ini','horarios.hora_fin','detalle_calendarios.idprofesor','personas.nombre as profesor',
        'detalle_calendarios.idrutina', 'rutinas.nombre as rutina')
        ->where('detalle_calendarios.idventa','=',$id)
        ->orderBy('detalle_calendarios.id', 'desc')->get();
         
        return ['detalles' => $detalles];
    }

    public function selectDias(Request $request)
    {
        setlocale(LC_ALL, 'es_ES');

        $fecha_ini = $request->fecha_ini;
        $fecha_fin = $request->fecha_fin;
        
        $start = Carbon::create($fecha_ini);
        $end = Carbon::create($fecha_fin); 

        $cntdias = $start->diffInDays($end);        
        $dias = [];

        for ($i = 0; $i <= $cntdias; $i++) {            
            $dias[] = $start->formatLocalized('%A').' '.$start->day;            
            $start->addDay();
        }

        //return ['uno' => $dias[0], 'dos' => $dias[1], 'tres' => $dias[2], 'cuatro' => $dias[3],'cinco' => $dias[4],'seis' => $dias[5],'cntdias' => $cntdias];
        return ['dias' => $dias,'cntdias' => $cntdias];
    }
}
