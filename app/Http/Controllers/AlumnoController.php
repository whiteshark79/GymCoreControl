<?php

namespace App\Http\Controllers; 

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Alumno;
use App\Persona;
use App\User;
use App\Rol;
use App\Local;

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
            $personas = Alumno::join('users','alumnos.id','=','users.id')
            ->join('personas','alumnos.id','=','personas.id')
            ->join('profesiones','alumnos.idprofesion','=','profesiones.id')
            ->join('universidades','alumnos.iduniversidad','=','universidades.id')
            ->join('locales','alumnos.idlocal','=','locales.id')
            ->select('personas.id','personas.tipo_documento','personas.num_documento','personas.nombre','users.usuario', 'users.avatar',
            'personas.fec_nacimiento','personas.direccion','personas.celular','personas.email','personas.perfil','alumnos.sexo',
            'alumnos.estado_civil','alumnos.hijos','alumnos.sector','alumnos.idlocal', 'locales.nombre as local','alumnos.idprofesion', 
            'profesiones.nombre as profesion', 'alumnos.sit_laboral','alumnos.empresa','alumnos.cargo','alumnos.estudiante','alumnos.iduniversidad',
            'universidades.nombre as universidad', 'universidades.idprovincia','alumnos.edad','alumnos.peso', 'alumnos.estatura','alumnos.nivel_actividad',
            'alumnos.tipo_actividad','alumnos.objetivo')
            ->orderBy('personas.'.$ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $personas = Alumno::join('users','alumnos.id','=','users.id')
            ->join('personas','alumnos.id','=','personas.id')
            ->join('profesiones','alumnos.idprofesion','=','profesiones.id')
            ->join('universidades','alumnos.iduniversidad','=','universidades.id')
            ->join('locales','alumnos.idlocal','=','locales.id')
            ->select('personas.id','personas.tipo_documento','personas.num_documento','personas.nombre','users.usuario', 'users.avatar',
            'personas.fec_nacimiento','personas.direccion','personas.celular','personas.email','personas.perfil','alumnos.sexo',
            'alumnos.estado_civil','alumnos.hijos','alumnos.sector','alumnos.idlocal', 'locales.nombre as local','alumnos.idprofesion', 
            'profesiones.nombre as profesion', 'alumnos.sit_laboral','alumnos.empresa','alumnos.cargo','alumnos.estudiante','alumnos.iduniversidad',
            'universidades.nombre as universidad', 'universidades.idprovincia','alumnos.edad','alumnos.peso', 'alumnos.estatura','alumnos.nivel_actividad',
            'alumnos.tipo_actividad','alumnos.objetivo')   
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
        ->where('personas.nombre', 'like', '%'. $filtro . '%')
        ->orWhere('personas.num_documento', 'like', '%'. $filtro . '%')
        ->select('personas.id','personas.nombre','personas.num_documento','alumnos.idlocal')
        ->orderBy('personas.nombre', 'asc')->get();
 
        return ['alumnos' => $alumnos];
    } 

    public function selectAlumnoId(Request $request){ 
        if (!$request->ajax()) return redirect('/');

        $id = \Auth::user()->id;
        //DB::raw('DATE_FORMAT(personas.fec_nacimiento, "%d - %b - %Y") as fec_nacimiento')

        $personas = Alumno::join('users','alumnos.id','=','users.id')
        ->join('personas','alumnos.id','=','personas.id')
        ->join('profesiones','alumnos.idprofesion','=','profesiones.id')
        ->join('universidades','alumnos.iduniversidad','=','universidades.id')
        ->join('locales','alumnos.idlocal','=','locales.id')
        ->select('users.usuario', 'users.avatar','personas.id','personas.tipo_documento','personas.num_documento', DB::raw('SUBSTRING_INDEX(personas.nombre," ",1) as nombre'),
        DB::raw('SUBSTRING_INDEX(personas.nombre," ",-1) as apellido'),'personas.fec_nacimiento', 'personas.direccion','personas.celular','personas.email',
        'personas.perfil', 'alumnos.sexo','alumnos.estado_civil','alumnos.hijos', 'alumnos.sector','alumnos.idlocal', 'locales.nombre as local', 
        'alumnos.idprofesion', 'profesiones.nombre as profesion','alumnos.sit_laboral', 'alumnos.empresa','alumnos.cargo', 'alumnos.estudiante','alumnos.iduniversidad',
        'universidades.nombre as universidad', 'universidades.idprovincia', 'alumnos.edad','alumnos.peso', 'alumnos.estatura','alumnos.nivel_actividad',
        'alumnos.tipo_actividad','alumnos.objetivo')           
        ->where('personas.id',$id)->get();
 
        return ['personas' => $personas];        
    } 

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');     
        if($request->sexo == 'M') { $avatar = 'female.png';}else{ $avatar = 'male.png';}
        
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
            $persona->perfil = 'Alumno';            
            $persona->save();
 
            $alumno = new Alumno();     
            $alumno->sexo = $request->sexo;
            $alumno->estado_civil = $request->estado_civil;
            $alumno->hijos = $request->hijos;
            $alumno->sector = $request->sector;
            $alumno->idlocal = $request->idlocal;
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

            $rol = DB::table('roles')->where('nombre', 'like', '%Alumno%')->first();

            $user = new User(); 
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->num_documento);
            $user->avatar = $avatar;
            $user->condicion = '1';
            $user->idrol = $rol->id;
            $user->id = $persona->id;
            $user->save();
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
                
    }

    public function update(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); 
        if($request->sexo == 'M') { $avatar = 'female.png';}else{ $avatar = 'male.png';}
        
        try{
            DB::beginTransaction();
            $alumno = Alumno::findOrFail($request->id); 
            $persona = Persona::findOrFail($alumno->id);
            $user = User::findOrFail($alumno->id);

            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->nombre = $request->nombre;
            $persona->fec_nacimiento = $request->fec_nacimiento;
            $persona->direccion = $request->direccion;
            $persona->celular = $request->celular;
            $persona->email = $request->email;
            $persona->perfil = 'Alumno';            
            $persona->save();             
                
            $alumno->sexo = $request->sexo;
            $alumno->estado_civil = $request->estado_civil;
            $alumno->hijos = $request->hijos;
            $alumno->sector = $request->sector;
            $alumno->idlocal = $request->idlocal;
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

            $user->avatar = $avatar;
            $user->save();
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
    } 

    public function actualizarAlumnoLaboral(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); 
        
        try{
            DB::beginTransaction();
            $alumno = Alumno::findOrFail($request->id);             
                
            $alumno->estudiante = $request->estudiante;
            $alumno->iduniversidad = $request->iduniversidad;
            $alumno->idprofesion = $request->idprofesion;

            $alumno->sit_laboral = $request->sit_laboral;
            $alumno->empresa = $request->empresa;
            $alumno->cargo = $request->cargo;            
            
            $alumno->save();
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
    } 

    public function actualizarAlumnoFisico(Request $request)
    {
        if (!$request->ajax()) return redirect('/'); 
        
        try{
            DB::beginTransaction();
            $alumno = Alumno::findOrFail($request->id);   
                
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
