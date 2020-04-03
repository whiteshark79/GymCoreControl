<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Persona;
use App\User;

class ClienteController extends Controller
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
            $personas = Persona::join('users','personas.id','=','users.id')
            ->select('personas.tipo_documento','personas.num_documento','personas.nombre',
            'users.usuario', 'users.avatar', 'personas.fec_nacimiento','personas.direccion','personas.celular',
            'personas.email','personas.perfil')
            ->orderBy('personas.'.$ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $personas = Persona::join('users','personas.id','=','users.id')
            ->select('personas.tipo_documento','personas.num_documento','personas.nombre',
            'users.usuario', 'users.avatar', 'personas.fec_nacimiento','personas.direccion','personas.celular',
            'personas.email','personas.perfil')
            ->where($criterio, 'like', '%'. $buscar . '%')
            ->orderBy('personas.'.$ordenado, $ascdesc)->paginate($paginado);
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

    public function selectPersonaLogin(Request $request){ 
        if (!$request->ajax()) return redirect('/');

        $id = \Auth::user()->id;

        $personas = Persona::join('users','personas.id','=','users.id')
        ->select('users.usuario', 'users.avatar', 'users.idrol', DB::raw('SUBSTRING_INDEX(personas.nombre," ",1) as nombre'),
        DB::raw('SUBSTRING_INDEX(personas.nombre," ",-1) as apellido'),'personas.perfil')         
        ->where('personas.id',$id)->get();       
 
        return ['personas' => $personas];        
    } 
 
    public function selectPersonaId(Request $request){ 
        if (!$request->ajax()) return redirect('/');

        $num_documento = $request->num_documento;
        $personaDatosId = Persona::where('num_documento',$num_documento)->get();      
        $stsPersonaId=$personaDatosId->count();
 
        return ['stsPersonaId'=>$stsPersonaId];     
    }

    public function selectPersonaEmail(Request $request){ 
        if (!$request->ajax()) return redirect('/');

        $email = $request->email;
        $personaDatosEmail = Persona::where('email',$email)->get();      
        $stsPersonaEmail=$personaDatosEmail->count();
 
        return ['stsPersonaEmail'=>$stsPersonaEmail];     
    }

    public function selectCliente(Request $request){ 
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        $clientes = Persona::where('perfil', '<>', 'Proveedor')
        ->where(function ($query)  use ($filtro){
            $query->where('nombre', 'like', '%'. $filtro . '%')
            ->orWhere('num_documento', 'like', '%'. $filtro . '%')
            ->select('id','nombre','num_documento')
            ->orderBy('nombre', 'asc');                
        })
        ->get();
 
        return ['clientes' => $clientes];
    }  
  
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        try{
            DB::beginTransaction();            
            $persona = new Persona();
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->nombre = $request->nombre;
            $persona->fec_nacimiento = $request->fec_nacimiento;
            $persona->direccion = $request->direccion;
            $persona->celular = $request->celular;
            $persona->email = $request->email;
            $persona->perfil = 'Cliente';
            $persona->save();

            $user = new User();
            $user->usuario = $request->usuario;

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
            
            $persona = Persona::findOrFail($request->id);
            $user = User::findOrFail($persona->id);

            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->nombre = $request->nombre;
            $persona->fec_nacimiento = $request->fec_nacimiento;
            $persona->direccion = $request->direccion;
            $persona->celular = $request->celular;
            $persona->email = $request->email;
            $persona->perfil = 'Cliente';
            $persona->save();

            $user->usuario = $request->usuario;
            $user->save();
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
    } 

    public function actualizarAlumno(Request $request)
    {               

        try{
            DB::beginTransaction();            
            
            $persona = Persona::findOrFail($request->id); 
            $user = User::findOrFail($persona->id); 
                                  
            $persona->num_documento = $request->num_documento;
            $persona->fec_nacimiento = $request->fec_nacimiento;
            $persona->email = $request->email;
            $persona->celular = $request->celular;
            $persona->direccion = $request->direccion; 
            $persona->save();              

            DB::commit();

            
 
        } catch (Exception $e){
            DB::rollBack();
        }
    }    
    
    
}
