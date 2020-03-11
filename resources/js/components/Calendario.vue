<template>

    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Calendarios</h3></div>
                            <div class="card-tools">
                                <template v-if="listado!=0">
                                    <button type="button" class="btn btn-sm btn-primary" @click="mostrarDetalle()"><i class="fas fa-plus-circle">  Nuevo Calendario</i></button>
                                </template>
                            </div>
                        </div>                      
 
                        <!-- Listado -->
                        <template v-if="listado==1">
                            <div class="card-body">
                                <div class="form-group row justify-content-between">
                                    <div class="input-group input-group-sm col-7">                                
                                        <select class="form-control col-2 " v-model="criterio" @change="ceroBusqueda();">
                                            <option value="fecha_hora">Fecha</option>
                                            <option value="idlocal">Local</option>                                   
                                        </select>                                        
                                        <template v-if="criterio=='fecha_hora'">
                                            <input type="date" v-model="buscar" class="form-control col-4">
                                        </template>
                                        <template v-else-if="criterio=='idlocal'">                                            
                                            <select class="form-control  col-5"  v-model="buscar">
                                                <option value="0" disabled>--Local--</option>
                                                <option v-for="local in arrayLocal" :key="local.id" :value="local.id" v-text="local.nombre"></option>
                                            </select>
                                        </template>                                        
                                        <template v-else>
                                            <input type="number" v-model="buscar" @keyup.enter="listarCalendario(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control col-4" placeholder="No del comprobante">
                                        </template>                                       
                                        <button type="submit" @click="listarCalendario(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>                                 
                                        <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="fas fa-redo"></i> </button>
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="input-group input-group-sm col-1">                                     
                                        <select class="form-control" v-model="paginado" @change="listarCalendario(1,buscar,criterio,paginado,ordenado,ascdesc)">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-sm table-hover" id="dtTable">
                                        <thead  class="thead-table">
                                            <tr align="center">
                                                <th width="5%">#
                                                    <template v-if="(ordenado !== 'id' && ascdesc === 'asc') || (ordenado === 'id' && ascdesc === 'desc') ">
                                                        <a href="#" @click="listarCalendario(1,buscar,criterio,paginado,'id','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'id' && ascdesc === 'desc') || (ordenado === 'id' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarCalendario(1,buscar,criterio,paginado,'id','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>
                                                <th width="12%">FECHA
                                                    <template v-if="(ordenado !== 'fecha_hora' && ascdesc === 'asc') || (ordenado === 'fecha_hora' && ascdesc === 'desc') ">
                                                        <a href="#" @click="listarCalendario(1,buscar,criterio,paginado,'fecha_hora','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'fecha_hora' && ascdesc === 'desc') || (ordenado === 'fecha_hora' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarCalendario(1,buscar,criterio,paginado,'fecha_hora','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>
                                                <th width="22%">LOCAL
                                                    <template v-if="(ordenado !== 'idlocal' && ascdesc === 'asc') || (ordenado === 'idlocal' && ascdesc === 'desc')">
                                                        <a href="#" @click="listarCalendario(1,buscar,criterio,paginado,'idlocal','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'idlocal' && ascdesc === 'desc') || (ordenado === 'idlocal' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarCalendario(1,buscar,criterio,paginado,'idlocal','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>                                                
                                                <th width="41%">PERIODO
                                                    <template v-if="(ordenado !== 'fecha_ini' && ascdesc === 'asc') || (ordenado === 'fecha_ini' && ascdesc === 'desc')">
                                                        <a href="#" @click="listarCalendario(1,buscar,criterio,paginado,'fecha_ini','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'fecha_ini' && ascdesc === 'desc') || (ordenado === 'fecha_ini' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarCalendario(1,buscar,criterio,paginado,'fecha_ini','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>                                  
                                                <th width="10%">ESTADO
                                                    <template v-if="(ordenado !== 'condicion' && ascdesc === 'asc') || (ordenado === 'condicion' && ascdesc === 'desc')">
                                                        <a href="#" @click="listarCalendario(1,buscar,criterio,paginado,'condicion','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'condicion' && ascdesc === 'desc') || (ordenado === 'condicion' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarCalendario(1,buscar,criterio,paginado,'condicion','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>                                                                                    
                                                <th width="10%">ACCIONES</th>
                                            </tr>
                                        </thead> 
                                        <tbody v-if="arrayCalendario.length">
                                            <tr v-for="calendario in arrayCalendario" :key="calendario.id">
                                                <td v-text="calendario.id"></td>
                                                <td v-text="calendario.fecha_hora"></td>
                                                <td v-text="calendario.local"></td>
                                                <td>{{calendario.fecha_ini}} - {{calendario.fecha_fin}} </td>                                                
                                                <td align="center">
                                                    <div v-if="calendario.condicion"><span class="badge badge-success">Activo</span></div>
                                                    <div v-else><span class="badge badge-secondary">Inactivo</span></div>                                    
                                                </td>
                                                <td align="center">
                                                    <a class="btn btn-sm btn-default" @click="verCalendario(calendario.id)"><i class="far fa-eye"></i></a>                                 
                                                    <template v-if="calendario.estado=='Cancelado'">
                                                        <a class="btn btn-sm btn-default" @click="desactivarCalendario(calendario.id)"><i class="fas fa-ban" title="Desactivar"></i></a>  
                                                    </template> 
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="10" class="text-center">
                                                    <span class="badge badge-pill badge-secondary">-- NO existen registros --</span>                                       
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <nav>
                                    <ul class="pagination justify-content-end">
                                        <li class="page-item" v-if="pagination.current_page > 1">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio,paginado,ordenado,ascdesc)">« Ant</a>
                                        </li>
                                        <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio,paginado,ordenado,ascdesc)" v-text="page"></a>
                                        </li>
                                        <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                                            <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio,paginado,ordenado,ascdesc)">Sig »</a>
                                        </li>
                                    </ul>
                                </nav>
                            </div>
                        </template>
                        <!-- Fin Listado -->

                        <!-- Detalle -->
                        <template v-else-if="listado==0">     
                            <div class="card-body">
                                <div class="table-title">
                                    <div class="row">
                                        <div class="col-sm-6" ><h5>Nuevo <b>Calendario</b></h5></div>                                    
                                    </div>
                                </div>
                                <div class="form-row">    
                                    <div class="input-group input-group-sm mb-3 col-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Desde: </span>
                                        </div>
                                        <input type="date" v-model="fecha_ini" class="form-control" v-bind:class="{ 'is-invalid': e_fecha_ini }">
                                    </div>
                                    <div class="input-group input-group-sm mb-3 col-3">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Hasta: </span>
                                        </div>
                                        <input type="date" v-model="fecha_fin" class="form-control" v-bind:class="{ 'is-invalid': e_fecha_fin }">
                                    </div>
                                    <div class="input-group input-group-sm mb-3 col-2">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Local: </span>
                                        </div>
                                        <select v-model="idlocal" class="form-control" v-bind:class="{ 'is-invalid': e_idlocal }">
                                            <option value="0" disabled>--Seleccione--</option>
                                            <option v-for="local in arrayLocal" :key="local.id" :value="local.id" v-text="local.nombre"></option>
                                        </select>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" class="btn btn-sm btn-primary" @click="selectHorario()"><i class="far fa-calendar-check">Generar</i></button>  
                                    </div>                                                        
                                    
                                </div>

                                <div class="row col-12">
                                    <div class="table-responsive-sm">
                                        <table class="table table-bordered table-hover" id="dtTable">
                                            <thead>
                                                <tr align="center">
                                                    <th scope="col"></th>
                                                    <th scope="col">Lunes</th>
                                                    <th scope="col">Martes</th>
                                                    <th scope="col">Miércoles</th>
                                                    <th scope="col">Jueves</th>
                                                    <th scope="col">Viernes</th>
                                                    <th scope="col">Sábado</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr v-for="horario in arrayHorario" :key="horario.id">
                                                    <!-- <th class="rotate"><div><span>{{ horario.periodo}}</span></div></th> -->
                                                    <th scope="row">{{ horario.hora_ini}} - {{ horario.hora_fin}}</th>
                                                        <td>
                                                            <select v-model="idprofesor" class="form-control form-control-sm" v-bind:class="{ 'is-invalid': e_idprofesor }">
                                                                <option value="0" disabled>--Seleccione--</option>
                                                                <option v-for="profesor in arrayProfesor" :key="profesor.id" :value="profesor.id" v-text="profesor.nombre"></option>
                                                            </select>
                                                        </td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                        <td></td>
                                                </tr>                                                
                                            </tbody>
                                        </table>
                                        {{ crearPeriodo }}
                                    </div>

                                    

                                </div>
                            </div>                         
                        </template>
                        <!-- Fin Detalle -->

                        <!-- Ver calendario -->
                        <template v-else-if="listado==2">
                            <div class="card-body col-10 offset-md-1">                            
                                <div class="invoice p-3 mb-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <i class="fas fa-cash-register"></i> Factura de calendario
                                                <small class="float-right">Fecha: {{ hoyFecha() }} </small>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                    <h6>Cliente</h6> 
                                    <address>
                                        <strong>{{ cliente }}</strong><br>
                                        Dirección: {{ direccion }}<br>
                                        Teléfono: {{ celular }}<br>
                                        Correo: {{ email }}
                                    </address>
                                    </div>
                                    <!-- /.col -->                                    
                                    <div class="col-sm-4 invoice-col">
                                    <b>{{ tipo_comprobante }}</b>  {{ serie_comprobante }} - {{ num_comprobante }}<br>
                                    <br>
                                    <b>ID:</b> {{ id }}<br>
                                    <b>Fecha: </b> {{ fecha_hora }}<br>
                                    <b>IVA:</b> {{ impuesto }}
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <div class="row">                                    
                                    <div class="col-12 table-responsive">         
                                        <div class="card card-primary card-outline">                                            
                                            <div class="card-body">                                                
                                                <div class="table-responsive col-md-12">
                                                    <table class="table table-bordered table-sm table-hover" id="dtTable">
                                                        <thead class="thead-light">
                                                            <tr align="center">                                                                                                         
                                                                <th style="width: 30%">Artículo</th>
                                                                <th style="width: 40%">Descripción</th>
                                                                <th width="4%">Cantidad</th>
                                                                <th>Precio</th>                                                                
                                                                <th>Descuento</th>
                                                                <th>Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="detalle in arrayDetalle" :key="detalle.id">                                                                
                                                                <td v-text="detalle.articulo"></td>
                                                                <td v-text="detalle.articulo_descripcion"></td>
                                                                <td align="right" v-text="detalle.cantidad"></td>
                                                                <td align="right">$ {{ detalle.precio }}</td>                                                                
                                                                <td align="right">$ {{ detalle.descuento }}</td>
                                                                <td align="right">$ {{detalle.precio*detalle.cantidad-detalle.descuento}}</td>
                                                            </tr>                                                            
                                                        </tbody>                                                                                            
                                                    </table>                                                    
                                                    <table width="250" align="right" v-if="arrayDetalle.length">
                                                            <tr>
                                                                <td align="left"><strong>Abono:</strong></td>
                                                                <td align="right" class="w-25">$ {{abono}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"><strong>Total Parcial:</strong></td>
                                                                <td align="right" class="w-25">$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"><strong>Total Impuesto:</strong></td>
                                                                <td align="right">$ {{totalImpuesto=(total*impuesto).toFixed(2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"><strong>Total Neto:</strong></td>
                                                                <td align="right"><strong>$ {{total}} </strong> </td>
                                                            </tr>                                                       
                                                        </table>
                                                </div>                                                                                                                                
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary btn-sm float-right">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                    
                            </div>
                        </template>
                        <!-- Fin Ver Calendario -->

                    </div>
                </div>
            </div>            
        </div>           
    </main>

</template>

<script>
    import 'vue-select/dist/vue-select.css';
    import vSelect from 'vue-select';
    export default {
        data (){
            return {                
                arrayCalendario : [],
                arrayDetalle : [],
                arrayLocal: [],
                arrayHorario : [],
                arrayProfesor : [],
                arrayRutina : [],

                fecha_ini : '',
                fecha_fin : '',
                idlocal : 0, 
                idhorario : 0,
                idprofesor : 0,
                idrutina : 0,
                

                listado:1,                

                modal : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorCalendario : 0,
                errorMostrarMsjCalendario : [], 
                e_fecha_ini : false,
                e_fecha_fin : false,
                e_idlocal : false,  
                e_idhorario : false,
                e_idprofesor : false,
                e_idrutina : false,

                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'idlocal',
                buscar : '',
                cbPdf : 0,
                paginado : 10,
                ordenado : 'id',
                ascdesc : 'desc'
            }
        },
        components: {
            vSelect
        },
        computed:{
            isActived: function(){
                return this.pagination.current_page;
            },
            //Calcula los elementos de la paginación
            pagesNumber: function() {
                if(!this.pagination.to) {
                    return [];
                }
                
                var from = this.pagination.current_page - this.offset; 
                if(from < 1) {
                    from = 1;
                }

                var to = from + (this.offset * 2); 
                if(to >= this.pagination.last_page){
                    to = this.pagination.last_page;
                }  

                var pagesArray = [];
                while(from <= to) {
                    pagesArray.push(from);
                    from++;
                }
                return pagesArray;             

            },
            crearPeriodo: function(){
                let me=this;
                var fecha_inicial=strtotime("25-02-2008");
                var fecha_fin=strtotime("01-04-2008");
                var periodo = [];

                for(var i=fecha_inicial;i<fecha_fin;i+=86400){
                    periodo.push(i)
                }
                return periodo;
            }
        },
        methods : {
            hoyFecha(){
                var hoy = new Date();
                var dd = hoy.getDate();
                var mm = hoy.getMonth()+1;
                var yyyy = hoy.getFullYear();

                if(dd < 10) dd = '0'+dd;
                if(mm < 10) mm = '0'+mm;
        
                return dd+'/'+mm+'/'+yyyy;      
            },                        
            listarCalendario (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/calendario?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCalendario = respuesta.calendarios.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
                me.ordenado=ordenado;
                me.ascdesc=ascdesc;
            },   
            cambiarPagina(page,buscar,criterio,paginado,ordenado,ascdesc){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarCalendario(page,buscar,criterio,paginado,ordenado,ascdesc);
            },
            selectLocal(){
                let me=this;
                
                var url= '/local/selectLocal';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayLocal = respuesta.locales;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectHorario(){
                let me=this;
                var url= '/horario/selectHorario?idlocal='+me.idlocal;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayHorario = respuesta.horarios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectProfesor(){
                let me=this;
                var url= '/profesor/selectProfesor';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayProfesor = respuesta.profesores;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectRutina(){
                let me=this;
                var url= '/rutina/selectRutina';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayRutina = respuesta.rutinas;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },           
            
            registrarCalendario(){
                if (this.validarCalendario()){
                    return;
                }
                
                let me = this;

                axios.post('/calendario/registrar',{
                    'fecha_ini': this.fecha_ini,
                    'fecha_fin' : this.fecha_fin,
                    'idlocal' : this.idlocal,
                    'data': this.arrayDetalle

                }).then(function (response) {
                    me.listado=1;
                    me.listarCalendario(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc); 
                    me.fecha_ini='';
                    me.fecha_fin='';
                    me.idlocal=0;
                    me.arrayDetalle=[];                   

                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarCalendario(){
                 this.errorCalendario=0;
                this.errorMostrarMsjCalendario =[];

                if (!this.fecha_ini) {this.e_fecha_ini = true; this.errorMostrarMsjCalendario.push('fecha_ini');}else{this.e_fecha_ini = false}
                if (!this.fecha_fin) {this.e_fecha_fin = true; this.errorMostrarMsjCalendario.push('fecha_fin');}else{this.e_fecha_fin = false}
                if (!this.idlocal) {this.e_idlocal = true; this.errorMostrarMsjCalendario.push('idlocal');}else{this.e_idlocal = false}

                if (this.errorMostrarMsjCalendario.length) this.errorCalendario = 1;
                return this.errorCalendario;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;

                me.selectLocal();
                me.selectProfesor();
                me.selectHorario();
                me.selectRutina();

                this.e_fecha_ini = false;
                this.e_fecha_fin = false;
                this.e_idlocal = false;

                me.fecha_ini='';
                me.fecha_fin='';
                me.idlocal=0;   
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=1;
            },
            verCalendario(id){
                let me=this;
                me.listado=2;
                
                //Obtener los datos del calendario
                var arrayCalendarioT=[];
                var url= '/calendario/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayCalendarioT = respuesta.calendario;

                    me.id = arrayCalendarioT[0]['id'];
                    me.dia = arrayCalendarioT[0]['dia'];
                    me.e_idhorario = arrayCalendarioT[0]['e_idhorario'];
                    me.e_idprofesor = arrayCalendarioT[0]['e_idprofesor'];
                    me.e_idrutina = arrayCalendarioT[0]['e_idrutina'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= '/calendario/obtenerDetalles?id=' + id;
                
                axios.get(urld).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });               
            },            
            desactivarCalendario(id){
               Swal.fire({
                title: 'Anular el calendario?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, anular'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/calendario/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarCalendario(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc);
                        Swal.fire(
                        'Desactivado!',
                        'El registro ha sido anulado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } 
                }) 
            },
            ceroBusqueda(){
                this.buscar='';
                this.criterio='fecha_hora'
                this.listarCalendario(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
            }
        },
        mounted() {
            this.listarCalendario(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>