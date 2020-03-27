  <!-- Main Sidebar Container -->
  <aside class="main-sidebar">   

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="navbar navbar-expand-lg navbar-dark bg-lightblue fixed-top" id="sideNav">
        
        <a href="../../index3.html" class="brand-link">
          <img src="img/logo_sidebar.png" alt="GymCore Logo" >          
        </a>  

        @if ($message = Session::get('success'))
        <div class="alert alert-success alert-block">
                <strong>{{ $message }}</strong>
        </div>
        {{-- <img src="avatars/{{ Session::get('file') }}"> --}}
        @endif
  
        @if (count($errors) > 0)
            <div class="alert alert-danger">
                <strong>Error!</strong>No se pudo actualizar el avatar.
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        
          <useravatar></useravatar>
       
         

        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
          <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
          <ul class="navbar-nav">            
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#about">Acerca de</a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#laboral">Datos Laborales</a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#fisico">Datos Físicos</a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#inscripcion">Inscripciones</a>
            </li>
            <li class="nav-item">
                <a class="nav-link js-scroll-trigger" href="#compra">Compras</a>
            </li>              
          </ul>          
        </div>
        <div class="my-auto" >   
          <ul class="list-inline list-social-icons mb-0">
            <li class="list-inline-item">
              <a href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" title="Salir">
                <span class="fa-stack fa-lg">
                  <i class="fas fa-sign-out-alt fa-stack-1x fa-inverse"></i>
                </span>
              </a>
            </li>
            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
              {{ csrf_field() }}
            </form>                           
        </ul>
        </div>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->    
  </aside>  