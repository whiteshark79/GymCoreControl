<template>
 
    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Usuarios</h3></div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary" @click="abrirModal('persona','registrar')"><i class="fas fa-plus-circle">  Nuevo Usuario</i></button>
                            </div>
                        </div>                      

                        <div class="card-body">
                            <div class="form-group row justify-content-between">
                                <div class="row col-sm-12 col-md-12">
                                    <div class="input-group input-group-sm col-sm-11 col-md-11">                                
                                        <select class="form-control col-sm-3 col-md-2" v-model="criterio" @change="ceroBusqueda();">
                                            <option value="nombre">Nombre</option>
                                            <option value="num_documento">Documento</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control col-sm-3 col-md-3" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarPersona(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>                                 
                                        <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="fas fa-redo"></i> </button>
                                    </div>
                                    <div class="input-group input-group-sm col-sm-1 col-md-1">                                     
                                        <select class="form-control" v-model="paginado" @change="listarPersona(1,buscar,criterio,paginado,ordenado,ascdesc)">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                        </select>
                                    </div>
                                </div>
                            </div>  
                            <div class="table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar">
                                <table class="table table-bordered table-sm table-hover" id="dtTable">
                                    <thead class="thead-table">
                                        <tr align="center">
                                            <th scope="col" width="10%">DOC
                                                <template v-if="(ordenado !== 'num_documento' && ascdesc === 'asc') || (ordenado === 'num_documento' && ascdesc === 'desc') ">
                                                    <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'num_documento','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'num_documento' && ascdesc === 'desc') || (ordenado === 'num_documento' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'num_documento','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="50%">NOMBRE
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'asc') || (ordenado === 'nombre' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'nombre','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'desc') || (ordenado === 'nombre' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'nombre','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>                                                                                    
                                            <th scope="col" width="8%">USUARIO</th>
                                            <th scope="col" width="10%">ROL</th>                                            
                                            <th scope="col" width="10%">ESTADO
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'asc') || (ordenado === 'condicion' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'condicion','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'desc') || (ordenado === 'condicion' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'condicion','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>                                                                                    
                                            <th scope="col" width="10%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayPersona.length">
                                        <tr v-for="persona in arrayPersona" :key="persona.id">
                                            <td v-text="persona.num_documento"></td>
                                            <td v-text="persona.nombre"></td>
                                            <td v-text="persona.usuario"></td>                              
                                            <td align="center" v-text="persona.rol"></td>
                                            <td align="center">
                                                <div v-if="persona.condicion"><span class="badge badge-success">Activo</span></div>
                                                <div v-else><span class="badge badge-danger">Inactivo</span></div>                                    
                                            </td>
                                            <td align="center">
                                                <a class="btn btn-sm btn-default" @click="abrirModal('persona','actualizar',persona)"><i class="fas fa-edit" title="Editar"></i></a>                                   
                                                <template v-if="persona.condicion">
                                                    <a class="btn btn-sm btn-default" @click="desactivarUsuario(persona.id)"><i class="fas fa-ban" title="Desactivar"></i></a>
                                                </template>
                                                <template v-else>
                                                    <a class="btn btn-sm btn-default" @click="activarUsuario(persona.id)"><i class="fas fa-sync" title="Actualizar"></i></a>
                                                </template>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="7" class="text-center">
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
                                <div class="form-group col-md-7">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="far fa-id-card"></i></span>
                                        <select v-model="tipo_documento" class="form-control col-4">
                                            <option value="0" disabled>--Tipo de Doc--</option>
                                            <option value="C">Cédula</option>
                                            <option value="R">RUC</option>
                                            <option value="P">Pasaporte</option>                                            
                                        </select>
                                        <input type="number" v-model="num_documento" class="form-control" v-bind:class="{ 'is-invalid': e_num_documento }" placeholder="Número de documento">
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                        <input type="date" v-model="fec_nacimiento" class="form-control" v-bind:class="{ 'is-invalid': e_fec_nacimiento }">
                                    </div>                                        
                                </div>                                                
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-7">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                        <input type="text" maxlength="60" v-model="nombre" class="form-control" v-bind:class="{ 'is-invalid': e_nombre }" placeholder="Nombre">
                                    </div>
                                </div>
                                <div class="form-group col-md-5">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-user-tag"></i></span>
                                        <select class="form-control" v-bind:class="{ 'is-invalid': e_idrol }" v-model="idrol">
                                            <option value="0" disabled>--Rol--</option>
                                            <option v-for="rol in arrayRol" :key="rol.id" :value="rol.id" v-text="rol.nombre"></option>
                                        </select>
                                    </div>                                        
                                </div>                                                                                                        
                            </div>                                                
                            <div class="form-row">
                                <div class="form-group col-md-5">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fa fa-mobile-alt"></i></span>
                                        <input type="number" v-model="celular" class="form-control" v-bind:class="{ 'is-invalid': e_celular }" placeholder="Celular">
                                    </div>                                        
                                </div> 
                                <div class="form-group col-md-7">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                        <input type="email" v-model="email" class="form-control" v-bind:class="{ 'is-invalid': e_email }" placeholder="Email">
                                    </div>
                                </div>                                           
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fa fa-map-marker-alt"></i></span>
                                        <input type="text" maxlength="60" v-model="direccion" class="form-control" v-bind:class="{ 'is-invalid': e_direccion }" placeholder="Dirección">                                                            
                                    </div>
                                </div> 
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" v-model="usuario" class="form-control" v-bind:class="{ 'is-invalid': e_usuario }" placeholder="Usuario">
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-key"></i></span>
                                        <input type="text" v-model="password" class="form-control" v-bind:class="{ 'is-invalid': e_password }" placeholder="Clave">
                                    </div>
                                </div>                                                                                     
                            </div>                            

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-info btn-sm" @click="registrarPersona()">Guardar</button>                        
                        <button type="button" v-if="tipoAccion==2" class="btn btn-success btn-sm" @click="actualizarPersona()">Actualizar</button>
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
                persona_id: 0,
                tipo_documento : 'C',
                num_documento : '',                
                nombre : '',
                fec_nacimiento : '',                
                direccion : '',
                celular : '',
                email : '',

                usuario : '',
                password : '',
                idrol : 0,
               
                arrayRol : [],
                arrayPersona : [],

                modal : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorPersona : 0,
                errorMostrarMsjPersona : [],
                e_num_documento : false,
                e_nombre : false,
                e_fec_nacimiento : false,
                e_direccion : false,
                e_celular : false,
                e_email : false,
                e_usuario : false,
                e_password : false,
                e_idrol : false,

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
            listarPersona (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/user?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayPersona = respuesta.personas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
                me.ordenado=ordenado;
                me.ascdesc=ascdesc;
            },
            selectRol(){
                let me=this;
                var url= '/rol/selectRol';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayRol = respuesta.roles;
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
                me.listarPersona(page,buscar,criterio,paginado,ordenado,ascdesc);
            },
            registrarPersona(){
               if (this.validarPersona()){ return; }
                let me = this;

                axios.post('/user/registrar',{
                    'tipo_documento' : this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'nombre' : this.nombre,
                    'fec_nacimiento' : this.fec_nacimiento,                    
                    'direccion' : this.direccion,                  
                    'celular' : this.celular,
                    'email' : this.email,
                    'usuario' : this.usuario,
                    'password' : this.password,
                    'idrol' : this.idrol
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
                    me.listarPersona(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarPersona(){
               if (this.validarPersona()){ return; }
                let me = this;

                axios.put('/user/actualizar',{
                    'tipo_documento' : this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'nombre' : this.nombre,
                    'fec_nacimiento' : this.fec_nacimiento,                    
                    'direccion' : this.direccion,                  
                    'celular' : this.celular,
                    'email' : this.email,
                    'usuario' : this.usuario,
                    'password' : this.password,
                    'idrol' : this.idrol,
                    'id': this.persona_id
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
                    me.listarPersona(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarUsuario(id){
               Swal.fire({
                title: 'Desactivar el Usuario?',
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
                    axios.put('/user/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPersona(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
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
            activarUsuario(id){
               Swal.fire({
                title: 'Activar el Usuario?',
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
                    axios.put('/user/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarPersona(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
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
            validarPersona(){
                this.errorPersona=0;
                this.errorMostrarMsjPersona =[];

                if (!this.num_documento) {this.e_num_documento = true; this.errorMostrarMsjPersona.push('num_documento');}else{this.e_num_documento = false}
                if (!this.fec_nacimiento) {this.e_fec_nacimiento = true; this.errorMostrarMsjPersona.push('fec_nacimiento');}else{this.e_fec_nacimiento = false}
                if (!this.nombre) {this.e_nombre = true; this.errorMostrarMsjPersona.push('nombre');}else{this.e_nombre = false}
                if (!this.celular) {this.e_celular = true; this.errorMostrarMsjPersona.push('celular');}else{this.e_celular = false}
                if (!this.email) {this.e_email = true; this.errorMostrarMsjPersona.push('email');}else{this.e_email = false}
                if (!this.direccion) {this.e_direccion = true; this.errorMostrarMsjPersona.push('direccion');}else{this.e_direccion = false}
                if (!this.usuario) {this.e_usuario = true; this.errorMostrarMsjPersona.push('usuario');}else{this.e_usuario = false}
               // if (!this.password) {this.e_password = true; this.errorMostrarMsjPersona.push('password');}else{this.e_password = false}
                if (!this.idrol) {this.e_idrol = true; this.errorMostrarMsjPersona.push('idrol');}else{this.e_idrol = false}                

                if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

                return this.errorPersona;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';

                this.errorPersona=0;
                this.errorMostrarMsjPersona = [];
                this.e_num_documento = false;
                this.e_nombre = false;
                this.e_fec_nacimiento = false;
                this.e_direccion = false;
                this.e_celular = false;
                this.e_email = false;
                this.e_usuario = false;
                this.e_password = false;
                this.e_idrol = false;
                
                this.tipo_documento = 'C';
                this.num_documento = '';
                this.nombre = '';
                this.fec_nacimiento = '';
                this.direccion = '';                
                this.celular = '';
                this.email = '';
                this.usuario = '';
                this.password = '';
                this.idrol = 0;
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Usuario';
                                this.tipoAccion = 1;
                                
                                this.tipo_documento = 'C';
                                this.num_documento = '';
                                this.nombre = '';
                                this.fec_nacimiento = '';
                                this.direccion = '';                
                                this.celular = '';
                                this.email = '';
                                this.usuario = '';
                                this.password = '';
                                this.idrol = 0;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Usuario';
                                this.tipoAccion=2;

                                this.persona_id=data['id'];
                                this.tipo_documento=data['tipo_documento'];
                                this.num_documento=data['num_documento'];                                
                                this.nombre = data['nombre'];
                                this.fec_nacimiento = data['fec_nacimiento'];                               
                                this.direccion= data['direccion'];
                                this.celular= data['celular'];
                                this.email= data['email'];
                                this.usuario= data['usuario'];
                                this.password= data['password'];
                                this.idrol= data['idrol'];
                                break;
                            }
                        }
                    }
                }
                this.selectRol();
            },
            ceroBusqueda(){
                this.buscar='';
                this.listarPersona(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
            }
        },
        mounted() {
            this.listarPersona(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>