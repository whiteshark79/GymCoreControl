const mix = require('laravel-mix');

/*
 |--------------------------------------------------------------------------
 | Mix Asset Management
 |--------------------------------------------------------------------------
 |
 | Mix provides a clean, fluent API for defining some Webpack build steps
 | for your Laravel application. By default, we are compiling the Sass
 | file for the application as well as bundling up all the JS files.
 |
 */

mix.styles([
   'resources/assets/css/style.css',
   'resources/assets/css/fontawesome-all.min.css',   
   'resources/assets/css/Chart.min.css',
   'resources/assets/css/adminlte.css',
   'resources/assets/css/fullcalendar-main.min.css',
   'resources/assets/css/fullcalendar-daygrid.min.css',
   'resources/assets/css/fullcalendar-timegrid.min.css'
], 'public/css/plantilla.css')
.scripts([
   'resources/assets/js/jquery.min.js',   
   'resources/assets/js/Chart.min.js',
   'resources/assets/js/adminlte.min.js',
   'resources/assets/js/jquery.pace.min.js',
   //'resources/assets/js/popper.min.js',
   'resources/assets/js/sweetalert2.all.min.js',   
   'resources/assets/js/jquery.validate.min.js',
   'resources/assets/js/moment.min.js',
   'resources/assets/js/fullcalendar-main.min.js',
   'resources/assets/js/fullcalendar-daygrid.min.js',
   'resources/assets/js/fullcalendar-timegrid.min.js',
   'resources/assets/js/fullcalendar-interaction.min.js',
   'resources/assets/js/fullcalendar-bootstrap.min.js'
], 'public/js/plantilla.js')
.js(['resources/js/app.js'],'public/js/app.js');