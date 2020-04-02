 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light"> 
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
  </ul> 
  
  <!-- Right navbar links -->     
    
    <ul class="navbar-nav ml-auto navbar-right">
      <notification :notifications="notifications"></notification>

      <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <i class="far fa-user-circle"></i><span class="p-1" >{{Auth::user()->usuario}} </span>
        </a>
          
          <ul id="login-dp" class="dropdown-menu">
            <li>
              <div class="navbar-content">
                  <div class="row">
                      <div class="col-md-6">
                          <img src="avatars/{{session('avatar')}}" alt="Avatar" class="img-responsive image avatar" />
                      </div>                    
                      <div class="col-md-6 data">
                          <span>{{session('nombre')}}  <span class="text-primary">{{session('apellido')}} </span></span>
                          <p class="text-muted small">{{session('perfil')}} </p>  
                          {{-- <button type="button" class="btn btn-primary btn-xs" data-toggle="modal" data-target="#clave"> Ver Perfil </button>  --}}
                      </div>
                  </div>
              </div>
              <div class="col-md-12">
                <div class="social-buttons">
                  {{-- <a href="#" class="btn btn-pass btn-xs" data-toggle="modal" data-target="#clave"><i class="fas fa-key"></i> Clave</a>                    --}}
                  <a href="#" class="btn btn-pass btn-xs" data-toggle="modal" data-target="#clave"><i class="far fa-id-card"></i> Perfil</a>                   
                  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-session btn-xs"><i class="fas fa-sign-out-alt"></i> Salir</a>
                  <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                    {{ csrf_field() }}
                  </form>                                       
                </div>
              </div>
              
            </li>
          </ul>
      </li>
  </ul>   

</nav>
<!-- /.navbar -->

<!--Inicio del modal agregar/actualizar-->
<div class="modal fade" id="clave">
  <div class="modal-dialog modal-xs modal-custom" role="document" id="myModal">
		<div class="modal-content">
			<div class="modal-header">
				<div>
					<img src="avatars/{{session('avatar')}}" alt="Avatar" class="avatar pic" />
				</div>				
				<h4 class="modal-title"><span>{{session('nombre')}}  <span class="text-primary">{{session('apellido')}} </span></span></h4>	
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
			</div>
			<div class="modal-body">
        <perfiluser usuario={{session('usuario')}}></perfiluser>       
      </div> 		
		</div>
	</div>
</div>
<!--Fin del modal-->
