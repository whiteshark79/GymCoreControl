<template>
 
    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Universidades</h3></div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary btn-sm" @click="abrirModal('universidad','registrar')"><i class="fas fa-plus-circle">  Nueva Universidad</i></button>
                            </div>
                        </div>                      

                        <div class="card-body">
                            <div class="form-group row justify-content-between">
                                <div class="row col-sm-12 col-md-12">
                                    <div class="input-group input-group-sm col-sm-11 col-md-11">                                
                                        <select class="form-control col-sm-3 col-md-2" v-model="criterio" @change="ceroBusqueda();">
                                            <option value="universidades">Nombre</option>
                                            <option value="provincias">Provincia</option>
                                            <option value="cantones">Canton</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarUniversidad(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control col-sm-3 col-md-3" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarUniversidad(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>                                 
                                        <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="fas fa-redo"></i> </button>
                                    </div>
                                    <div class="input-group input-group-sm col-sm-1 col-md-1">                                     
                                        <select class="form-control col-sm-6 col-md-12" v-model="paginado" @change="listarUniversidad(1,buscar,criterio,paginado,ordenado,ascdesc)">
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
                                            <th scope="col" width="5%">#
                                                <template v-if="(ordenado !== 'id' && ascdesc === 'asc') || (ordenado === 'id' && ascdesc === 'desc') ">
                                                    <a href="#" @click="listarUniversidad(1,buscar,criterio,paginado,'id','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'id' && ascdesc === 'desc') || (ordenado === 'id' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarUniversidad(1,buscar,criterio,paginado,'id','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="37%">NOMBRE
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'asc') || (ordenado === 'nombre' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarUniversidad(1,buscar,criterio,paginado,'nombre','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'desc') || (ordenado === 'nombre' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarUniversidad(1,buscar,criterio,paginado,'nombre','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="18%">PROVINCIA
                                                <template v-if="(ordenado !== 'idprovincia' && ascdesc === 'asc') || (ordenado === 'idprovincia' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarUniversidad(1,buscar,criterio,paginado,'idprovincia','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'idprovincia' && ascdesc === 'desc') || (ordenado === 'idprovincia' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarUniversidad(1,buscar,criterio,paginado,'idprovincia','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="18%">CANTÓN
                                                <template v-if="(ordenado !== 'idcanton' && ascdesc === 'asc') || (ordenado === 'idcanton' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarUniversidad(1,buscar,criterio,paginado,'idcanton','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'idcanton' && ascdesc === 'desc') || (ordenado === 'idcanton' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarUniversidad(1,buscar,criterio,paginado,'idcanton','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="10%">ESTADO
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'asc') || (ordenado === 'condicion' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarUniversidad(1,buscar,criterio,paginado,'condicion','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'desc') || (ordenado === 'condicion' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarUniversidad(1,buscar,criterio,paginado,'condicion','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="10%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayUniversidad.length">
                                        <tr v-for="universidad in arrayUniversidad" :key="universidad.id">
                                            <td v-text="universidad.id" align="center" scope="row" data-label="#"></td>
                                            <td v-text="universidad.nombre" data-label="NOMBRE"></td>
                                            <td v-text="universidad.nombre_provincia" data-label="PROVINCIA"></td>
                                            <td v-text="universidad.nombre_canton" data-label="CANTÓN"></td>
                                            <td align="center" data-label="ESTADO">
                                                <div v-if="universidad.condicion"><span class="badge badge-success">Activo</span></div>
                                                <div v-else><span class="badge badge-secondary">Inactivo</span></div>                                    
                                            </td>
                                            <td align="center" data-label="ACCIONES">
                                                <a class="btn btn-sm btn-default" @click="abrirModal('universidad','actualizar',universidad)"><i class="fas fa-edit" title="Editar"></i></a>                                   
                                                <template v-if="universidad.condicion">
                                                    <a class="btn btn-sm btn-default" @click="desactivarUniversidad(universidad.id)"><i class="fas fa-ban" title="Desactivar"></i></a>
                                                </template>
                                                <template v-else>
                                                    <a class="btn btn-sm btn-default" @click="activarUniversidad(universidad.id)"><i class="fas fa-sync" title="Actualizar"></i></a>
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
            <div class="modal-dialog modal-primary modal-sm modal-dialog-centered" role="document">
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
                                <div class="input-group input-group-sm mb-3 col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Nombre: </span>
                                    </div>
                                    <input type="text" v-model="nombre" class="form-control" v-bind:class="{ 'is-invalid': e_nombre }">
                                </div>                                
                            </div>
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-3 col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Provincia: </span>
                                    </div>
                                    <select class="form-control" v-bind:class="{ 'is-invalid': e_idprovincia }" v-model="idprovincia">
                                        <option value="0" disabled>--Provincia--</option>
                                        <option v-for="provincia in arrayProvincia" :key="provincia.id" :value="provincia.id" v-text="provincia.nombre"></option>
                                    </select>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-3 col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Canton: </span>
                                    </div>
                                    <select class="form-control" v-bind:class="{ 'is-invalid': e_idcanton }" v-model="idcanton">
                                        <option value="0" disabled>--Canton--</option>
                                        <option v-for="canton in arrayCanton" :key="canton.id" :value="canton.id" v-text="canton.nombre"></option>
                                    </select>
                                </div>                               
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-info btn-sm" @click="registrarUniversidad()">Guardar</button>                        
                        <button type="button" v-if="tipoAccion==2" class="btn btn-success btn-sm" @click="actualizarUniversidad()">Actualizar</button>

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
                universidad_id: 0,
                nombre : '',
                idprovincia : 0,
                idcanton : 0,
                arrayUniversidad : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorUniversidad : 0,
                errorMostrarMsjUniversidad : [],
                e_nombre : false,
                e_idprovincia : false,
                e_idcanton : false,

                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'universidades',
                buscar : '',
                arrayProvincia: [],
                arrayCanton: [],
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
            listarUniversidad (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/universidad?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayUniversidad = respuesta.universidades.data;
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
                me.listarUniversidad(page,buscar,criterio,paginado,ordenado,ascdesc);
            },
            selectProvincia(){
                let me=this;
                var url= '/provincia/selectProvincia';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayProvincia = respuesta.provincias;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectCanton(){
                let me=this;
                var url= '/canton/selectCanton';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCanton = respuesta.cantones;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarUniversidad(){
               if (this.validarUniversidad()){ return; }
                let me = this;

                axios.post('/universidad/registrar',{
                    'nombre': this.nombre,
                    'idprovincia': this.idprovincia,
                    'idcanton': this.idcanton
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
                    me.listarUniversidad(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarUniversidad(){
               if (this.validarUniversidad()){ return; }
                let me = this;

                axios.put('/universidad/actualizar',{
                    'nombre': this.nombre,
                    'idprovincia': this.idprovincia,
                    'idcanton': this.idcanton,
                    'id': this.universidad_id
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
                    me.listarUniversidad(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },            
            desactivarUniversidad(id){
               Swal.fire({
                title: 'Desactivar la Universidad?',
                text: "Puede activarla nuevamente.",
                icon: 'warning',
                width: 450,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, desactivarla'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/universidad/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarUniversidad(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
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
            activarUniversidad(id){
               Swal.fire({
                title: 'Activar la Universidad?',
                text: "Puede desactivarla nuevamente.",
                icon: 'warning',
                width: 450,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, activarla'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/universidad/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarUniversidad(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
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
            validarUniversidad(){
                this.errorUniversidad=0;
                this.errorMostrarMsjUniversidad =[];

                if (!this.nombre) {this.e_nombre = true; this.errorMostrarMsjUniversidad.push('nombre');}else{this.e_nombre = false}
                if (this.idprovincia == 0) {this.e_idprovincia = true; this.errorMostrarMsjUniversidad.push('idprovincia');}else{this.e_idprovincia = false}
                if (this.idcanton == 0) {this.e_idcanton = true; this.errorMostrarMsjUniversidad.push('idcanton');}else{this.e_idcanton = false}

                if (this.errorMostrarMsjUniversidad.length) this.errorUniversidad = 1;
                return this.errorUniversidad;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';

                this.errorUniversidad=0;
                this.errorMostrarMsjUniversidad = [];
                this.e_nombre = false;
                this.e_idprovincia = false;
                this.e_idcanton = false;
                
                this.nombre='';
                this.idprovincia=0;
                this.idcanton=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "universidad":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Universidad';
                                this.nombre= '';
                                this.idprovincia = 0;
                                this.idcanton = 0;
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Universidad';
                                this.tipoAccion=2;
                                this.universidad_id=data['id'];
                                this.nombre = data['nombre'];
                                this.idprovincia= data['idprovincia'];
                                this.idcanton= data['idcanton'];
                                break;
                            }                            
                        }
                    }
                }
                this.selectProvincia();
                this.selectCanton();
            },
            ceroBusqueda(){
                this.buscar='';
                this.listarUniversidad(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
            }
        },
        mounted() {
            this.listarUniversidad(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>