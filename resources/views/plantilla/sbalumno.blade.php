
  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="img/logo_aside.png" alt="GymCore Logo" class="brand-image">
      <span class="brand-text font-weight-bold">GʏᴍCᴏʀᴇ ᴄᴏɴᴛʀᴏʟ</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">
      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="image">
          <img src="/img/avatar5.png" class="img-circle" alt="User Image">
        </div>
        <div class="info">
          <a href="#" class="d-block">{{Auth::user()->usuario}}</a>
        </div>
      </div>
        
       

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->           
          <li class="nav-item has-treeview menu-open"><a href="#" class="nav-link active"><i class="nav-icon fas fa-user-cog"></i><p class="menu_title">Opciones<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview">              
              <li @click="menu=0" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-caret-right nav-icon"></i><p>PERFIL</p></a></li>
              <li @click="menu=1" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-caret-right nav-icon"></i><p>REPORTES</p></a></li>           
            </ul>
          </li>         
            
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
    
  </aside>
