<template>
    <!-- Notifications Dropdown Menu -->
    <li class="nav-item dropdown">
        <a class="nav-link" data-toggle="dropdown" href="#">
            <i class="far fa-bell"></i><span class="badge badge-warning navbar-badge">{{notifications.length}}</span>
        </a>
        <div class="dropdown-menu dropdown-menu-md dropdown-menu-right">
            <div v-if="notifications.length">                
                <li v-for="item in listar" :key="item.id">
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-dumbbell mr-2"></i> {{item.inscripciones.msj}}
                        <span class="float-right badge badge-success">{{item.inscripciones.numero}}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-money-check-alt mr-2"></i> {{item.gastos.msj}}
                        <span class="float-right badge badge-secondary">{{item.gastos.numero}}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="fas fa-hand-holding-usd mr-2"></i> {{item.ventas.msj}}
                        <span class="float-right badge badge-info">{{item.ventas.numero}}</span>
                    </a>
                    <div class="dropdown-divider"></div>
                    <a href="#" class="dropdown-item">
                        <i class="icon-handbag mr-2"></i> {{item.ingresos.msj}}
                        <span class="float-right badge badge-warning">{{item.ingresos.numero}}</span>
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
            arrayNotifications:[]
        } 
    },
    computed:{
        listar: function()  {
            //return this.notifications[0];
             this.arrayNotifications = Object.values(this.notifications[0]);
            if (this.notifications == '') {
                    return this.arrayNotifications = []; 
            } else {
                //Capturo la ultima notificación agregada 
                this.arrayNotifications = Object.values(this.notifications[0]); 
                //Validación por indice fuera de rango
                if (this.arrayNotifications.length > 3) { 
                    //Si el tamaño es > 3 Es cuando las notificaciones son obtenidas desde el mismo servidor, es decir por la consulta con AXIOS 
                    return Object.values(this.arrayNotifications[4]); 
                } else { 
                    //Si el tamaño es < 3 Es cuando las notificaciones son obtenidas desde el canal privado, es decir mediante Laravel Echo y Pusher 
                    return Object.values(this.arrayNotifications[0]);
                } 
            }
        }
    }
}
</script>