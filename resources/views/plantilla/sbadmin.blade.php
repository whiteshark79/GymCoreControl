  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-secondary elevation-1">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="img/logo_aside.png" alt="GymCore Logo" class="brand-image">
      <span class="brand-text">GʏᴍCᴏʀᴇ ᴄᴏɴᴛʀᴏʟ</span>
    </a>

    <!-- Sidebar -->    
    <div class="sidebar">
      <useravatar></useravatar>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false"> 
          <li @click="menu=0" class="nav-item ">
            <a href="#" class="nav-link "><span class="icon_title"><i class="nav-icon fas fa-tachometer-alt"></i></span><p class="menu_title">Dashboard</p></a>
          </li>           
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-users"></i></span><p class="menu_title">Personas<i class="fas fa-chevron-right fa-xs right"></p></i></a>
            <ul class="nav nav-treeview">
              <li @click="menu=1" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Alumnos</p></a></li>
              <li @click="menu=2" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Clientes</p></a></li>   
              <li @click="menu=3" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Profesores</p></a></li>
              <li @click="menu=4" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Proveedores</p></a></li>          
            </ul>
          </li>
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-boxes"></i></span><p class="menu_title">Inventario<i class="fas fa-chevron-right fa-xs right"></i></p></a>
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
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-cash-register"></i></span><p class="menu_title">Ingresos<i class="fas fa-chevron-right fa-xs right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=9" class="nav-item">
                <a  href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Ventas</p></a></li>
              <li @click="menu=10" class="nav-item">
                <a  href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Inscripciones</p></a></li>                         
            </ul>
          </li>          
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-shopping-cart"></i></span><p class="menu_title">Egresos<i class="fas fa-chevron-right fa-xs right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=11" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Compras</p></a></li>
              <li @click="menu=12" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Gastos</p></a></li>
                           
            </ul>
          </li>          
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-user-lock"></i></span><p class="menu_title">Acceso<i class="fas fa-chevron-right fa-xs right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=13" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Usuarios</p></a></li>
              <li @click="menu=14" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Roles</p></a></li>              
            </ul>
          </li>
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-chart-pie"></i></span><p class="menu_title">Reportes<i class="fas fa-chevron-right fa-xs right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=15" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Compras</p></a></li>
              <li @click="menu=16" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Ventas</p></a></li>              
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon fas fa-cubes"></i></span><p class="menu_title">Módulos<i class="fas fa-chevron-right fa-xs right"></i></p></a>
            <ul class="nav nav-treeview"> 
              <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Empresa<i class="right fas fa-angle-right"></i></p></a>
                <ul class="nav nav-treeview">
                  <li @click="menu=17" class="nav-item">
                    <a href="#" class="nav-link "><i class="fas fa-genderless fa-xs nav-icon nav-item-icon-level"></i><p>Datos</p></a></li>
                  <li @click="menu=18" class="nav-item">
                    <a href="#" class="nav-link "><i class="fas fa-genderless fa-xs nav-icon nav-item-icon-level"></i><p>Locales</p></a></li>              
                </ul>
              </li>             
              <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Inscripciones<i class="right fas fa-angle-right"></i></p></a>
                <ul class="nav nav-treeview">                     
                  <li @click="menu=19" class="nav-item">
                    <a href="#" class="nav-link "><i class="fas fa-genderless fa-xs nav-icon nav-item-icon-level"></i><p>Horarios</p></a></li> 
                  <li @click="menu=20" class="nav-item">
                    <a href="#" class="nav-link "><i class="fas fa-genderless fa-xs nav-icon nav-item-icon-level"></i><p>Modalidades</p></a></li>
                  <li @click="menu=21" class="nav-item">
                    <a href="#" class="nav-link "><i class="fas fa-genderless fa-xs nav-icon nav-item-icon-level"></i><p>Rutinas</p></a></li> 
                  <li @click="menu=22" class="nav-item">
                    <a href="#" class="nav-link "><i class="fas fa-genderless fa-xs nav-icon nav-item-icon-level"></i><p>Calendarios</p></a></li>               
                </ul>
              </li>
              <li class="nav-item has-treeview"><a href="#" class="nav-link"><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p>Personas<i class="right fas fa-angle-right"></i></p></a>
                <ul class="nav nav-treeview">
                  <li @click="menu=23" class="nav-item">
                    <a href="#" class="nav-link "><i class="fas fa-genderless fa-xs nav-icon nav-item-icon-level"></i><p>Especialidades</p></a></li>
                  <li @click="menu=24" class="nav-item">
                    <a href="#" class="nav-link "><i class="fas fa-genderless fa-xs nav-icon nav-item-icon-level"></i><p>Universidades</p></a></li>
                  <li @click="menu=25" class="nav-item">
                    <a href="#" class="nav-link "><i class="fas fa-genderless fa-xs nav-icon nav-item-icon-level"></i><p>Profesiones</p></a></li>                
                </ul>
              </li>               
            </ul>
          </li>         
             
        </ul>
        
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside> 