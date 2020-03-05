 <!-- Navbar -->
 <nav class="main-header navbar navbar-expand navbar-white navbar-light"> 
    <!-- Left navbar links -->
    <ul class="navbar-nav">
      <li class="nav-item">
        <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
      </li>
      <empresa></empresa> 
    </ul>
 
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
      
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