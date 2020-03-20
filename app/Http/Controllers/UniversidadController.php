<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Universidad;

class UniversidadController extends Controller
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
            $universidades = Universidad::join('provincias','universidades.idprovincia','=','provincias.id')
            ->join('cantones','universidades.idcanton','=','cantones.id')
            ->select('universidades.id','universidades.nombre','universidades.idprovincia','provincias.nombre as nombre_provincia','universidades.idcanton','cantones.nombre as nombre_canton','universidades.condicion')
            ->orderBy('universidades.'.$ordenado, $ascdesc)->paginate($paginado);            
        }else{           
            $universidades = Universidad::join('provincias','universidades.idprovincia','=','provincias.id')
                ->join('cantones','universidades.idcanton','=','cantones.id')
                ->select('universidades.id','universidades.nombre','universidades.idprovincia','provincias.nombre as nombre_provincia','universidades.idcanton','cantones.nombre as nombre_canton','universidades.condicion')
                ->where($criterio.'.nombre', 'like', '%'.$buscar.'%')
                ->orderBy('universidades.'.$ordenado, $ascdesc)->paginate($paginado);  
        }        

        return [
            'pagination' => [
                'total'        => $universidades->total(),
                'current_page' => $universidades->currentPage(),
                'per_page'     => $universidades->perPage(),
                'last_page'    => $universidades->lastPage(),
                'from'         => $universidades->firstItem(),
                'to'           => $universidades->lastItem(),
            ],
            'universidades' => $universidades
        ];
    }   
    
    public function selectUniversidad(Request $request){
        if (!$request->ajax()) return redirect('/');

        $universidades = Universidad::where('condicion','=','1')
        ->select('id','nombre')->orderBy('nombre', 'asc')->get();
        return ['universidades' => $universidades];
    }

    public function selectUniversidadId(Request $request){
        if (!$request->ajax()) return redirect('/');

        $idprovincia = $request->idprovincia;
        $universidadesId = Universidad::where('condicion','=','1')
        ->select('id','nombre')
        ->where('idprovincia','=',$idprovincia)
        ->orderBy('nombre', 'asc')->get();
        return ['universidadesId' => $universidadesId];
    }

   
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $universidad = new Universidad();
        $universidad->nombre = $request->nombre;
        $universidad->idprovincia = $request->idprovincia;
        $universidad->idcanton = $request->idcanton;
        $universidad->condicion = '1';
        $universidad->save();
    }
     
    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $universidad = Universidad::findOrFail($request->id);
        $universidad->nombre = $request->nombre;
        $universidad->idprovincia = $request->idprovincia;
        $universidad->idcanton = $request->idcanton;
        $universidad->condicion = '1';
        $universidad->save();
    }

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $universidad = Universidad::findOrFail($request->id);
        $universidad->condicion = '0';
        $universidad->save();
    }

    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $universidad = Universidad::findOrFail($request->id);
        $universidad->condicion = '1';
        $universidad->save();
    }

    
}
