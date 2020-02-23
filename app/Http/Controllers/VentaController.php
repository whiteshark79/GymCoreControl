<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB; 
use Carbon\Carbon;
use App\Venta;
use App\DetalleVenta;
use App\Persona;
use App\Articulo;
use App\User;
use App\Notifications\NotifyAdmin;

class VentaController extends Controller
{
    public function index(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $paginado = $request->paginado;
        $ordenado = $request->ordenado;
        $ascdesc = $request->ascdesc; 
         
        if ($buscar==''){
            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.tipo_comprobante','ventas.serie_comprobante',
            'ventas.num_comprobante','ventas.fecha_hora','ventas.impuesto','ventas.total',
            'ventas.abono','ventas.estado','personas.nombre','users.usuario')
            ->orderBy('ventas.'.$ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $ventas = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->join('users','ventas.idusuario','=','users.id')
            ->select('ventas.id','ventas.tipo_comprobante','ventas.serie_comprobante',
            'ventas.num_comprobante','ventas.fecha_hora','ventas.impuesto','ventas.total',
            'ventas.abono','ventas.estado','personas.nombre','users.usuario')
            ->where('ventas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('ventas.'.$ordenado, $ascdesc)->paginate($paginado);
        }
         
        return [
            'pagination' => [
                'total'        => $ventas->total(),
                'current_page' => $ventas->currentPage(),
                'per_page'     => $ventas->perPage(),
                'last_page'    => $ventas->lastPage(),
                'from'         => $ventas->firstItem(),
                'to'           => $ventas->lastItem(),
            ],
            'ventas' => $ventas
        ];
    }

    public function listarVentaCliente(Request $request){
        if (!$request->ajax()) return redirect('/');        
        
        $ventasM = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->select('ventas.id','ventas.idcliente','ventas.fecha_hora','ventas.total','ventas.abono','personas.nombre as cliente')
        ->whereColumn('ventas.total','>','ventas.abono')
        ->orderBy('ventas.fecha_hora', 'asc')
        //->take(10)
        ->get();  
 
        return ['ventasM' => $ventasM];
    }

    public function listarVentasCabeceraAlumno(Request $request){
        //if (!$request->ajax()) return redirect('/');        
        
        $id = \Auth::user()->id;

        $buscar = $request->buscar_;
        $criterio = $request->criterio_;
        $paginado = $request->paginado_;

        if ($buscar==''){
            $ventasCA = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->select('ventas.id','ventas.fecha_hora','ventas.abono','ventas.total','ventas.estado')
            ->where('personas.id',$id)
            ->orderBy('ventas.fecha_hora', 'desc')->paginate($paginado);
         }else{
            $ventasCA = Venta::join('personas','ventas.idcliente','=','personas.id')
            ->select('ventas.id','ventas.fecha_hora','ventas.abono','ventas.total','ventas.estado')
            ->where('personas.id',$id)
            ->where('ventas.'.$criterio, 'like', '%'. $buscar . '%')
            ->orderBy('ventas.fecha_hora', 'desc')->paginate($paginado);
         }
 
         return [
            'pagination_' => [
                'total_'        => $ventasCA->total(),
                'current_page_' => $ventasCA->currentPage(),
                'per_page_'     => $ventasCA->perPage(),
                'last_page_'    => $ventasCA->lastPage(),
                'from_'         => $ventasCA->firstItem(),
                'to_'           => $ventasCA->lastItem(),
            ],
            'ventasCA' => $ventasCA
        ];
    }

    public function listarVentasDetallesAlumno(Request $request){
        //if (!$request->ajax()) return redirect('/');        
        
        $id = $request->id;

        $ventasDA = DetalleVenta::join('articulos','detalle_ventas.idarticulo','=','articulos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio','detalle_ventas.descuento',
        'detalle_ventas.subtotal','articulos.nombre as articulo', 'articulos.descripcion as articulo_descripcion')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')
        ->get(); 
 
        return ['ventasDA' => $ventasDA];
    }

    public function listarArticuloVenta(Request $request){
        //if (!$request->ajax()) return redirect('/');

        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $paginado = $request->paginado;
        
        $anio=date('Y');
        
        if ($buscar==''){
            $detallesA = DetalleVenta::join('ventas','ventas.id','=','detalle_ventas.idventa')
            ->join('articulos','articulos.id','=','detalle_ventas.idarticulo')
            ->select(DB::raw('DATE_FORMAT(ventas.fecha_hora, "%M") as mes'),
            DB::raw('SUM(detalle_ventas.subtotal) as subtotal'),'articulos.nombre as nombre_articulo')          
            ->whereYear('ventas.fecha_hora',$anio)
            ->groupBy(DB::raw('DATE_FORMAT(ventas.fecha_hora, "%M")'), 'articulos.nombre')
            ->orderBy('ventas.fecha_hora', 'asc')->paginate($paginado);
        }
        else{
            $detallesA = DetalleVenta::join('ventas','ventas.id','=','detalle_ventas.idventa')
            ->join('articulos','articulos.id','=','detalle_ventas.idarticulo')
            ->select(DB::raw('DATE_FORMAT(ventas.fecha_hora, "%M") as mes'),
            DB::raw('SUM(detalle_ventas.subtotal) as subtotal'),'articulos.nombre as nombre_articulo')
            ->where('articulos.'.$criterio, 'like', '%'. $buscar . '%')         
            ->whereYear('ventas.fecha_hora',$anio)
            ->groupBy(DB::raw('DATE_FORMAT(ventas.fecha_hora, "%M")'), 'articulos.nombre')            
            ->orderBy('ventas.fecha_hora', 'asc')->paginate($paginado);
        }  
 
        return [
            'pagination' => [
                'total'        => $detallesA->total(),
                'current_page' => $detallesA->currentPage(),
                'per_page'     => $detallesA->perPage(),
                'last_page'    => $detallesA->lastPage(),
                'from'         => $detallesA->firstItem(),
                'to'           => $detallesA->lastItem(),
            ],
            'detallesA' => $detallesA
        ];
    }
 
    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $venta = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.tipo_comprobante','ventas.serie_comprobante',
        'ventas.num_comprobante','ventas.fecha_hora','ventas.impuesto','ventas.total',
        'ventas.abono','ventas.estado','personas.tipo_documento','personas.num_documento','personas.nombre',
        'personas.direccion','personas.celular','personas.email','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->take(1)->get();
         
        return ['venta' => $venta];
    }    
 
    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');        
 
