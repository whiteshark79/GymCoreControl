<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Ingreso;
use App\DetalleIngreso;
use App\User; 
use App\Notifications\NotifyAdmin;

 
class IngresoController extends Controller
{
    public function index(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        $buscar = $request->buscar;
        $criterio = $request->criterio;
        $paginado = $request->paginado;
        $ordenado = $request->ordenado;
        $ascdesc = $request->ascdesc;

        if($criterio == 'idproveedor' && $buscar != ''){$filtro = $buscar;}else{$filtro = '%'. $buscar . '%';}
          
        if ($buscar==''){
            $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
            ->join('users','ingresos.idusuario','=','users.id')
            ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
            'ingresos.num_comprobante','ingresos.fecha_hora','ingresos.impuesto','ingresos.total',
            'ingresos.abono','ingresos.estado','personas.nombre','users.usuario')
            ->orderBy('ingresos.'.$ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $ingresos = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
            ->join('users','ingresos.idusuario','=','users.id')
            ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
            'ingresos.num_comprobante','ingresos.fecha_hora','ingresos.impuesto','ingresos.total',
            'ingresos.abono','ingresos.estado','personas.nombre','users.usuario')
            ->where('ingresos.'.$criterio, 'like', $filtro ) 
            ->orderBy('ingresos.'.$ordenado, $ascdesc)->paginate($paginado);
        }
         
        return [
            'pagination' => [
                'total'        => $ingresos->total(),
                'current_page' => $ingresos->currentPage(),
                'per_page'     => $ingresos->perPage(),
                'last_page'    => $ingresos->lastPage(),
                'from'         => $ingresos->firstItem(),
                'to'           => $ingresos->lastItem(),
            ],
            'ingresos' => $ingresos
        ];
    }

    public function obtenerCabecera(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $ingreso = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
        ->join('users','ingresos.idusuario','=','users.id')
        ->select('ingresos.id','ingresos.tipo_comprobante','ingresos.serie_comprobante',
        'ingresos.num_comprobante','ingresos.fecha_hora','ingresos.impuesto','ingresos.total',
        'ingresos.abono','ingresos.estado','personas.tipo_documento','personas.num_documento','personas.nombre',
        'personas.direccion','personas.celular','personas.email','users.usuario')
        ->where('ingresos.id','=',$id)
        ->orderBy('ingresos.id', 'desc')->take(1)->get();
         
        return ['ingreso' => $ingreso];
    }
    
    public function obtenerDetalles(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $id = $request->id;
        $detalles = DetalleIngreso::join('articulos','detalle_ingresos.idarticulo','=','articulos.id')
        ->select('detalle_ingresos.cantidad','detalle_ingresos.precio','articulos.nombre as articulo', 
        'articulos.descripcion as articulo_descripcion')
        ->where('detalle_ingresos.idingreso','=',$id)
        ->orderBy('detalle_ingresos.id', 'desc')->get();
         
        return ['detalles' => $detalles];
    }

    public function listarIngresosDiario(Request $request){
        if (!$request->ajax()) return redirect('/');        
        
        $fechaActual= date('Y-m-d'); 
        $fecha_hora = $request->fecha;
        if($fecha_hora){$fecha = $fecha_hora;}else{$fecha = $fechaActual;}   

        $ingresosDia = Ingreso::join('personas','ingresos.idproveedor','=','personas.id')
        ->select('ingresos.id','ingresos.fecha_hora', 'personas.nombre as proveedor', 'ingresos.impuesto', 'ingresos.total', 'ingresos.abono', 'ingresos.estado')
        ->whereDate('ingresos.fecha_hora', $fecha)
        ->whereIn('ingresos.estado',['Cancelado','Debe'])  
        ->orderBy('ingresos.fecha_hora', 'desc')->get();         
 
         return [ 'ingresosDia' => $ingresosDia ];
    }
 
    public function store(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
 
        try{ 
            DB::beginTransaction();
 
            $mytime= Carbon::now();
            if($request->abono < $request->total){$estado = 'Debe';} else{$estado = 'Cancelado';}
 
            $ingreso = new Ingreso();
            $ingreso->idproveedor = $request->idproveedor;
            $ingreso->idusuario = \Auth::user()->id;
            $ingreso->tipo_comprobante = $request->tipo_comprobante;
            $ingreso->serie_comprobante = $request->serie_comprobante;
            $ingreso->num_comprobante = $request->num_comprobante;
            $ingreso->fecha_hora = $mytime;
            $ingreso->impuesto = $request->impuesto;
            $ingreso->total = $request->total;
            $ingreso->abono = $request->abono;
            $ingreso->estado = $estado;
            $ingreso->save();
 
            $detalles = $request->data;//Array de detalles
            //Recorro todos los elementos
 
            foreach($detalles as $ep=>$det)
            {
                $detalle = new DetalleIngreso();
                $detalle->idingreso = $ingreso->id;
                $detalle->idarticulo = $det['idarticulo'];
                $detalle->cantidad = $det['cantidad'];
                $detalle->precio = $det['precio'];          
                $detalle->save();
            }
            
            $fechaActual= date('Y-m-d');
            $numInscripciones = DB::table('inscripciones')->whereDate('created_at',$fechaActual)->count(); 
            $numGastos = DB::table('gastos')->whereDate('created_at',$fechaActual)->count(); 
            $numVentas = DB::table('ventas')->whereDate('created_at', $fechaActual)->count(); 
            $numIngresos = DB::table('ingresos')->whereDate('created_at',$fechaActual)->count(); 
            

            $arregloDatos = [ 
                'inscripciones' => [ 
                    'numero' => $numInscripciones, 
                    'msj' => 'Inscripciones' 
                ],
                'gastos' => [ 
                    'numero' => $numGastos, 
                    'msj' => 'Gastos' 
                ],
                'ventas' => [ 
                    'numero' => $numVentas, 
                    'msj' => 'Ventas' 
                ],
                'ingresos' => [ 
                    'numero' => $numIngresos, 
                    'msj' => 'Compras' 
                ]
                
            ];
                            
            $allUsers = User::all();

            foreach ($allUsers as $notificar) { 
                User::findOrFail($notificar->id)->notify(new NotifyAdmin($arregloDatos)); 
            } 
 
            DB::commit();
        } catch (Exception $e){
            DB::rollBack();
        }
    }     

    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $ingreso = Ingreso::findOrFail($request->id);
        $ingreso->estado = 'Anulado';
        $ingreso->save();
    }
}
