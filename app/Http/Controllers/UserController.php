<?php
 
namespace App\Http\Controllers;
use Illuminate\Support\Facades\DB; 
use Illuminate\Http\Request;

use App\User;
use App\Persona;
 
class UserController extends Controller
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
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id','personas.tipo_documento','personas.num_documento','personas.nombre',
            'personas.fec_nacimiento','personas.direccion','personas.celular', 'personas.email',
            'users.usuario','users.password', 'users.avatar', 'users.condicion','users.idrol','roles.nombre as rol')
            ->orderBy('personas.'.$ordenado, $ascdesc)->paginate($paginado);
        }
        else{
            $personas = User::join('personas','users.id','=','personas.id')
            ->join('roles','users.idrol','=','roles.id')
            ->select('personas.id','personas.tipo_documento','personas.num_documento','personas.nombre',
            'personas.fec_nacimiento','personas.direccion','personas.celular', 'personas.email',
            'users.usuario','users.password', 'users.avatar', 'users.condicion','users.idrol','roles.nombre as rol')           
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

    public function selectUsuario(Request $request)
    { 
        if (!$request->ajax()) return redirect('/');

        $usuario = $request->usuario;
        $avatar = User::where('usuario',$usuario)->get();      
        $stsUsuarioUser=$usuarioUser->count();
 
        return ['stsUsuarioUser'=>$stsUsuarioUser];     
    }

    public function selectAvatar(Request $request)
    { 
        if (!$request->ajax()) return redirect('/');

        $id = \Auth::user()->id;

        $avatarUser = User::select('avatar')->where('id',$id)->get();
 
        return ['avatarUser'=>$avatarUser[0]->avatar];     
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
            $persona->save();
 
            $user = new User();
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;
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

        try{
            DB::beginTransaction();
            $user = User::findOrFail($request->id);
            $persona = Persona::findOrFail($user->id);
 
            $persona->tipo_documento = $request->tipo_documento;
            $persona->num_documento = $request->num_documento;
            $persona->nombre = $request->nombre;
            $persona->fec_nacimiento = $request->fec_nacimiento;
            $persona->direccion = $request->direccion;
            $persona->celular = $request->celular;
            $persona->email = $request->email;
            $persona->save();
 
            $user->usuario = $request->usuario;
            $user->password = bcrypt( $request->password);
            $user->condicion = '1';
            $user->idrol = $request->idrol;
            $user->save();
 
            DB::commit();
 
        } catch (Exception $e){
            DB::rollBack();
        }
    }       

    public function actualizarUsuario(Request $request)
    {  
        try{
            DB::beginTransaction();            
            
            $id = \Auth::user()->id;    
            $user = User::find($id);
            $password= $request->password;
            $avatar= $request->avatar;

            $pic= $request->pic;

            
            if($avatar!=''){
                $exploded = explode(',', $avatar);
                $decoded = base64_decode($exploded[1]);
                if(str_contains($exploded[0], 'jpeg')) { $ext = 'jpg'; }else{  $ext = 'png'; }            
                $fileName = time().str_random(3).'.'.$ext;            
                $path = public_path().'/avatars/'.$fileName;
                file_put_contents($path , $decoded);  

                $path2 = public_path().'/avatars/'.$pic;
                unlink($path2); 
            }

            if($password!='' && $avatar!=''){
                $user->password = bcrypt($password);
                $user->avatar = $fileName; 
                $request->session()->put('avatar', $fileName);
            }elseif($password!='' && $avatar ==''){
                $user->password = bcrypt($password);
            }elseif($password =='' && $avatar!=''){
                $user->avatar = $fileName; 
            }
            $user->save(); 

            DB::commit();            
 
        } catch (Exception $e){
            DB::rollBack();
        }
    } 

 
    public function desactivar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '0';
        $user->save();
    }
 
    public function activar(Request $request)
    {
        if (!$request->ajax()) return redirect('/');
        $user = User::findOrFail($request->id);
        $user->condicion = '1';
        $user->save();
    } 
 
}