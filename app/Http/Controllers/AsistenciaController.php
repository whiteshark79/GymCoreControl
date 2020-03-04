<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Asistencia;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
       // if (!$request->ajax()) return redirect('/');    
        
       //$asistencias = Asistencia::all(); 
       $asistencias = DB::table('asistencias')->toSql();
        
        return ['asistencias' => $asistencias ];
    }

    public function listarAsistenciasAlumno(Request $request){
        if (!$request->ajax()) return redirect('/');        
        
        $id = $request->id;

        $asistenciasA = Asistencia::select('asistencias.id','asistencias.idinscripcion',
        'asistencias.fecha_hora','asistencias.contador as contador')
        ->where('asistencias.idinscripcion','=',$id)
        ->get();       

        $cntAsistenciasAlumno = DB::table('asistencias')
        ->where('asistencias.idinscripcion',$id)
        ->count();   

 
        return ['asistencias' => $asistenciasA, 'contador' => $cntAsistenciasAlumno];
    }


    public function anotarAsistencia(Request $request)
    {
        if (!$request->ajax()) return redirect('/');

        $mytime= Carbon::now();
        $contador = $request->contador+1;
         
        try{
            DB::beginTransaction();
            $asistencia = new Asistencia();
            $asistencia->idinscripcion = $request->idinscripcion;
            $asistencia->fecha_hora = $mytime;
            $asistencia->contador = $contador;
            $asistencia->save();           
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }

    }    

    
    

    
}
