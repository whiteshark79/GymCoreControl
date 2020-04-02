<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use Illuminate\Support\Facades\DB; 

use App\User;
use App\Persona;
 
class LoginController extends Controller
{
    public function showLoginForm(){
        return view('auth.login');
    }
  
    public function login(Request $request){
        $this->validateLogin($request);        

        if (Auth::attempt(['usuario' => $request->usuario,'password' => $request->password,'condicion'=>1])){

        $personas = Persona::join('users','personas.id','=','users.id')
        ->select('users.usuario', 'users.avatar', 'users.idrol', DB::raw('SUBSTRING_INDEX(personas.nombre," ",1) as nombre'),
        DB::raw('SUBSTRING_INDEX(personas.nombre," ",-1) as apellido'),'personas.perfil')         
        ->where('users.usuario',$request->usuario)->get();
        
        $usuario = $personas[0]->usuario;
        $nombre = $personas[0]->nombre;
        $apellido = $personas[0]->apellido;
        $perfil = $personas[0]->perfil;
        $avatar = $personas[0]->avatar;
        
        $request->session()->put('usuario', $usuario);
        $request->session()->put('nombre', $nombre);
        $request->session()->put('apellido', $apellido);
        $request->session()->put('perfil', $perfil);
        $request->session()->put('avatar', $avatar);

            return redirect()->route('main');
        }

        return back()
        ->withErrors(['usuario' => trans('auth.failed')])
        ->withInput(request(['usuario']));

    } 

    protected function validateLogin(Request $request){
        $this->validate($request,[
            'usuario' => 'required|string|max:12',
            'password' => 'required|string|min:6'
        ]);

    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        return redirect('/');
    }
}
