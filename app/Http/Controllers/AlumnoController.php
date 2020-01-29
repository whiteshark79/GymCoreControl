<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Alumno;
use App\Persona;

class AlumnoController extends Controller
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
            $personas = Alumno::join('personas','alumnos.id','=','personas.id')
            ->join('profesiones','alumnos.idprofesion','=','profesiones.id')
            ->join('universidades','alumnos.iduniversidad','=','universidades.id')
            ->select('personas.id','personas.tipo_documento','personas.num_documento','personas.nombres',
            'personas.apellidos', 'personas.fec_nacimiento','personas.direccion','personas.celular','personas.email','personas.perfil',
            'alumnos.cod_socio', 'alumnos.sexo','alumnos.estado_civil','alumnos.hijos','alumnos.sector','alumnos.idprofesion', 'profesiones.nombre as profesion',
            'alumnos.sit_laboral','alumnos.empresa','alumnos.cargo','alumnos.estudiante','alumnos.iduniversidad','universidades.nombre as universidad', 
            'alumnos.edad','alumnos.peso','alumnos.estatura','alumnos.nivel_actividad','alumnos.tipo_actividad','alumnos.objetivo')
            ->orderBy('personas.'.$ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $personas = Alumno::join('personas','alumnos.id','=','personas.id')
            ->join('profesiones','alumnos.idprofesion','=','profesiones.id')
            ->join('universidades','alumnos.iduniversidad','=','universidades.id')
            ->select('personas.id','personas.tipo_documento','personas.num_documento','personas.nombres',
            'personas.apellidos', 'personas.fec_nacimiento','personas.direccion','personas.celular','personas.email','personas.perfil',
            'alumnos.cod_socio', 'alumnos.sexo','alumnos.estado_civil','alumnos.hijos','alumnos.sector','alumnos.idprofesion', 'profesiones.nombre as profesion',
            'alumnos.sit_laboral','alumnos.empresa','alumnos.cargo','alumnos.estudiante','alumnos.iduniversidad','universidades.nombre as universidad', 
            'alumnos.edad','alumnos.peso','alumnos.estatura','alumnos.nivel_actividad','alumnos.tipo_actividad','alumnos.objetivo')           
            ->where('personas.'.$criterio, 'like', '%'. $buscar . '%')
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

    public function selectAlumno(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        $alumnos = Alumno::join('personas','alumnos.id','=','personas.id')
        ->where('personas.nombres', 'like', '%'. $filtro . '%')
        ->orWhere('personas.apellidos', 'like', '%'. $filtro . '%')
        ->orWhere('personas.num_documento', 'like', '%'. $filtro . '%')
        ->select('personas.id','personas.nombres','personas.apellidos','personas.num_documento')
        ->orderBy('personas.nombres', 'asc')->get();
 
        return ['alumnos' => $alumnos];
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
            $persona->perfil = 'Alumno';
            $persona->save();
 
            $alumno = new Alumno();
            $alumno->cod_socio = $request->cod_socio;        
            $alumno->sexo = $request->sexo;
            $alumno->estado_civil = $request->estado_civil;
            $alumno->hijos = $request->hijos;
            $alumno->sector = $request->sector;
            $alumno->idprofesion = $request->idprofesion;
            $alumno->sit_laboral = $request->sit_laboral;
            $alumno->empresa = $request->empresa;
            $alumno->cargo = $request->cargo;
            $alumno->estudiante = $request->estudiante;
            $alumno->iduniversidad = $request->iduniversidad;
            $alumno->edad = $request->edad;
            $alumno->peso = $request->peso;
            $alumno->estatura = $request->estatura;
            $alumno->nivel_actividad = $request->nivel_actividad;
            $alumno->tipo_actividad = $request->tipo_actividad;
            $alumno->objetivo = $request->objetivo;            
            $alumno->id = $persona->id;
            $alumno->save();
 
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
            $alumno = Alumno::findOrFail($request->id); 
            $persona = Persona::findOrFail($alumno->id);

            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->nombres = $request->nombres;
            $persona->apellidos = $request->apellidos;
            $persona->fec_nacimiento = $request->fec_nacimiento;
            $persona->direccion = $request->direccion;
            $persona->celular = $request->celular;
            $persona->email = $request->email;
            $persona->perfil = 'Alumno';
            $persona->save(); 
            
            $alumno->cod_socio = $request->cod_socio;        
            $alumno->sexo = $request->sexo;
            $alumno->estado_civil = $request->estado_civil;
            $alumno->hijos = $request->hijos;
            $alumno->sector = $request->sector;
            $alumno->idprofesion = $request->idprofesion;
            $alumno->sit_laboral = $request->sit_laboral;
            $alumno->empresa = $request->empresa;
            $alumno->cargo = $request->cargo;
            $alumno->estudiante = $request->estudiante;
            $alumno->iduniversidad = $request->iduniversidad;
            $alumno->edad = $request->edad;
            $alumno->peso = $request->peso;
            $alumno->estatura = $request->estatura;
            $alumno->nivel_actividad = $request->nivel_actividad;
            $alumno->tipo_actividad = $request->tipo_actividad;
            $alumno->objetivo = $request->objetivo;
            $alumno->save();
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
    }
    
}
