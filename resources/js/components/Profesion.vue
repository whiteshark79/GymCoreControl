<template>
 
    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Profesiones</h3></div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary btn-sm" @click="abrirModal('profesion','registrar')"><i class="fas fa-plus-circle">  Nueva Profesión</i></button>
                            </div>
                        </div>                      

                        <div class="card-body">
                            <div class="form-group row justify-content-between">
                                <div class="input-group input-group-sm col-7">                                
                                    <select class="form-control col-2 " v-model="criterio">
                                    <option value="nombre">Nombre</option>
                                    <option value="descripcion">Descripción</option>
                                    </select>
                                    <input type="text" v-model="buscar" @keyup.enter="listarProfesion(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control col-4" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarProfesion(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>                                 
                                </div>
                                <div class="col-4"></div>
                                <div class="input-group input-group-sm col-1">                                     
                                    <select class="form-control" v-model="paginado" @change="listarProfesion(1,buscar,criterio,paginado,ordenado,ascdesc)">
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
                                                    <a href="#" @click="listarProfesion(1,buscar,criterio,paginado,'id','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'id' && ascdesc === 'desc') || (ordenado === 'id' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarProfesion(1,buscar,criterio,paginado,'id','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="20%">NOMBRE
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'asc') || (ordenado === 'nombre' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarProfesion(1,buscar,criterio,paginado,'nombre','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'desc') || (ordenado === 'nombre' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarProfesion(1,buscar,criterio,paginado,'nombre','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th>DESCRIPCIÓN</th>
                                            <th width="10%">ESTADO
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'asc') || (ordenado === 'condicion' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarProfesion(1,buscar,criterio,paginado,'condicion','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'desc') || (ordenado === 'condicion' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarProfesion(1,buscar,criterio,paginado,'condicion','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="12%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayProfesion.length">
                                        <tr v-for="profesion in arrayProfesion" :key="profesion.id">
                                            <td v-text="profesion.id" align="center"></td>
                                            <td v-text="profesion.nombre"></td>
                                            <td v-text="profesion.descripcion"></td>
                                            <td align="center">
                                                <div v-if="profesion.condicion"><span class="badge badge-success">Activo</span></div>
                                                <div v-else><span class="badge badge-secondary">Inactivo</span></div>                                    
                                            </td>
                                            <td align="center">
                                                <a class="btn btn-sm btn-default" @click="abrirModal('profesion','actualizar',profesion)"><i class="fas fa-edit" title="Editar"></i></a>
                                                <a class="btn btn-sm btn-default" @click="abrirModal('profesion','eliminar',profesion)"><i class="far fa-trash-alt" title="Eliminar"></i></a>                                    
                                                <template v-if="profesion.condicion">
                                                    <a class="btn btn-sm btn-default" @click="desactivarProfesion(profesion.id)"><i class="fas fa-ban" title="Desactivar"></i></a>
                                                </template>
                                                <template v-else>
                                                    <a class="btn btn-sm btn-default" @click="activarProfesion(profesion.id)"><i class="fas fa-sync" title="Actualizar"></i></a>
                                                </template>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="5" class="text-center">
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
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="nombre">Nombre: </span>
                                </div>
                                <input type="text" v-model="nombre" class="form-control">
                            </div>
                            <div class="input-group input-group-sm mb-3">
                                <div class="input-group-prepend">
                                    <span class="input-group-text" id="descripcion">Descripción: </span>
                                </div>                                
                                <textarea  v-model="descripcion" class="form-control form-control-sm" rows="2"></textarea>
                            </div> 
                            <div v-show="errorProfesion" class="form-group row div-error">
                                <div class="text-center text-error">
                                    <div v-for="error in errorMostrarMsjProfesion" :key="error" v-text="error">
                                    </div>
                                </div>
                            </div>

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-info btn-sm" @click="registrarProfesion()">Guardar</button>                        
                        <button type="button" v-if="tipoAccion==2" class="btn btn-success btn-sm" @click="actualizarProfesion()">Actualizar</button>
                        <button type="button" v-if="tipoAccion==3" class="btn btn-danger btn-sm" @click="eliminarProfesion()">Eliminar</button>

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
                profesion_id: 0,
                nombre : '',
                descripcion : '',
                arrayProfesion : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorProfesion : 0,
                errorMostrarMsjProfesion : [],
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
            listarProfesion (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/profesion?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayProfesion = respuesta.profesiones.data;
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
                me.listarProfesion(page,buscar,criterio,paginado,ordenado,ascdesc);
            },
            registrarProfesion(){
               if (this.validarProfesion()){ return; }
                let me = this;

                axios.post('/profesion/registrar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarProfesion(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarProfesion(){
               if (this.validarProfesion()){ return; }
                let me = this;

                axios.put('/profesion/actualizar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'id': this.profesion_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarProfesion(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            eliminarProfesion(){
               if (this.validarProfesion()){ return; }
                let me = this;

                axios.put('/profesion/eliminar',{
                    'id': this.profesion_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarProfesion(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarProfesion(id){
               Swal.fire({
                title: 'Desactivar la categoría?',
                text: "Puede activarla nuevamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, desactivarla'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/profesion/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarProfesion(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
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
            activarProfesion(id){
               Swal.fire({
                title: 'Activar la categoría?',
                text: "Puede desactivarla nuevamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, activarla'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/profesion/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarProfesion(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
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
            validarProfesion(){
                this.errorProfesion=0;
                this.errorMostrarMsjProfesion =[];
                if (!this.nombre) this.errorMostrarMsjProfesion.push("El nombre de la categoría no puede estar vacío.");
                if (this.errorMostrarMsjProfesion.length) this.errorProfesion = 1;
                return this.errorProfesion;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
                
                this.nombre='';
                this.descripcion='';

                this.errorProfesion=0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "profesion":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Profesión';
                                this.nombre= '';
                                this.descripcion = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Profesión';
                                this.tipoAccion=2;
                                this.profesion_id=data['id'];
                                this.nombre = data['nombre'];
                                this.descripcion= data['descripcion'];
                                break;
                            }
                            case 'eliminar':
                            {
                                this.modal=1;
                                this.tituloModal='Eliminar Profesión';
                                this.tipoAccion=3;
                                this.profesion_id=data['id'];
                                this.nombre = data['nombre'];
                                this.descripcion= data['descripcion'];
                                break;
                            }
                        }
                    }
                }
            }
        },
        mounted() {
            this.listarProfesion(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>
<style>    

    .div-error{
        display: flex;
        justify-content: center;
    }
  
</style>