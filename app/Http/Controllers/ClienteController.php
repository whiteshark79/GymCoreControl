<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Persona;

class ClienteController extends Controller
{
    public function index(Request $request)
    {
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $paginado = $request->paginado;
        $ordenado = $request->ordenado;
        $ascdesc = $request->ascdesc;
        
        if ($buscar==''){
            $personas = Persona::orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $personas = Persona::where($criterio, 'like', '%'. $buscar . '%')->orderBy($ordenado, $ascdesc)->paginate($paginado);
        }
        

        return [
            'pagination' => [
                'total'        => $personas->total(),
                'current_page' => $personas->currentPage(),
                'per_page'     => $personas->perPage(),
                'last_page'    => $personas->lastPage(),
                'from'         => $personas->firstItem(),
                'to'           => $personas->lastItem(),
            ],
            'personas' => $personas
        ];
    }

    public function selectCliente(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        $clientes = Persona::where('perfil', '<>', 'Proveedor')
        ->where(function ($query)  use ($filtro){
            $query->where('nombres', 'like', '%'. $filtro . '%')
            ->orWhere('apellidos', 'like', '%'. $filtro . '%')
            ->orWhere('num_documento', 'like', '%'. $filtro . '%')
            ->select('id','nombres','apellidos','num_documento')
            ->orderBy('nombres', 'asc');                
        })
        ->get();
 
        return ['clientes' => $clientes];
    }  

  
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $persona = new Persona();
        $persona->tipo_documento = $request->tipo_documento;
        $persona->num_documento = $request->num_documento;
        $persona->nombres = $request->nombres;
        $persona->apellidos = $request->apellidos;
        $persona->fec_nacimiento = $request->fec_nacimiento;
        $persona->direccion = $request->direccion;
        $persona->celular = $request->celular;
        $persona->email = $request->email;
        $persona->perfil = 'Cliente';
        $persona->save();
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $persona = Persona::findOrFail($request->id);
        $persona->tipo_documento = $request->tipo_documento;
        $persona->num_documento = $request->num_documento;
        $persona->nombres = $request->nombres;
        $persona->apellidos = $request->apellidos;
        $persona->fec_nacimiento = $request->fec_nacimiento;
        $persona->direccion = $request->direccion;
        $persona->celular = $request->celular;
        $persona->email = $request->email;
        $persona->perfil = 'Cliente';
        $persona->save();
    }
}
