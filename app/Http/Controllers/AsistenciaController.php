<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Asistencia;

class AsistenciaController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');    
        
        $asistencias = Asistencia::all(); 
        
        return ['asistencias' => $asistencias ];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
         
        try{
            DB::beginTransaction();
            $asistencia = new Asistencia();
            $asistencia->id = $request->id;
            $asistencia->idalumno = $request->idalumno;
            $asistencia->contador = $request->contador;
            $asistencia->clases = $request->clases;
            $asistencia->save();           
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }

    }
}
