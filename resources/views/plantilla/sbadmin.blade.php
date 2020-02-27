  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="img/logo_aside.png" alt="GymCore Logo" class="brand-image">
      <span class="brand-text font-weight-bold">GʏᴍCᴏʀᴇ ᴄᴏɴᴛʀᴏʟ</span>
    </a>

    <!-- Sidebar -->    
    <div class="sidebar">
      
      <!-- menu profile quick info -->
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
          <li @click="menu=0" class="nav-item "><a href="#" class="nav-link "><span class="icon_title"><i class="nav-icon fas fa-tachometer-alt"></i></span><p class="menu_title">Dashboard</p></a>
          </li>           
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-users"></i></span><p class="menu_title">Personas<i class="fas fa-angle-left right"></p></i></a>
            <ul class="nav nav-treeview">
              <li @click="menu=1" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>ALUMNOS</p></a></li>
              <li @click="menu=2" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>CLIENTES</p></a></li>   
              <li @click="menu=3" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>PROFESORES</p></a></li>
              <li @click="menu=4" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>PROVEEDORES</p></a></li>          
            </ul>
          </li>
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-boxes"></i></span><p class="menu_title">Inventario<i class="right fas fa-angle-left"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=5" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>ARTÍCULOS</p></a></li>  
              <li @click="menu=6" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>CATEGORÍAS</p></a></li>                          
            </ul>
          </li>
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-coins"></i></span><p class="menu_title">Costos<i class="right fas fa-angle-left"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=7" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>SERVICIOS</p></a></li>
              <li @click="menu=8" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>CLASIFICACIONES</p></a></li>              
            </ul>
          </li>
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-cash-register"></i></span><p class="menu_title">Ingresos<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=9" class="nav-item"><a  href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>VENTAS</p></a></li>
              <li @click="menu=10" class="nav-item"><a  href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>INSCRIPCIONES</p></a></li>                         
            </ul>
          </li>          
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-shopping-cart"></i></span><p class="menu_title">Egresos<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=11" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>COMPRAS</p></a></li>
              <li @click="menu=12" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>GASTOS</p></a></li>
                           
            </ul>
          </li>          
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-user-lock"></i></span><p class="menu_title">Acceso<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=13" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>USUARIOS</p></a></li>
              <li @click="menu=14" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>ROLES</p></a></li>              
            </ul>
          </li>
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-chart-pie"></i></span><p class="menu_title">Reportes<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=15" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>COMPRAS</p></a></li>
              <li @click="menu=16" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>VENTAS</p></a></li>              
            </ul>
          </li>
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-cubes"></i></span><p class="menu_title">Módulos<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview">              
              <li @click="menu=17" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>MODALIDADES</p></a></li>
              <li @click="menu=18" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>HORARIOS</p></a></li>
              <li @click="menu=19" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>ESPECIALIDADES</p></a></li>
              <li @click="menu=20" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>UNIVERSIDADES</p></a></li>
              <li @click="menu=21" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>PROFESIONES</p></a></li>
              <li @click="menu=22" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>PROVINCIAS</p></a></li>
              <li @click="menu=23" class="nav-item"><a href="#" class="nav-link "><i class="fas fa-angle-right nav-icon"></i><p>CANTONES</p></a></li>             
            </ul>
          </li>
             
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>