<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Gasto;
use App\DetalleGasto;
use App\User; 

class GastoController extends Controller
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
            $gastos = Gasto::join('personas','gastos.idproveedor','=','personas.id')
            ->join('users','gastos.idusuario','=','users.id')
            ->select('gastos.id','gastos.tipo_comprobante','gastos.serie_comprobante',
            'gastos.num_comprobante','gastos.fecha_hora','gastos.impuesto','gastos.total',
            'gastos.estado','personas.nombre','users.usuario')
            ->orderBy('gastos.'.$ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $gastos = Gasto::join('personas','gastos.idproveedor','=','personas.id')
            ->join('users','gastos.idusuario','=','users.id')
            ->select('gastos.id','gastos.tipo_comprobante','gastos.serie_comprobante',
            'gastos.num_comprobante','gastos.fecha_hora','gastos.impuesto','gastos.total',
            'gastos.estado','personas.nombre','users.usuario')
            ->where('gastos.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('gastos.'.$ordenado, $ascdesc)->paginate($paginado);
        }
         
        return [
            'pagination' => [
                'total'        => $gastos->total(),
                'current_page' => $gastos->currentPage(),
                'per_page'     => $gastos->perPage(),
                'last_page'    => $gastos->lastPage(),
                'from'         => $gastos->firstItem(),
                'to'           => $gastos->lastItem(),
            ],
            'gastos' => $gastos
        ];
    }

    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $gasto = Gasto::join('personas','gastos.idproveedor','=','personas.id')
        ->join('users','gastos.idusuario','=','users.id')
        ->select('gastos.id','gastos.tipo_comprobante','gastos.serie_comprobante',
        'gastos.num_comprobante','gastos.fecha_hora','gastos.impuesto','gastos.total',
        'gastos.estado','personas.tipo_documento','personas.num_documento','personas.nombre',
        'personas.direccion','personas.celular','personas.email','users.usuario')
        ->where('gastos.id','=',$id)
        ->orderBy('gastos.id', 'desc')->take(1)->get();
         
        return ['gasto' => $gasto];
    }
    
    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $detalles = DetalleGasto::join('servicios','detalle_gastos.idservicio','=','servicios.id')
        ->select('detalle_gastos.cantidad','detalle_gastos.precio','servicios.nombre as servicio', 
        'servicios.descripcion as servicio_descripcion')
        ->where('detalle_gastos.idgasto','=',$id)
        ->orderBy('detalle_gastos.id', 'desc')->get();
         
        return ['detalles' => $detalles];
    }

    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        try{ 
            DB::beginTransaction();
 
            $mytime= Carbon::now();
 
            $gasto = new Gasto();
            $gasto->idproveedor = $request->idproveedor;
            $gasto->idusuario = \Auth::user()->id;
            $gasto->tipo_comprobante = $request->tipo_comprobante;
            $gasto->serie_comprobante = $request->serie_comprobante;
            $gasto->num_comprobante = $request->num_comprobante;
            $gasto->fecha_hora = $mytime;
            $gasto->impuesto = $request->impuesto;
            $gasto->total = $request->total;
            $gasto->estado = 'Registrado';
            $gasto->save();
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos
 
            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleGasto();
                $detalle->idgasto = $gasto->id;
                $detalle->idservicio = $det['idservicio'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];          
                $detalle->save();
            }    
 
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }     

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $gasto = Gasto::findOrFail($request->id);
        $gasto->estado = 'Anulado';
        $gasto->save();
    }
}
