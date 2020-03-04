
/**
 * First we will load all of this project's JavaScript dependencies which
 * includes Vue and other libraries. It is a great starting point when
 * building robust, powerful web applications using Vue and Laravel.
 */

require('./bootstrap');

window.$ = window.jQuery = require('jquery'); 

window.Vue = require('vue');

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

Vue.component('dashboardadmin', require('./components/DashboardAdmin.vue').default);
Vue.component('dashboardoper', require('./components/DashboardOper.vue').default);
Vue.component('dashboardalumno', require('./components/DashboardAlumno.vue').default);
Vue.component('caja', require('./components/Caja.vue').default);

Vue.component('dbinscripciones', require('./components/DBInscripciones.vue').default);
Vue.component('dbventas', require('./components/DBVentas.vue').default);
Vue.component('dbinventario', require('./components/DBInventario.vue').default);
Vue.component('notification', require('./components/Notification.vue').default);

Vue.component('user', require('./components/User.vue').default);
Vue.component('rol', require('./components/Rol.vue').default);

Vue.component('cliente', require('./components/Cliente.vue').default);
Vue.component('proveedor', require('./components/Proveedor.vue').default);
Vue.component('alumno', require('./components/Alumno.vue').default);
Vue.component('profesor', require('./components/Profesor.vue').default);

Vue.component('perfilalumno', require('./components/PerfilAlumno.vue').default);


Vue.component('categoria', require('./components/Categoria.vue').default);
Vue.component('articulo', require('./components/Articulo.vue').default);

Vue.component('servicio', require('./components/Servicio.vue').default);
Vue.component('clasificacion', require('./components/Clasificacion.vue').default);

Vue.component('modalidad', require('./components/Modalidad.vue').default);
Vue.component('horario', require('./components/Horario.vue').default);
Vue.component('especialidad', require('./components/Especialidad.vue').default);
Vue.component('profesion', require('./components/Profesion.vue').default);

Vue.component('universidad', require('./components/Universidad.vue').default);
Vue.component('provincia', require('./components/Provincia.vue').default);
Vue.component('canton', require('./components/Canton.vue').default);

Vue.component('ingreso', require('./components/Ingreso.vue').default);
Vue.component('venta', require('./components/Venta.vue').default);
Vue.component('gasto', require('./components/Gasto.vue').default);
Vue.component('inscripcion', require('./components/Inscripcion.vue').default);

Vue.component('consultaingreso', require('./components/ConsultaIngreso.vue').default);
Vue.component('consultaventa', require('./components/ConsultaVenta.vue').default);


/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

const app = new Vue({
    el: '#app',
    data :{
        menu : 0,
        notifications: []
    },
    created() {
        let me = this;     
        axios.post('notification/get').then(function(response) {
           //console.log(response.data);
           me.notifications=response.data;    
        }).catch(function(error) {
            console.log(error);
        });

        var userId = $('meta[name="userId"]').attr('content');
        
        Echo.private('App.User.' + userId).notification((notification) => {
             me.notifications.unshift(notification); 
        }); 
        
    } 
});
