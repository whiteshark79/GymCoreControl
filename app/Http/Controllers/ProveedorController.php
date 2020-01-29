<?php
 
namespace App\Http\Controllers;
 
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
 
use App\Proveedor;
use App\Persona;
  
 
class ProveedorController extends Controller
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
            $personas = Proveedor::join('personas','proveedores.id','=','personas.id')
            ->select('personas.id','personas.tipo_documento','personas.num_documento','personas.nombres','personas.apellidos',
            'personas.fec_nacimiento','personas.direccion','personas.celular','personas.email','personas.perfil',
            'proveedores.nombre_contacto','proveedores.celular_contacto','proveedores.email_contacto')
            ->orderBy('personas.'.$ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $personas = Proveedor::join('personas','proveedores.id','=','personas.id')
            ->select('personas.id','personas.tipo_documento','personas.num_documento','personas.nombres','personas.apellidos',
            'personas.fec_nacimiento','personas.direccion','personas.celular','personas.email','personas.perfil',
            'proveedores.nombre_contacto','proveedores.celular_contacto','proveedores.email_contacto')           
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
  
    public function selectProveedor(Request $request){
        if (!$request->ajax()) return redirect('/');
 
        $filtro = $request->filtro;
        $proveedores = Proveedor::join('personas','proveedores.id','=','personas.id')
        ->where('personas.nombres', 'like', '%'. $filtro . '%')
        ->orWhere('personas.apellidos', 'like', '%'. $filtro . '%')
        ->orWhere('personas.num_documento', 'like', '%'. $filtro . '%')
        ->select('personas.id','personas.nombres','personas.apellidos','personas.num_documento')
        ->orderBy('personas.nombres', 'asc')->get();
 
        return ['proveedores' => $proveedores];
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
            $persona->apellidos = '';
            $persona->fec_nacimiento = '';
            $persona->direccion = $request->direccion;
            $persona->celular = $request->celular;
            $persona->email = $request->email;
            $persona->perfil = 'Proveedor';
            $persona->save();
 
            $proveedor = new Proveedor();
            $proveedor->nombre_contacto = $request->nombre_contacto;
            $proveedor->celular_contacto = $request->celular_contacto;
            $proveedor->email_contacto = $request->email_contacto;
            $proveedor->id = $persona->id;
            $proveedor->save();
 
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
            $proveedor = Proveedor::findOrFail($request->id);
            $persona = Persona::findOrFail($proveedor->id);
 
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->nombres = $request->nombres;
            $persona->apellidos = '';
            $persona->fec_nacimiento = '';
            $persona->direccion = $request->direccion;
            $persona->celular = $request->celular;
            $persona->email = $request->email;
            $persona->perfil = 'Proveedor';
            $persona->save();
 
            $proveedor->nombre_contacto = $request->nombre_contacto;
            $proveedor->celular_contacto = $request->celular_contacto;
            $proveedor->email_contacto = $request->email_contacto;
            $proveedor->save();
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
    }    
    // public function desactivar(Request $request)
    // {
    //     if (!$request->ajax()) return redirect('/');
    //     $proveedor = Proveedor::findOrFail($request->id);
    //     $proveedor->condicion = '0';
    //     $proveedor->save();
    // }

    // public function activar(Request $request)
    // {
    //     if (!$request->ajax()) return redirect('/');
    //     $proveedor = Proveedor::findOrFail($request->id);
    //     $proveedor->condicion = '1';
    //     $proveedor->save();
    // }
}