<template>
 
    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Especialidades</h3></div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary btn-sm" @click="abrirModal('especialidad','registrar')"><i class="icon-plus">  Nueva Especialidad</i></button>
                            </div>
                        </div>                      

                        <div class="card-body">
                            <div class="form-group row justify-content-between">
                                <div class="row col-sm-12 col-md-12">
                                    <div class="input-group input-group-sm col-sm-11 col-md-11">                                
                                        <select class="form-control col-sm-3 col-md-2" v-model="criterio" @change="ceroBusqueda();">
                                            <option value="nombre">Nombre</option>
                                            <option value="descripcion">Descripción</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarEspecialidad(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control col-sm-3 col-md-3" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarEspecialidad(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="icon-magnifier"></i> Buscar</button>
                                        <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="icon-reload"></i> </button>                               
                                    </div>
                                    <div class="input-group input-group-sm col-sm-1 col-md-1">                                     
                                        <select class="form-control" v-model="paginado" @change="listarEspecialidad(1,buscar,criterio,paginado,ordenado,ascdesc)">
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
                                                    <a href="#" @click="listarEspecialidad(1,buscar,criterio,paginado,'id','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'id' && ascdesc === 'desc') || (ordenado === 'id' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarEspecialidad(1,buscar,criterio,paginado,'id','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="30%">NOMBRE
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'asc') || (ordenado === 'nombre' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarEspecialidad(1,buscar,criterio,paginado,'nombre','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'desc') || (ordenado === 'nombre' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarEspecialidad(1,buscar,criterio,paginado,'nombre','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col">DESCRIPCIÓN</th>
                                            <th scope="col" width="10%">ESTADO
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'asc') || (ordenado === 'condicion' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarEspecialidad(1,buscar,criterio,paginado,'condicion','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'desc') || (ordenado === 'condicion' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarEspecialidad(1,buscar,criterio,paginado,'condicion','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="10%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayEspecialidad.length">
                                        <tr v-for="especialidad in arrayEspecialidad" :key="especialidad.id">
                                            <td v-text="especialidad.id" align="center" scope="row" data-label="#"></td>
                                            <td v-text="especialidad.nombre" data-label="NOMBRE"></td>
                                            <td v-text="especialidad.descripcion" data-label="DESCRIPCIÓN"></td>                                            
                                            <td align="center" data-label="ESTADO">
                                                <div v-if="especialidad.condicion"><span class="badge badge-success">Activo</span></div>
                                                <div v-else><span class="badge badge-secondary">Inactivo</span></div>                                    
                                            </td>
                                            <td align="center" data-label="ACCIONES">
                                                <a class="btn btn-sm btn-default" @click="abrirModal('especialidad','actualizar',especialidad)"><i class="icon-note" title="Editar"></i></a>                                   
                                                <template v-if="especialidad.condicion">
                                                    <a class="btn btn-sm btn-default" @click="desactivarEspecialidad(especialidad.id)"><i class="icon-ban" title="Desactivar"></i></a>
                                                </template>
                                                <template v-else>
                                                    <a class="btn btn-sm btn-default" @click="activarEspecialidad(especialidad.id)"><i class="icon-check" title="Actualizar"></i></a>
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
            <div class="modal-dialog modal-primary modal-sm modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title text-title" v-text="tituloModal"></span>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-3">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Nombre: </span>
                                    </div>
                                    <input type="text" v-model="nombre" maxlength="35" class="form-control" v-bind:class="{ 'is-invalid': e_nombre }">
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-3">
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
                        <button type="button" v-if="tipoAccion==1" class="btn btn-info btn-sm" @click="registrarEspecialidad()">Guardar</button>                        
                        <button type="button" v-if="tipoAccion==2" class="btn btn-success btn-sm" @click="actualizarEspecialidad()">Actualizar</button>

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
                especialidad_id: 0,
                nombre : '',
                descripcion : '',
                arrayEspecialidad : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorEspecialidad : 0,
                errorMostrarMsjEspecialidad : [],
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
            listarEspecialidad (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/especialidad?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEspecialidad = respuesta.especialidades.data;
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
                me.listarEspecialidad(page,buscar,criterio,paginado,ordenado,ascdesc);
            },
            registrarEspecialidad(){
               if (this.validarEspecialidad()){ return; }
                let me = this;

                axios.post('/especialidad/registrar',{
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
                    me.listarEspecialidad(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarEspecialidad(){
               if (this.validarEspecialidad()){ return; }
                let me = this;

                axios.put('/especialidad/actualizar',{
                    'nombre': this.nombre,
                    'descripcion': this.descripcion,
                    'id': this.especialidad_id
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
                    me.listarEspecialidad(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarEspecialidad(id){
               Swal.fire({
                title: 'Desactivar la especialidad?',
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
                    axios.put('/especialidad/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEspecialidad(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
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
            activarEspecialidad(id){
               Swal.fire({
                title: 'Activar la especialidad?',
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
                    axios.put('/especialidad/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEspecialidad(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
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
            validarEspecialidad(){
                this.errorEspecialidad=0;
                this.errorMostrarMsjEspecialidad =[];

                if (!this.nombre) {this.e_nombre = true; this.errorMostrarMsjEspecialidad.push('nombre');}else{this.e_nombre = false}
                if (!this.descripcion) {this.e_descripcion = true; this.errorMostrarMsjEspecialidad.push('descripcion');}else{this.e_descripcion = false}

                if (this.errorMostrarMsjEspecialidad.length) this.errorEspecialidad = 1;
                return this.errorEspecialidad;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';

                this.errorEspecialidad = 0;
                this.errorMostrarMsjEspecialidad = [];
                this.e_nombre = false;
                this.e_descripcion = false; 
                
                this.nombre= '';
                this.descripcion = '';   
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "especialidad":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Especialidad';
                                this.nombre= '';
                                this.descripcion = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar especialidad';
                                this.tipoAccion=2;
                                this.especialidad_id=data['id'];
                                this.nombre = data['nombre'];
                                this.descripcion= data['descripcion'];
                                break;
                            }
                        }
                    }
                }
            },
            ceroBusqueda(){
                this.buscar='';
                this.listarEspecialidad(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
            }
        },
        mounted() {
            this.listarEspecialidad(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>