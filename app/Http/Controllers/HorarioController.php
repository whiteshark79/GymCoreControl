<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
            $horarios = Horario::orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $horarios = Horario::where($criterio, 'like', '%'. $buscar . '%')->orderBy($ordenado, $ascdesc)->paginate($paginado);
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
        ->select('id','hora_ini','hora_fin','periodo')->orderBy('periodo', 'asc')->get();
        return ['horarios' => $horarios];
    }
 
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        
        $horario = new Horario();
        $horario->hora_ini = $request->hora_ini;
        $horario->hora_fin = $request->hora_fin;
        $horario->periodo = $request->periodo;
        $horario->descripcion = $request->descripcion;
        $horario->condicion = '1';
        $horario->save();
    }
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $horario = Horario::findOrFail($request->id);
        $horario->hora_ini = $request->hora_ini;
        $horario->hora_fin = $request->hora_fin;
        $horario->periodo = $request->periodo;
        $horario->descripcion = $request->descripcion;
        $horario->condicion = '1';
        $horario->save();
    }

    public function destroy(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $horario = Horario::findOrFail($request->id);        
        $horario->delete();
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