        $id = $request->id;
        $detalles = DetalleVenta::join('articulos','detalle_ventas.idarticulo','=','articulos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio','detalle_ventas.descuento',
        'detalle_ventas.subtotal','articulos.nombre as articulo', 'articulos.descripcion as articulo_descripcion')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();
         
        return ['detalles' => $detalles];
    }

    public function pdf(Request $request, $id){

        $venta = Venta::join('personas','ventas.idcliente','=','personas.id')
        ->join('users','ventas.idusuario','=','users.id')
        ->select('ventas.id','ventas.tipo_comprobante','ventas.serie_comprobante',
        'ventas.num_comprobante','ventas.created_at','ventas.impuesto','ventas.total',
        'ventas.abono','ventas.estado','personas.tipo_documento','personas.num_documento','personas.nombre',
        'personas.direccion','personas.celular','personas.email','users.usuario')
        ->where('ventas.id','=',$id)
        ->orderBy('ventas.id', 'desc')->take(1)->get();

        $detalles = DetalleVenta::join('articulos','detalle_ventas.idarticulo','=','articulos.id')
        ->select('detalle_ventas.cantidad','detalle_ventas.precio','detalle_ventas.descuento',
        'detalle_ventas.subtotal', 'articulos.nombre as articulo', 'articulos.descripcion as articulo_descripcion')
        ->where('detalle_ventas.idventa','=',$id)
        ->orderBy('detalle_ventas.id', 'desc')->get();

        $numventa=Venta::select('num_comprobante')->where('id',$id)->get();

        $pdf=\PDF::loadview('pdf.venta',['venta'=>$venta,'detalles'=>$detalles]);
        return $pdf->download('venta-'.$numventa[0]->num_comprobante.'.pdf');
        

    }
     
    public function store(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        try{
            DB::beginTransaction();
 
            $mytime= Carbon::now();
            if($request->abono<$request->total){$estado = 'Debe';} else{$estado = 'Cancelado';}
 
            $venta = new Venta();
            $venta->idcliente = $request->idcliente;
            $venta->idusuario = \Auth::user()->id;
            $venta->tipo_comprobante = $request->tipo_comprobante;
            $venta->serie_comprobante = $request->serie_comprobante;
            $venta->num_comprobante = $request->num_comprobante;
            $venta->fecha_hora = $mytime;
            $venta->impuesto = $request->impuesto;
            $venta->total = $request->total;
            $venta->abono = $request->abono;
            $venta->estado = $estado;
            $venta->save();
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos
 
            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleVenta();
                $detalle->idventa = $venta->id;
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];
                $detalle->descuento = $det['descuento'];
                $detalle->subtotal = ($det['cantidad']*$det['precio'])-$det['descuento'];       
                $detalle->save();
            }
            
            $fechaActual= date('Y-m-d');
            $numVentas = DB::table('ventas')->whereDate('created_at', $fechaActual)->count(); 
            $numIngresos = DB::table('ingresos')->whereDate('created_at',$fechaActual)->count(); 

            $arregloDatos = [ 
            'ventas' => [ 
                        'numero' => $numVentas, 
                        'msj' => 'Ventas' 
                    ], 
            'ingresos' => [ 
                        'numero' => $numIngresos, 
                        'msj' => 'Ingresos' 
                    ] 
            ];                
            $allUsers = User::all();

            foreach ($allUsers as $notificar) { 
                User::findOrFail($notificar->id)->notify(new NotifyAdmin($arregloDatos)); 
            } 
 
            DB::commit();
            return[
                'id' => $venta->id
            ];
            
        } catch (Exception $e){
            DB::rollBack();
        }
    }
 
    public function desactivar(Request $request){
        if (!$request->ajax()) return redirect('/');
        $venta = Venta::findOrFail($request->id);
        $venta->estado = 'Anulado';
        $venta->save();
    }
}


