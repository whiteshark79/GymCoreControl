<template>
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i><span class="badge badge-warning navbar-badge">{{notifications.length}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
            <div v-if="notifications.length">                
                <li v-for="item in notifications" :key="item.id">
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-shopping-cart mr-2"></i> {{ item.data.datos.ingresos.msj }}
                        <span class="float-right badge badge-info">{{ item.data.datos.ingresos.numero }}</span>
                    </a>          
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-hand-holding-usd mr-2"></i> {{ item.data.datos.ventas.msj }}
                        <span class="float-right badge badge-success">{{ item.data.datos.ventas.numero }}</span>
                    </a>
                </li>
            </div>
            <div v-else>
                <span class="dropdown-item dropdown-header">No tiene notificaciones</span>
            </div>
        </div>
    </li> 
</template>
<script>
export default {
    props : ['notifications'],
    data (){
        return {

        }
    }
}
</script>