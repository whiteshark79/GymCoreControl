<template>
 
    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Locales</h3></div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary btn-sm" @click="abrirModal('local','registrar')"><i class="fas fa-plus-circle">  Nuevo Local</i></button>
                            </div>
                        </div>                      

                        <div class="card-body">
                            <div class="form-group row justify-content-between">
                                <div class="input-group input-group-sm col-7">                                
                                    <select class="form-control col-2 " v-model="criterio" @change="ceroBusqueda();">
                                    <option value="nombre">Nombre</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarLocal(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control col-4" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarLocal(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>                                 
                                    <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="fas fa-redo"></i> </button>
                                </div>
                                <div class="col-4"></div>
                                <div class="input-group input-group-sm col-1">                                     
                                    <select class="form-control" v-model="paginado" @change="listarLocal(1,buscar,criterio,paginado,ordenado,ascdesc)">
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
                                                    <a href="#" @click="listarLocal(1,buscar,criterio,paginado,'id','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'id' && ascdesc === 'desc') || (ordenado === 'id' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarLocal(1,buscar,criterio,paginado,'id','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="20%">EMPRESA
                                                <template v-if="(ordenado !== 'idempresa' && ascdesc === 'asc') || (ordenado === 'idempresa' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarLocal(1,buscar,criterio,paginado,'idempresa','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'idempresa' && ascdesc === 'desc') || (ordenado === 'idempresa' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarLocal(1,buscar,criterio,paginado,'idempresa','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>                                            
                                            <th width="20%">NOMBRE
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'asc') || (ordenado === 'nombre' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarLocal(1,buscar,criterio,paginado,'nombre','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'desc') || (ordenado === 'nombre' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarLocal(1,buscar,criterio,paginado,'nombre','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="35%">DIRECCION</th>
                                            <th width="10%">ESTADO
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'asc') || (ordenado === 'condicion' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarLocal(1,buscar,criterio,paginado,'condicion','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'desc') || (ordenado === 'condicion' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarLocal(1,buscar,criterio,paginado,'condicion','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="10%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayLocal.length">
                                        <tr v-for="local in arrayLocal" :key="local.id">
                                            <td v-text="local.id" align="center"></td>
                                            <td v-text="local.empresa"></td>
                                            <td v-text="local.nombre"></td>
                                            <td v-text="local.direccion"></td>                                            
                                            <td align="center">
                                                <div v-if="local.condicion"><span class="badge badge-success">Activo</span></div>
                                                <div v-else><span class="badge badge-secondary">Inactivo</span></div>                                    
                                            </td>
                                            <td align="center">
                                                <a class="btn btn-sm btn-default" @click="abrirModal('local','actualizar',local)"><i class="fas fa-edit" title="Editar"></i></a>                                   
                                                <template v-if="local.condicion">
                                                    <a class="btn btn-sm btn-default" @click="desactivarLocal(local.id)"><i class="fas fa-ban" title="Desactivar"></i></a>
                                                </template>
                                                <template v-else>
                                                    <a class="btn btn-sm btn-default" @click="activarLocal(local.id)"><i class="fas fa-sync" title="Actualizar"></i></a>
                                                </template>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="6" class="text-center">
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
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                        <select class="form-control" v-bind:class="{ 'is-invalid': e_idempresa }" v-model="idempresa">
                                            <option value="0" disabled>--Empresa--</option>
                                            <option v-for="empresa in arrayEmpresa" :key="empresa.id" :value="empresa.id" v-text="empresa.nombre"></option>
                                        </select> 
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>
                                        <input type="text" maxlength="60" v-model="nombre" class="form-control" v-bind:class="{ 'is-invalid': e_nombre }" placeholder="Nombre local">
                                    </div>                                        
                                </div>                                
                                                                                                              
                            </div>                                                            
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-phone"></i></span>
                                        <input type="number" v-model="telefono" class="form-control" placeholder="Telefono">                                                            
                                    </div>
                                </div>
                                <div class="form-group col-md-7">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-map-marked-alt"></i></span>
                                        <input type="text" maxlength="60" v-model="direccion" class="form-control" placeholder="Direccion">                                                            
                                    </div>
                                </div>
                            </div> 
                            <div class="form-row">                                
                                <div class="input-group input-group-sm mb-3 col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Descripción: </span>
                                    </div>
                                    <textarea  v-model="descripcion" class="form-control" rows="2" maxlength="100"></textarea>                                    
                                </div>                                        
                                                               
                            </div>   
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-info btn-sm" @click="registrarLocal()">Guardar</button>                        
                        <button type="button" v-if="tipoAccion==2" class="btn btn-success btn-sm" @click="actualizarLocal()">Actualizar</button>    
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
    export default {
        data (){
            return {
                local_id: '',
                idempresa : 0,
                nombre : '',
                descripcion : '',
                telefono : '',
                direccion : '',

                arrayLocal : [],
                arrayEmpresa : [],

                modal : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorLocal : 0,
                errorMostrarMsjLocal : [],
                e_idempresa : false,
                e_nombre : false,
                e_direccion : false,

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
            listarLocal (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/local?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayLocal = respuesta.locales.data;
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
                me.listarLocal(page,buscar,criterio,paginado,ordenado,ascdesc);
            },
            selectEmpresa(){
                let me=this;
                var url= '/empresa/selectEmpresa';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayEmpresa = respuesta.empresas;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarLocal(){
               if (this.validarLocal()){ return; }
                let me = this;

                axios.post('/local/registrar',{
                    'idempresa': this.idempresa,
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'telefono': this.telefono,
                    'direccion': this.direccion
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarLocal(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarLocal(){
               if (this.validarLocal()){ return; }
                let me = this;

                axios.put('/local/actualizar',{
                    'idempresa': this.idempresa,
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'telefono': this.telefono,
                    'direccion': this.direccion,
                    'id': this.local_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarLocal(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },            
            desactivarLocal(id){
               Swal.fire({
                title: 'Desactivar el local?',
                text: "Puede activarla nuevamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, desactivarla'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/local/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarLocal(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
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
            activarLocal(id){
               Swal.fire({
                title: 'Activar el local?',
                text: "Puede desactivarla nuevamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, activarla'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/local/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarLocal(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
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
            validarLocal(){
                this.errorLocal=0;
                this.errorMostrarMsjLocal =[];

                if (!this.idempresa) {this.e_idempresa = true; this.errorMostrarMsjLocal.push('idempresa');}else{this.e_idempresa = false}
                if (!this.nombre) {this.e_nombre = true; this.errorMostrarMsjLocal.push('nombre');}else{this.e_nombre = false}
                if (!this.direccion) {this.e_direccion = true; this.errorMostrarMsjLocal.push('direccion');}else{this.e_direccion = false}

                if (this.errorMostrarMsjLocal.length) this.errorLocal = 1;

                return this.errorLocal;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';

                this.errorLocal=0;
                this.errorMostrarMsjLocal = [];

                this.e_idempresa = false;
                this.e_nombre = false;
                this.e_direccion = false;
                
                this.idempresa = '';
                this.nombre = '';
                this.descripcion = '';
                this.telefono = '';
                this.direccion = '';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "local":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Local';
                                this.tipoAccion = 1;

                                this.idempresa = 0;
                                this.nombre = '';
                                this.descripcion = '';
                                this.telefono = '';
                                this.direccion = '';
                                
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Local';
                                this.tipoAccion=2;

                                this.local_id=data['id'];
                                this.idempresa = data['idempresa'];
                                this.nombre = data['nombre'];
                                this.descripcion = data['descripcion'];
                                this.telefono = data['telefono'];
                                this.direccion = data['direccion'];
                                
                                break;
                            }                            
                        }
                    }
                }
                this.selectEmpresa();
            },
            ceroBusqueda(){
                this.buscar='';
                this.criterio='nombre';
                this.listarLocal(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
            }
        },
        mounted() {
            this.listarLocal(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>