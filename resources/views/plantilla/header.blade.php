 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light"> 
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item"><a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a></li>
      <li @click="menu=0" class="nav-item d-none d-sm-inline-block"><a href="#" class="nav-link">Inicio</a></li>
      <li @click="menu=25" class="nav-item d-none d-sm-inline-block"><a href="#" class="nav-link">Perfil</a></li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      <!-- Messages Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#"><i class="far fa-comments"></i><span class="badge badge-danger navbar-badge">3</span></a>
        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
          <a href="#" class="dropdown-item">
            <div class="media">
              <img src="img/user1-128x128.jpg" alt="User Avatar" class="img-size-50 mr-3 img-circle">
              <div class="media-body">
                <h3 class="dropdown-item-title">
                  Brad Diesel
                  <span class="float-right text-sm text-danger"><i class="fas fa-star"></i></span>
                </h3>
                <p class="text-sm">Call me whenever you can...</p>
                <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
              </div>
            </div>
          </a>                   
          <div class="dropdown-divider"></div>
          <a href="#" class="dropdown-item dropdown-footer">See All Messages</a>
        </div>
      </li>
      <notification :notifications="notifications"></notification>
      <!-- Cuenta Dropdown Menu -->
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#">
          <i class="fas fa-user-circle fa-lg"></i><span class="p-1" >{{Auth::user()->usuario}} </span>
        </a>


        <div class="dropdown-menu dropdown-menu-sm dropdown-menu-right">
          <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
            Cerrar sesión <i class="fas fa-sign-out-alt"></i> 
          </a>
          <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
          </form>          
          
        </div>        
      </li>    

    </ul>
  </nav>
  <!-- /.navbar -->