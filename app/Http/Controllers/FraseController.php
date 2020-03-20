<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
use App\Frase;


class FraseController extends Controller
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
            $frases = Frase::orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $frases = Frase::where($criterio, 'like', '%'. $buscar . '%')->orderBy($ordenado, $ascdesc)->paginate($paginado);
        }        

        return [
            'pagination' => [
                'total'        => $frases->total(),
                'current_page' => $frases->currentPage(),
                'per_page'     => $frases->perPage(),
                'last_page'    => $frases->lastPage(),
                'from'         => $frases->firstItem(),
                'to'           => $frases->lastItem(),
            ],
            'frases' => $frases
        ];
    }

    public function selectFraseId(Request $request){
        if (!$request->ajax()) return redirect('/');

        $id = rand(1, 99);
        
        $frases = Frase::where('condicion','=','1')
        ->select('id','descripcion','autor')
        ->where('id',$id)->get();

        return ['frases' => $frases];
    }
}
