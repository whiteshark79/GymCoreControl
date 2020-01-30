<?php
  
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
use App\Profesor;
use App\Persona;
  
 
class ProfesorController extends Controller
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
            $personas = Profesor::join('personas','profesores.id','=','personas.id')
            ->join('especialidades','profesores.idespecialidad','=','especialidades.id')
            ->select('personas.id','personas.tipo_documento','personas.num_documento','personas.nombres','personas.apellidos',
            'personas.fec_nacimiento','personas.direccion','personas.celular','personas.email','personas.perfil',
            'profesores.horario','profesores.idespecialidad','profesores.sueldo_hora','especialidades.nombre')
            ->orderBy('personas.'.$ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $personas = Profesor::join('personas','profesores.id','=','personas.id')
            ->join('especialidades','profesores.idespecialidad','=','especialidades.id')
            ->select('personas.id','personas.tipo_documento','personas.num_documento','personas.nombres','personas.apellidos',
            'personas.fec_nacimiento','personas.direccion','personas.celular','personas.email','personas.perfil',
            'profesores.horario','profesores.idespecialidad','profesores.sueldo_hora','especialidades.nombre')           
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('.'.$ordenado, $ascdesc)->paginate($paginado);
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
    
    public function selectProfesor(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        $profesores = Profesor::join('personas','profesores.id','=','personas.id')
        ->where('personas.nombres', 'like', '%'. $filtro . '%')
        ->orWhere('personas.apellidos', 'like', '%'. $filtro . '%')
        ->orWhere('personas.num_documento', 'like', '%'. $filtro . '%')
        ->select('personas.id','personas.nombres','personas.apellidos','personas.num_documento')
        ->orderBy('personas.nombres', 'asc')->get();
 
        return ['profesores' => $profesores];
    } 

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
         
        try{
            DB::beginTransaction();
            $persona = new Persona();
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->nombres = $request->nombres;
            $persona->apellidos = $request->apellidos;
            $persona->fec_nacimiento = $request->fec_nacimiento;
            $persona->direccion = $request->direccion;
            $persona->celular = $request->celular;
            $persona->email = $request->email;
            $persona->perfil = 'Profesor';
            $persona->save();
 
            $profesor = new Profesor();
            $profesor->horario = $request->horario;
            $profesor->idespecialidad = $request->idespecialidad;
            $profesor->sueldo_hora = $request->sueldo_hora;
            $profesor->id = $persona->id;
            $profesor->save();
 
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
            $profesor = Profesor::findOrFail($request->id);
            $persona = Persona::findOrFail($profesor->id);
 
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->nombres = $request->nombres;
            $persona->apellidos = $request->apellidos;
            $persona->fec_nacimiento = $request->fec_nacimiento;
            $persona->direccion = $request->direccion;
            $persona->celular = $request->celular;
            $persona->email = $request->email;
            $persona->perfil = 'Profesor';
            $persona->save();
 
            $profesor->horario = $request->horario;
            $profesor->idespecialidad = $request->idespecialidad;
            $profesor->sueldo_hora = $request->sueldo_hora;
            $profesor->save();
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
    }   
}