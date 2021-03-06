  <!-- Main Sidebar Container -->
  <aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="#" class="brand-link">
      <img src="img/logo_aside.png" alt="GymCore Logo" class="brand-image">
      <span class="brand-text">GʏᴍCᴏʀᴇ ᴄᴏɴᴛʀᴏʟ</span>
    </a>

    <!-- Sidebar -->    
    <div class="sidebar">      

      <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="profile_pic">
            <img src="avatars/{{Auth::user()->avatar}}" class="img-circle profile_img" alt="{{session('usuario')}}">
        </div>
        <div class="info menu_title">
            <span>Bienvenid@,</span>
            <h6>{{session('nombre')}} <span class="text-bold">{{session('apellido')}}</span></h6>
            <span class="user-status">
                <i class="fa fa-circle"></i>
                <span>{{session('perfil')}}</span>
            </span>          
        </div>
      </div>

      <!-- Sidebar Menu -->
      <nav class="mt-2">
        <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false"> 
          <li @click="menu=0" class="nav-item ">
            <a href="#" class="nav-link "><span class="icon_title"><i class="nav-icon icon-speedometer"></i></span><p class="menu_title">Dashboard</p></a>
          </li>
          <li @click="menu=1" class="nav-item ">
            <a href="#" class="nav-link "><span class="icon_title"><i class="nav-icon fas fa-calculator"></i></span><p class="menu_title">Caja</p></a>
          </li>            
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon icon-people"></i></span><p class="menu_title">Personas<i class="fas fa-chevron-right fa-xs right"></p></i></a>
            <ul class="nav nav-treeview">
              <li @click="menu=2" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p class="p-icon">Alumnos</p></a></li>
              <li @click="menu=3" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p class="p-icon">Clientes</p></a></li>
              <li @click="menu=4" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p class="p-icon">Proveedores</p></a></li>          
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon icon-list"></i></span><p class="menu_title">Inventario<i class="fas fa-chevron-right fa-xs right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=5" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p class="p-icon">Artículos</p></a></li>  
              <li @click="menu=6" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p class="p-icon">Categorías</p></a></li>                          
            </ul>
          </li>
          <li class="nav-item has-treeview"><a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon icon-credit-card"></i></span><p class="menu_title">Costos<i class="fas fa-chevron-right fa-xs right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=7" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p class="p-icon">Servicios</p></a></li>
              <li @click="menu=8" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p class="p-icon">Clasificaciones</p></a></li>              
            </ul>
          </li>
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon icon-basket"></i></span><p class="menu_title">Ingresos<i class="fas fa-chevron-right fa-xs right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=9" class="nav-item">
                <a  href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p class="p-icon">Ventas</p></a></li>
              <li @click="menu=10" class="nav-item">
                <a  href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p class="p-icon">Inscripciones</p></a></li>                         
            </ul>
          </li>          
          <li class="nav-item has-treeview">
            <a href="#" class="nav-link"><span class="icon_title"><i class="nav-icon icon-handbag"></i></span><p class="menu_title">Egresos<i class="fas fa-chevron-right fa-xs right"></i></p></a>
            <ul class="nav nav-treeview">
              <li @click="menu=11" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p class="p-icon">Compras</p></a></li>
              <li @click="menu=12" class="nav-item">
                <a href="#" class="nav-link "><i class="fas fa-angle-right fa-xs nav-icon nav-item-icon"></i><p class="p-icon">Gastos</p></a></li>
                           
            </ul>
          </li> 
             
        </ul>
      </nav>
      <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
  </aside>