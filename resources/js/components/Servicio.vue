<template>
  
    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Servicios</h3></div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary" @click="abrirModal('servicio','registrar')"><i class="icon-plus">  Nuevo Servicio</i></button>
                                <button type="button" class="btn btn-sm btn-info" @click="cargarPdf()"><i class="fas fa-file-pdf"> Reporte</i></button>  
                            </div>
                        </div>                    

                        <div class="card-body">
                            <div class="form-group row justify-content-between">
                                <div class="row col-sm-12 col-md-12">
                                    <div class="input-group input-group-sm col-sm-11 col-md-11">                                
                                        <select class="form-control col-sm-3 col-md-2" v-model="criterio" @change="ceroBusqueda();">
                                            <option value="codigo">Código</option>
                                            <option value="nombre">Nombre</option>
                                            <option value="descripcion">Descripción</option>
                                            <option value="idclasificacion">Clasificacion</option>
                                        </select>
                                        <template v-if="criterio=='idclasificacion'">
                                            <div class="col-sm-3 col-md-3">                                                        
                                                <v-select
                                                    id="buscar"
                                                    @search="selectClasificacionB"
                                                    label="nombre"
                                                    :options="arrayClasificacionB"
                                                    placeholder="Buscar Clasificaciones..."
                                                    @input="getDatosClasificacionB"                                    
                                                ></v-select>
                                                </div>
                                        </template>
                                        <template v-else>
                                            <input type="text" v-model="buscar" @keyup.enter="listarServicio(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control col-sm-3 col-md-3" placeholder="Texto a buscar">
                                        </template>                                    
                                        <button type="submit" @click="listarServicio(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="icon-magnifier"></i> Buscar</button>                                 
                                        <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="icon-reload"></i> </button>
                                    </div>
                                    <div class="input-group input-group-sm col-sm-1 col-md-1">                                     
                                        <select class="form-control" v-model="paginado" @change="listarServicio(1,buscar,criterio,paginado,ordenado,ascdesc)">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                </div>
                            </div>  
                            <div class="table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar">
                                <table class="table table-bordered table-sm table-hover" id="dtTable">
                                    <thead  class="thead-table"> 
                                        <tr align="center">
                                            <th scope="col" width="6%">CÓD
                                                <template v-if="(ordenado !== 'codigo' && ascdesc === 'asc') || (ordenado === 'codigo' && ascdesc === 'desc') ">
                                                    <a href="#" @click="listarServicio(1,buscar,criterio,paginado,'codigo','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'codigo' && ascdesc === 'desc') || (ordenado === 'codigo' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarServicio(1,buscar,criterio,paginado,'codigo','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="20%">NOMBRE
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'asc') || (ordenado === 'nombre' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarServicio(1,buscar,criterio,paginado,'nombre','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'desc') || (ordenado === 'nombre' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarServicio(1,buscar,criterio,paginado,'nombre','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col">DESCRIPCIÓN</th>
                                            <th scope="col" width="15%">CLASIFICACIÓN
                                                <template v-if="(ordenado !== 'idclasificacion' && ascdesc === 'asc') || (ordenado === 'idclasificacion' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarServicio(1,buscar,criterio,paginado,'idclasificacion','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'idclasificacion' && ascdesc === 'desc') || (ordenado === 'idclasificacion' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarServicio(1,buscar,criterio,paginado,'idclasificacion','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>                                            
                                            <th scope="col" width="10%">ESTADO
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'asc') || (ordenado === 'condicion' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarServicio(1,buscar,criterio,paginado,'condicion','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'desc') || (ordenado === 'condicion' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarServicio(1,buscar,criterio,paginado,'condicion','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="10%">ACCIONES</th>
                                        </tr> 
                                    </thead>
                                    <tbody v-if="arrayServicio.length">
                                        <tr v-for="servicio in arrayServicio" :key="servicio.id">
                                            <td v-text="servicio.codigo" scope="row" data-label="COD"></td>
                                            <td v-text="servicio.nombre" data-label="NOMBRE"></td>
                                            <td v-text="servicio.descripcion" data-label="DESCRIPCIÓN"></td>
                                            <td v-text="servicio.nombre_clasificacion" align="center" data-label="CLASIFICACIÓN"></td> 
                                            <td align="center" data-label="ESTADO">
                                                <div v-if="servicio.condicion"><span class="badge badge-success">Activo</span></div>
                                                <div v-else><span class="badge badge-secondary">Inactivo</span></div>                                    
                                            </td>
                                            <td align="center" data-label="ACCIONES">                                   
                                                <template v-if="servicio.condicion">
                                                    <a class="btn btn-sm btn-default" @click="abrirModal('servicio','actualizar',servicio)"><i class="icon-note" title="Editar"></i></a>
                                                    <a class="btn btn-sm btn-default" @click="desactivarServicio(servicio.id)"><i class="icon-ban" title="Desactivar"></i></a>
                                                </template>
                                                <template v-else>
                                                    <a class="btn btn-sm btn-default" @click="activarServicio(servicio.id)"><i class="icon-check" title="Actualizar"></i></a>
                                                </template>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="8" class="text-center">
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
            <div class="modal-dialog modal-primary modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-text="tituloModal"></h5>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-3 col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Clas.: </span>
                                    </div>
                                    <select class="form-control" v-bind:class="{ 'is-invalid': e_idclasificacion }" v-model="idclasificacion">
                                        <option value="0" disabled>--Seleccione--</option>
                                        <option v-for="clasificacion in arrayClasificacion" :key="clasificacion.id" :value="clasificacion.id" v-text="clasificacion.nombre"></option>
                                    </select>
                                </div>
                                <div class="input-group input-group-sm mb-3 col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Cód.: </span>
                                    </div>
                                    <input type="text" v-model="codigo" class="form-control" v-bind:class="{ 'is-invalid': e_codigo }"> 
                                </div>                                
                            </div>
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-3 col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Nombre: </span>
                                    </div>
                                    <input type="text" v-model="nombre" maxlength="35" class="form-control" v-bind:class="{ 'is-invalid': e_nombre }"> 
                                </div>
                            </div>                             
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-3 col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Descripción: </span>
                                    </div>                                    
                                    <textarea  v-model="descripcion" class="form-control" v-bind:class="{ 'is-invalid': e_descripcion }" rows="2" maxlength="60"></textarea>
                                </div>
                                                          
                            </div>                                                
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-info btn-sm" @click="registrarServicio()">Guardar</button>                        
                        <button type="button" v-if="tipoAccion==2" class="btn btn-success btn-sm" @click="actualizarServicio()">Actualizar</button>

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
                servicio_id: 0,
                idclasificacion : 0,
                nombre_clasificacion : '',
                codigo : '',
                nombre : '',                
                descripcion : '',
                arrayServicio : [],
                arrayClasificacion :[],
                arrayClasificacionB :[],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorServicio : 0,
                errorMostrarMsjServicio : [],
                e_idclasificacion : false,
                e_codigo : false,
                e_nombre : false,
                e_descripcion : false,

                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'nombre',
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
            listarServicio (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/servicio?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayServicio = respuesta.servicios.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
                me.ordenado=ordenado;
                me.ascdesc=ascdesc;
            },
            selectClasificacionB(search,loading){
                let me=this;
                loading(true)

                var url= '/clasificacion/selectClasificacionB?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayClasificacionB=respuesta.clasificaciones;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosClasificacionB(val1){
                let me = this;
                me.loading = true;
                me.buscar = val1.id;
            },            
            selectClasificacion(){
                let me=this;
                var url= '/clasificacion/selectClasificacion';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayClasificacion = respuesta.clasificaciones;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },            
            cambiarPagina(page,buscar,criterio,paginado,ordenado,ascdesc){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarServicio(page,buscar,criterio,paginado,ordenado,ascdesc);
            },            
            registrarServicio(){
               if (this.validarServicio()){ return; }
                let me = this;

                axios.post('/servicio/registrar',{
                    'idclasificacion': this.idclasificacion,
                    'codigo': this.codigo,
                    'nombre': this.nombre,                    
                    'descripcion': this.descripcion
                }).then(function (response) {
                    me.cerrarModal();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: '<h5>Registro creado</h5>',
                        width: 250,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    me.listarServicio(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarServicio(){
               if (this.validarServicio()){ return; }
                let me = this;

                axios.put('/servicio/actualizar',{
                    'idclasificacion': this.idclasificacion,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'id': this.servicio_id
                }).then(function (response) {
                    me.cerrarModal();
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: '<h5>Registro actualizado</h5>',
                        width: 250,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    me.listarServicio(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },            
            desactivarServicio(id){
               Swal.fire({
                title: 'Desactivar el artículo?',
                text: "Puede activarla nuevamente.",
                icon: 'warning',
                width: 450,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, desactivarlo'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/servicio/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarServicio(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
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
            activarServicio(id){
               Swal.fire({
                title: 'Activar la artículo?',
                text: "Puede desactivarla nuevamente.",
                icon: 'warning',
                width: 450,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, activarlo'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/servicio/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarServicio(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                        Swal.fire(
                        'Activado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } 
                }) 
            },
            validarServicio(){
                this.errorServicio=0;
                this.errorMostrarMsjServicio =[];

                if (this.idclasificacion == 0) {this.e_idclasificacion = true; this.errorMostrarMsjServicio.push('idclasificacion');}else{this.e_idclasificacion = false}
                if (!this.codigo) {this.e_codigo = true; this.errorMostrarMsjServicio.push('codigo');}else{this.e_codigo = false}
                if (!this.nombre) {this.e_nombre = true; this.errorMostrarMsjServicio.push('nombre');}else{this.e_nombre = false}
                if (!this.descripcion) {this.e_descripcion = true; this.errorMostrarMsjServicio.push('descripcion');}else{this.e_descripcion = false}

                if (this.errorMostrarMsjServicio.length) this.errorServicio = 1;
                return this.errorServicio;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';

                this.errorServicio=0;
                this.errorMostrarMsjServicio = [];
                this.e_idclasificacion = false;
                this.e_codigo = false;
                this.e_nombre = false;
                this.e_descripcion = false;
                
                this.idclasificacion= 0;
                this.nombre_clasificacion = '';
                this.codigo = '';
                this.nombre = '';
                this.descripcion = '';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "servicio":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Servicio';
                                this.idclasificacion=0;
                                this.nombre_clasificacion='';
                                this.codigo='';
                                this.nombre= '';
                                this.descripcion = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Servicio';
                                this.tipoAccion=2;
                                this.servicio_id=data['id'];
                                this.idclasificacion=data['idclasificacion'];
                                this.codigo=data['codigo'];
                                this.nombre = data['nombre'];
                                this.descripcion= data['descripcion'];
                                break;
                            }                            
                        }
                    }
                }
                this.selectClasificacion();
            },
            ceroBusqueda(){
                this.buscar='';
                this.listarServicio(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
            }
        },
        mounted() {
            this.listarServicio(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>