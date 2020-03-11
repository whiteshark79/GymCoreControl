<template>
 
    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Inscripciones</h3></div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary btn-sm" @click="abrirModal('inscripcion','registrar')"><i class="fas fa-plus-circle">  Nueva Inscripción</i></button>
                            </div>
                        </div>                      

                        <div class="card-body">
                            <div class="form-group row justify-content-between">
                                <div class="input-group input-group-sm col-7">                                
                                    <select class="form-control col-2 " v-model="criterio" @change="ceroBusqueda();">
                                        <option value="idalumno">Alumno</option>
                                        <option value="fecha_ini">Fecha</option>
                                        <option value="idmodalidad">Modalidad</option>                                      
                                    </select>
                                    <template v-if="criterio=='idalumno'">
                                        <div class="col-md-4">                                                         
                                            <v-select
                                                id="buscar"
                                                @search="selectAlumno"
                                                label="nombre"
                                                :options="arrayAlumno"
                                                placeholder="Buscar Alumnos..."
                                                @input="getDatosAlumnos2"                                    
                                            ></v-select>
                                        </div>
                                    </template>
                                    <template v-else-if="criterio=='fecha_ini'">
                                        <input type="date" v-model="buscar" class="form-control col-4">
                                    </template>
                                    <template v-else-if="criterio=='idmodalidad'">
                                        <select class="form-control col-4" v-model="buscar">
                                            <option value="0" disabled>--Seleccione--</option>
                                            <option v-for="modalidad in arrayModalidad" :key="modalidad.id" :value="modalidad.id" v-text="modalidad.nombre"></option>
                                        </select>
                                    </template>                                                                          
                                    <button type="submit" @click="listarInscripcion(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>
                                    <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="fas fa-redo"></i> </button>                                 
                                </div>
                                <div class="col-4"></div>
                                <div class="input-group input-group-sm col-1">                                     
                                    <select class="form-control" v-model="paginado" @change="listarInscripcion(1,buscar,criterio,paginado,ordenado,ascdesc)">
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
                                            <th width="3%">#</th> 
                                            <th width="10%">FECHA
                                                <template v-if="(ordenado !== 'fecha_ini' && ascdesc === 'asc') || (ordenado === 'fecha_ini' && ascdesc === 'desc') ">
                                                    <a href="#" @click="listarInscripcion(1,buscar,criterio,paginado,'fecha_ini','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'fecha_ini' && ascdesc === 'desc') || (ordenado === 'fecha_ini' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarInscripcion(1,buscar,criterio,paginado,'fecha_ini','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="27%">ALUMNO
                                                <template v-if="(ordenado !== 'idalumno' && ascdesc === 'asc') || (ordenado === 'idalumno' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarInscripcion(1,buscar,criterio,paginado,'idalumno','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'idalumno' && ascdesc === 'desc') || (ordenado === 'idalumno' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarInscripcion(1,buscar,criterio,paginado,'idalumno','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>                                                
                                            <th width="10%">MODALIDAD
                                                <template v-if="(ordenado !== 'idmodalidad' && ascdesc === 'asc') || (ordenado === 'idmodalidad' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarInscripcion(1,buscar,criterio,paginado,'idmodalidad','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'idmodalidad' && ascdesc === 'desc') || (ordenado === 'idmodalidad' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarInscripcion(1,buscar,criterio,paginado,'idmodalidad','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>                                          
                                            <th width="8%">ABONO
                                                <template v-if="(ordenado !== 'abono' && ascdesc === 'asc') || (ordenado === 'abono' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarInscripcion(1,buscar,criterio,paginado,'abono','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'abono' && ascdesc === 'desc') || (ordenado === 'abono' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarInscripcion(1,buscar,criterio,paginado,'abono','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="8%">SALDO
                                                <template v-if="(ordenado !== 'saldo' && ascdesc === 'asc') || (ordenado === 'saldo' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarInscripcion(1,buscar,criterio,paginado,'saldo','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'saldo' && ascdesc === 'desc') || (ordenado === 'saldo' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarInscripcion(1,buscar,criterio,paginado,'saldo','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>     
                                            <th width="5%">IVA</th>                                         
                                            <th width="8%">TOTAL</th>                                                                                        
                                            <th width="9%">ESTADO
                                                <template v-if="(ordenado !== 'estado' && ascdesc === 'asc') || (ordenado === 'estado' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarInscripcion(1,buscar,criterio,paginado,'estado','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'estado' && ascdesc === 'desc') || (ordenado === 'estado' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarInscripcion(1,buscar,criterio,paginado,'estado','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>                                                                                    
                                            <th width="10%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayInscripcion.length">
                                        <tr v-for="inscripcion in arrayInscripcion" :key="inscripcion.id">
                                            <td v-text="inscripcion.id"></td>
                                            <td>{{ inscripcion.fecha_ini }}</td>
                                            <td>{{inscripcion.nombre}}</td>
                                            <td v-text="inscripcion.modalidad_nombre"></td>                                     
                                            <td v-text="inscripcion.abono"></td>
                                            <td v-text="inscripcion.saldo"></td>
                                            <td v-text="inscripcion.impuesto"></td>
                                            <td align="right">$ {{ inscripcion.total  }}</td>
                                            <td align="center"> 
                                                <div v-if="inscripcion.estado=='Cancelado'"><span class="badge badge-success">{{ inscripcion.estado }}</span></div>
                                                <div v-if="inscripcion.estado=='Debe'"><span class="badge badge-warning">{{ inscripcion.estado }}</span></div>
                                                <div v-if="inscripcion.estado=='Anulado'"><span class="badge badge-danger">{{ inscripcion.estado }}</span></div>                                    
                                            </td>
                                            <td align="center">                   
                                                <template v-if="inscripcion.estado=='Cancelado' || inscripcion.estado=='Debe'">
                                                    <a class="btn btn-sm btn-default" @click="abrirModal('inscripcion','actualizar',inscripcion)"><i class="fas fa-edit" title="Editar"></i></a>
                                                    <a class="btn btn-sm btn-default" @click="desactivarInscripcion(inscripcion.id)"><i class="fas fa-ban" title="Desactivar"></i></a>                                                     
                                                </template>
                                                <template v-else>
                                                    <a class="btn btn-sm btn-default" @click="activarInscripcion(inscripcion.id)"><i class="fas fa-sync" title="Actualizar"></i></a>
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
                    </div>
                </div>
            </div>
        </div>
    <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">                           
                            <template v-if="tipoAccion==2">
                                <div class="row">
                                    <div class="input-group input-group-sm mb-3 col-md-7">
                                        <div class="input-group-prepend">
                                            <span class="input-group-text">Fecha Inicio: </span>
                                        </div>
                                        <input type="date" class="form-control form-control-sm" v-model="fecha_ini" >
                                    </div>                                
                                </div>
                            </template>
                            
                            <div class="row">
                                <div class="input-group input-group-sm mb-3 col-md-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Alumno: </span>
                                    </div>
                                    <template v-if="this.tipoAccion == 2">
                                        <input class="form-control" v-model="nombre" readonly>
                                    </template>
                                    <template v-else>
                                        <v-select
                                            class="num-col"
                                            @search="selectAlumno"
                                            label="nombre"
                                            :options="arrayAlumno"
                                            placeholder="Buscar Alumnos..."
                                            @input="getDatosAlumno"                                    
                                        ></v-select>
                                        <span class="text-error" v-show="e_idalumno">Eligir alumno</span>
                                    </template>                                    
                                </div>
                                                               
                            </div>
                            <div class="row">
                                <div class="input-group input-group-sm mb-3 col-md-8">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Tipo: </span>
                                    </div>
                                    <select class="form-control col-6" v-bind:class="{ 'is-invalid': e_idmodalidad }" v-model="idmodalidad" @change="getDatosModalidad">
                                        <option value="0" disabled>--Seleccione--</option>
                                        <option v-for="modalidad in arrayModalidad" :key="modalidad.id" :value="modalidad.id" v-text="modalidad.nombre" 
                                                :data-precio="modalidad.precio" 
                                                :data-duracion="modalidad.duracion"
                                                :data-clases="modalidad.clases"></option>
                                    </select>
                                     <input type="hidden" v-model="duracion">
                                     <input type="hidden" v-model="clases"> 
                                     <input type="hidden" v-model="subtotal">  
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="fas fa-dollar-sign"></i></span>
                                    </div>                                    
                                    <input type="number" class="form-control col-3" v-model="total" readonly>
                                    
                                </div>
                                <div class="input-group input-group-sm mb-3 col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text"><i class="far fa-clock"></i></span>
                                    </div>
                                    <select class="form-control" v-bind:class="{ 'is-invalid': e_idhorario }" v-model="idhorario">
                                        <option value="0" disabled>--Seleccione--</option>
                                        <option v-for="horario in arrayHorario" :key="horario.id" :value="horario.id" v-text="horario.hora_ini+' '+horario.hora_fin"></option>
                                    </select>
                                </div> 
                            </div>
                            <div class="row">                                
                                <div class="input-group input-group-sm mb-3 col-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">IVA: </span>
                                    </div>
                                    <select v-model="iva" class="form-control" @change="calcularTotal">                                        
                                        <option value="S">Si</option>
                                        <option value="N">No</option>                                       
                                    </select>
                                    <input type="hidden" v-model="impuesto">                               
                                </div>
                                <div class="input-group input-group-sm mb-3 col-md-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Abono: </span>
                                    </div>
                                    <input type="number" class="form-control" v-bind:class="{ 'is-invalid': e_abono }" v-model="abono" min="0" :max="total" @change="calcularSaldo">
                                </div>
                                <div class="input-group input-group-sm mb-3 col-md-4">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Saldo: </span>
                                    </div>
                                    <input class="form-control" v-model="saldo" value= "1" readonly>
                                </div>                              
                                                                                       
                            </div>
                            <div class="row">
                                <div class="input-group input-group-sm mb-3 col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Observaciones: </span>
                                    </div>
                                    <textarea  v-model="observaciones" class="form-control form-control" rows="2" maxlength="60"></textarea>
                                </div>                                                             
                                                               
                            </div> 
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-info btn-sm" @click="registrarInscripcion()">Guardar</button>                        
                        <button type="button" v-if="tipoAccion==2" class="btn btn-success btn-sm" @click="actualizarInscripcion()">Actualizar</button>

                    </div>
                </div>
                <!-- /.modal-content -->
            </div>
            <!-- /.modal-dialog -->
        </div>
    <!--Fin del modal-->
    </main>
