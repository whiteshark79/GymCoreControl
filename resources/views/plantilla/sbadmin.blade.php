  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="../../index3.html" class="brand-link">
      <img src="img/logo_aside.png" alt="GymCore Logo" class="brand-image">
      <span class="brand-text font-weight-bold">GʏᴍCᴏʀᴇ ᴄᴏɴᴛʀᴏʟ</span>
    </a>

    <!-- Sidebar -->
    <div class="sidebar">

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
          <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
          <li @click="menu=0" class="nav-item ">
            <a href="#" class="nav-link {{ active('/') }}"><i class="nav-icon fas fa-tachometer-alt"></i><p>Dashboard</p></a>
          </li>          
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-users"></i><p>Personas<i class="fas fa-angle-left right"></p></i></a>
            <ul class="nav nav-treeview">
              <li @click="menu=1" class="nav-item"><a href="#" class="nav-link {{ active('alumno') }}"><i class="fas fa-caret-right nav-icon"></i><p>Alumnos</p></a></li>
              <li @click="menu=2" class="nav-item"><a href="#" class="nav-link {{ active('profesor') }}"><i class="fas fa-caret-right nav-icon"></i><p>Profesores</p></a></li>             
            </ul>
          </li>
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-boxes"></i><p>Inventario<i class="right fas fa-angle-left"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=3" class="nav-item"><a href="#" class="nav-link {{ active('categoria') }}"><i class="fas fa-caret-right nav-icon"></i><p>Categorías</p></a></li>
              <li @click="menu=4" class="nav-item"><a href="#" class="nav-link {{ active('articulo') }}"><i class="fas fa-caret-right nav-icon"></i><p>Artículos</p></a></li>              
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link"><i class="nav-icon fas fa-shopping-cart"></i><p>Compras<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=5" class="nav-item"><a href="#" class="nav-link {{ active('orden') }}"><i class="fas fa-caret-right nav-icon"></i><p>Órdenes</p></a></li>
              <li @click="menu=6" class="nav-item"><a href="#" class="nav-link {{ active('proveedor') }}"><i class="fas fa-caret-right nav-icon"></i><p>Proveedores</p></a></li>              
            </ul>
          </li>
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-hand-holding-usd"></i><p>Ventas<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=7" class="nav-item"><a  href="#" class="nav-link {{ active('factura') }}"><i class="fas fa-caret-right nav-icon"></i><p>Facturas</p></a></li>
              <li @click="menu=8" class="nav-item"><a  href="#" class="nav-link {{ active('inscripcion') }}"><i class="fas fa-caret-right nav-icon"></i><p>Inscripciones</p></a></li>
              <li @click="menu=9" class="nav-item"><a href="#" class="nav-link {{ active('cliente') }}"><i class="fas fa-caret-right nav-icon"></i><p>Clientes</p></a></li>              
            </ul>
          </li>
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-user-lock"></i><p>Acceso<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=10" class="nav-item"><a href="#" class="nav-link {{ active('usuario') }}"><i class="fas fa-caret-right nav-icon"></i><p>Usuarios</p></a></li>
              <li @click="menu=11" class="nav-item"><a href="#" class="nav-link {{ active('rol') }}"><i class="fas fa-caret-right nav-icon"></i><p>Roles</p></a></li>              
            </ul>
          </li>
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-chart-pie"></i><p>Reportes<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=12" class="nav-item"><a href="#" class="nav-link {{ active('compra') }}"><i class="fas fa-caret-right nav-icon"></i><p>Compras</p></a></li>
              <li @click="menu=13" class="nav-item"><a href="#" class="nav-link {{ active('venta') }}"><i class="fas fa-caret-right nav-icon"></i><p>Ventas</p></a></li>              
            </ul>
          </li>
          
          <li class="nav-header text-bold">ADMINISTRACIÓN</li>
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="nav-icon fas fa-cubes"></i><p>Paneles<i class="fas fa-angle-left right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=14" class="nav-item"><a href="#" class="nav-link {{ active('modalidade') }}"><i class="fas fa-caret-right nav-icon"></i><p>Modalidades</p></a></li>
              <li @click="menu=15" class="nav-item"><a href="#" class="nav-link {{ active('especialidade') }}"><i class="fas fa-caret-right nav-icon"></i><p>Especialidades</p></a></li>
              <li @click="menu=16" class="nav-item"><a href="#" class="nav-link {{ active('universidade') }}"><i class="fas fa-caret-right nav-icon"></i><p>Universidades</p></a></li>
              <li @click="menu=17" class="nav-item"><a href="#" class="nav-link {{ active('profesione') }}"><i class="fas fa-caret-right nav-icon"></i><p>Profesiones</p></a></li>
              <li @click="menu=18" class="nav-item"><a href="#" class="nav-link {{ active('provincia') }}"><i class="fas fa-caret-right nav-icon"></i><p>Provincias</p></a></li>
              <li @click="menu=19" class="nav-item"><a href="#" class="nav-link {{ active('cantone') }}"><i class="fas fa-caret-right nav-icon"></i><p>Cantones</p></a></li>             
            </ul>
          </li>
          <li class="nav-header text-bold">MISCELLANEOUS</li>
          <li @click="menu=20" class="nav-item"><a href="#" class="nav-link {{ active('acerca') }}"><i class="nav-icon fas fa-info"></i><p>Acerca de...<span class="badge badge-info">IT</span></p></a></li>    
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>