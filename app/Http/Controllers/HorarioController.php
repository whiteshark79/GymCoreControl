<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Horario; 

class HorarioController extends Controller
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
            $horarios = Horario::join('locales','horarios.idlocal','=','locales.id')
            ->select('horarios.id', 'horarios.idlocal', 'locales.nombre as local', DB::raw('DATE_FORMAT(horarios.hora_ini,"%H:%i") as hora_ini'), 
            DB::raw('DATE_FORMAT(horarios.hora_fin,"%H:%i") as hora_fin'), 'horarios.periodo','horarios.descripcion','horarios.condicion')
            ->orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $horarios = Horario::join('locales','horarios.idlocal','=','locales.id')
            ->select('horarios.id', 'horarios.idlocal', 'locales.nombre as local', DB::raw('DATE_FORMAT(horarios.hora_ini,"%H:%i") as hora_ini'), 
            DB::raw('DATE_FORMAT(horarios.hora_fin,"%H:%i") as hora_fin'), 'horarios.periodo','horarios.descripcion','horarios.condicion')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        

        return [
            'pagination' => [
                'total'        => $horarios->total(),
                'current_page' => $horarios->currentPage(),
                'per_page'     => $horarios->perPage(),
                'last_page'    => $horarios->lastPage(),
                'from'         => $horarios->firstItem(),
                'to'           => $horarios->lastItem(),
            ],
            'horarios' => $horarios
        ];
    }

    public function selectHorario(Request $request){
        if (!$request->ajax()) return redirect('/');        

        $horarios = Horario::where('condicion','=','1')
        ->select('id',DB::raw('DATE_FORMAT(horarios.hora_ini,"%H:%i") as hora_ini'),
        DB::raw('DATE_FORMAT(horarios.hora_fin,"%H:%i") as hora_fin'), 'periodo')
        ->orderBy('hora_ini', 'asc')->get();
        return ['horarios' => $horarios];
    }

    public function selectHorarioId(Request $request){
        //if (!$request->ajax()) return redirect('/');

        $idlocal = $request->idlocal;

        $horarios = Horario::where('condicion','=','1')
        ->select('id',DB::raw('DATE_FORMAT(horarios.hora_ini,"%H:%i") as hora_ini'),
        DB::raw('DATE_FORMAT(horarios.hora_fin,"%H:%i") as hora_fin'), 'periodo')
        ->where('idlocal',$idlocal)
        ->orderBy('hora_ini', 'asc')->get();
        return ['horarios' => $horarios];
    }
 
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();
            $horario = new Horario();
            $horario->idlocal = $request->idlocal;
            $horario->hora_ini = $request->hora_ini;
            $horario->hora_fin = $request->hora_fin;
            $horario->periodo = $request->periodo;
            $horario->descripcion = $request->descripcion;
            $horario->condicion = '1';
            $horario->save();
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }        
        
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $horario = Horario::findOrFail($request->id);
        $horario->idlocal = $request->idlocal;
        $horario->hora_ini = $request->hora_ini;
        $horario->hora_fin = $request->hora_fin;
        $horario->periodo = $request->periodo;
        $horario->descripcion = $request->descripcion;
        $horario->condicion = '1';
        $horario->save();
    }    

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $horario = Horario::findOrFail($request->id);
        $horario->condicion = '0';
        $horario->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $horario = Horario::findOrFail($request->id);
        $horario->condicion = '1';
        $horario->save();
    }
}
