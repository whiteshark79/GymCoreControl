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
          <li @click="menu=0" class="nav-item ">
            <a href="#" class="nav-link "><span class="icon_title"><i class="nav-icon fas fa-tachometer-alt"></i></span><p class="menu_title">Dashboard</p></a>
          </li>
          <li @click="menu=1" class="nav-item ">
            <a href="#" class="nav-link "><span class="icon_title"><i class="nav-icon fas fa-calculator"></i></span><p class="menu_title">Caja</p></a>
          </li>            
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-users"></i></span><p class="menu_title">Personas<i class="fas fa-chevron-right fa-xs right"></p></i></a>
            <ul class="nav nav-treeview">
              <li @click="menu=2" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Alumnos</p></a></li>
              <li @click="menu=3" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Clientes</p></a></li>
              <li @click="menu=4" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Proveedores</p></a></li>          
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-boxes"></i></span><p class="menu_title">Inventario<i class="fas fa-chevron-right fa-xs right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=5" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Artículos</p></a></li>  
              <li @click="menu=6" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Categorías</p></a></li>                          
            </ul>
          </li>
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-coins"></i></span><p class="menu_title">Costos<i class="fas fa-chevron-right fa-xs right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=7" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Servicios</p></a></li>
              <li @click="menu=8" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Clasificaciones</p></a></li>              
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-cash-register"></i></span><p class="menu_title">Ingresos<i class="fas fa-chevron-right fa-xs right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=9" class="nav-item">
                <a  href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Ventas</p></a></li>
              <li @click="menu=10" class="nav-item">
                <a  href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Inscripciones</p></a></li>                         
            </ul>
          </li>          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-shopping-cart"></i></span><p class="menu_title">Egresos<i class="fas fa-chevron-right fa-xs right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=11" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Compras</p></a></li>
              <li @click="menu=12" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Gastos</p></a></li>
                           
            </ul>
          </li> 
             
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>