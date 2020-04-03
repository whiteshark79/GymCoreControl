 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light"> 
  <!-- Left navbar links -->
  <ul class="navbar-nav">
    <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="icon-grid"></i></a></li>
  </ul> 
  
  <!-- Right navbar links -->     
    
    <ul class="navbar-nav ml-auto navbar-right">
      <notification :notifications="notifications"></notification>

      <li class="nav-item dropdown">
        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
          <i class="icon-settings"></i><span class="p-1" >{{Auth::user()->usuario}} </span>
        </a>
          
          <ul id="login-dp" class="dropdown-menu">
            <li>
              <div class="navbar-content">
                  <div class="row">
                      <div class="col-md-6">
                          <img src="avatars/{{Auth::user()->avatar}}" alt="Avatar" class="img-responsive image avatar" />
                      </div>                    
                      <div class="col-md-6 data">
                          <span>{{session('nombre')}}  <span class="text-primary">{{session('apellido')}} </span></span>
                          <p class="text-muted small">{{session('perfil')}} </p>  
                      </div>
                  </div>
              </div>
              <div class="col-md-12">
                <div class="social-buttons">
                  <a href="#" class="btn btn-pass btn-xs" data-toggle="modal" data-target="#clave"><i class="icon-info"></i> Perfil</a>                   
                  <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" class="btn btn-session btn-xs"><i class="icon-logout"></i> Salir</a>
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