</template>

<script>
    import 'vue-select/dist/vue-select.css';
    import vSelect from 'vue-select';
    export default {
        data (){
            return {
                inscripcion_id: 0,
                fecha_ini : '',
                idalumno : 0,
                idmodalidad : 0,
                idhorario : 0,
                duracion : 0,  
                clases : 0,                           
                abono : 0,
                saldo : 0,
                iva : 'N',
                impuesto : 0.0,
                subtotal : 0.0,
                total : 0.0,
                observaciones : '',
                idhorario : 0,         

                arrayInscripcion : [],
                arrayAlumno : [],
                arrayModalidad : [],
                arrayHorario : [],

                modal : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorInscripcion : 0,
                errorMostrarMsjInscripcion : [],
                e_idalumno : false,
                e_idmodalidad : false,
                e_abono : false,
                e_idhorario : false,      

                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'idalumno',
                buscar : '',
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
            listarInscripcion (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/inscripcion?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayInscripcion = respuesta.inscripciones.data;
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
                me.listarInscripcion(page,buscar,criterio,paginado,ordenado,ascdesc);
            },
            selectAlumno(search,loading){
                let me=this;
                loading(true)

                var url= '/alumno/selectAlumno?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayAlumno=respuesta.alumnos;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosAlumno(val1){
                let me = this;
                me.loading = true;
                me.idalumno = val1.id;
            },
            getDatosAlumnos2(val2){
                let me = this;
                me.loading = true;
                me.buscar = val2.id;
            },            
            selectModalidad(){
                let me=this;
                var url= '/modalidad/selectModalidad';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayModalidad = respuesta.modalidades;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosModalidad(e) { 
                let me = this;
                if(e.target.options.selectedIndex > -1) 
                {
                    me.total = (e.target.options[e.target.options.selectedIndex].dataset.precio);
                    me.duracion = (e.target.options[e.target.options.selectedIndex].dataset.duracion);
                    me.clases = (e.target.options[e.target.options.selectedIndex].dataset.clases);
                    me.abono = this.total;
                    me.subtotal = this.total;
                    me.saldo = 0;                    
                    me.impuesto = 0;
                    me.iva = 'N';
                } 
            },
            selectHorario(){
                let me=this;
                var url= '/horario/selectHorario';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayHorario = respuesta.horarios;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            calcularSaldo(){
                let me = this;
                me.saldo = (this.total-this.abono).toFixed(2);
            },
            calcularTotal(e){
                let me = this;
                
                if(e.target.options[e.target.options.selectedIndex].value == 'S') { 
                    me.total = (this.subtotal*1.12).toFixed(2);
                    me.impuesto = ((this.subtotal*1.12)-this.subtotal).toFixed(2);
                }else{
                    me.total = (this.subtotal-this.impuesto).toFixed(2);
                    me.impuesto = 0;
                }                         

                me.subtotal = this.total;
                me.abono = this.total;
                me.saldo = 0;                 
            },
            registrarInscripcion(){
                if (this.validarInscripcion()){ return; }            
                let me = this;
 
                axios.post('/inscripcion/registrar',{
                    'idalumno': this.idalumno,                    
                    'idmodalidad': this.idmodalidad,
                    'idhorario': this.idhorario,
                    'duracion': this.duracion,
                    'clases': this.clases,
                    'abono': this.abono,
                    'saldo': this.saldo,
                    'impuesto': this.impuesto,
                    'total': this.total,
                    'observaciones': this.observaciones
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarInscripcion(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarInscripcion(){
                if (this.validarInscripcion()){ return; }              
                let me = this;

                axios.put('/inscripcion/actualizar',{
                    'fecha_ini': this.fecha_ini,
                    'idalumno': this.idalumno,                    
                    'idmodalidad': this.idmodalidad,
                    'idhorario': this.idhorario,
                    'duracion': this.duracion,
                    'clases': this.clases,
                    'abono': this.abono,
                    'saldo': this.saldo,
                    'impuesto': this.impuesto,
                    'total': this.total,
                    'observaciones': this.observaciones,
                    'id': this.inscripcion_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarInscripcion(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },            
            desactivarInscripcion(id){
               Swal.fire({
                title: 'Desactivar la inscripción?',
                text: "Puede activarla nuevamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, desactivarla'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/inscripcion/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarInscripcion(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc);
                        Swal.fire(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } 
                }) 
            },
            activarInscripcion(id){
               Swal.fire({
                title: 'Activar la inscripción?',
                text: "Puede desactivarla nuevamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, activarla'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/inscripcion/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarInscripcion(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc);
                        Swal.fire(
                        'Desactivado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } 
                }) 
            },
            validarInscripcion(){
                this.errorInscripcion=0;
                this.errorMostrarMsjInscripcion =[];

                if (this.idalumno == 0) {this.e_idalumno = true; this.errorMostrarMsjInscripcion.push('ide_idalumno');}else{this.e_idalumno = false}
                if (this.idmodalidad == 0) {this.e_idmodalidad = true; this.errorMostrarMsjInscripcion.push('idme_idmodalidad');}else{this.e_idmodalidad = false}
                if (!this.abono) {this.e_abono = true; this.errorMostrarMsjInscripcion.push('idme_abono');}else{this.e_abono = false}
                if (this.idhorario == 0) {this.e_idhorario = true; this.errorMostrarMsjInscripcion.push('idme_idhorario');}else{this.e_idhorario = false}


                if (this.errorMostrarMsjInscripcion.length) this.errorInscripcion = 1;
                return this.errorInscripcion;
            },          
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                
                this.fecha_ini= '';
                this.idmodalidad= 0;
                this.idhorario= 0;
                this.duracion = 0;
                this.clases = 0;
                this.idhorario= 0;
                this.abono = 0.0;
                this.saldo = 0.0;
                this.iva = 'N';
                this.impuesto = 0.0;
                this.subtotal = 0.0;
                this.total = 0.0;
                this.observaciones = '';

                this.errorInscripcion=0;
            },
            abrirModal(modelo, accion, data = []){
                
                switch(modelo){
                    case "inscripcion":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Inscripción';
                                this.tipoAccion = 1;
                                this.fecha_ini= '';
                                this.idalumno= '';
                                this.idmodalidad= 0;
                                this.idhorario= 0;
                                this.duracion = 0;  
                                this.clases = 0;                              
                                this.abono = 0.0;
                                this.saldo = 0.0;
                                this.iva = 'N';
                                this.impuesto = 0.0;
                                this.subtotal = 0.0;
                                this.total = 0.0;
                                this.observaciones = '';                                
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar inscripción';
                                this.tipoAccion=2;
                                this.inscripcion_id=data['id'];
                                this.fecha_ini = data['fecha_ini'];
                                this.idalumno = data['idalumno'];
                                this.nombre = data['nombre'];
                                this.idmodalidad= data['idmodalidad'];
                                this.idhorario= data['idhorario'];
                                if(this.duracion==0){this.duracion = data['modalidad_duracion'];}else{this.duracion = this.duracion;} 
                                this.clases= data['clases'];                               
                                if(data['impuesto']>0){this.iva = 'S';}else{this.iva = 'N';}                                
                                this.abono= data['abono'];
                                this.saldo= data['saldo'];
                                this.impuesto= data['impuesto'];
                                this.total= data['total'];
                                this.subtotal= data['total'];
                                this.observaciones= data['observaciones'];
                                break;
                            }                            
                        }
                    }
                }
                this.selectHorario();
            },
            ceroBusqueda(){
                this.buscar='';
                this.listarInscripcion(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
            }
        },
        mounted() {
            this.selectModalidad(); 
            this.listarInscripcion(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>