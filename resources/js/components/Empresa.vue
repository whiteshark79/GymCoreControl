<template>
 
    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Empresas</h3></div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary btn-sm" @click="abrirModal('empresa','registrar')"><i class="icon-plus">  Nueva Empresa</i></button>
                            </div>
                        </div>                      

                        <div class="card-body">
                            <div class="form-group row justify-content-between">
                                <div class="row col-sm-12 col-md-12">
                                    <div class="input-group input-group-sm col-sm-11 col-md-11">                                
                                        <select class="form-control col-sm-3 col-md-2" v-model="criterio" @change="ceroBusqueda();">
                                        <option value="nombre">Nombre</option>
                                        </select>
                                        <input type="text" v-model="buscar" @keyup.enter="listarEmpresa(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control col-sm-3 col-md-3" placeholder="Texto a buscar">
                                        <button type="submit" @click="listarEmpresa(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="icon-magnifier"></i> Buscar</button>                                 
                                        <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="icon-reload"></i> </button>
                                    </div>                                    
                                    <div class="input-group input-group-sm col-sm-1 col-md-1">                                     
                                        <select class="form-control" v-model="paginado" @change="listarEmpresa(1,buscar,criterio,paginado,ordenado,ascdesc)">
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
                                                    <a href="#" @click="listarEmpresa(1,buscar,criterio,paginado,'id','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'id' && ascdesc === 'desc') || (ordenado === 'id' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarEmpresa(1,buscar,criterio,paginado,'id','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="10%">RUC
                                                <template v-if="(ordenado !== 'ruc' && ascdesc === 'asc') || (ordenado === 'ruc' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarEmpresa(1,buscar,criterio,paginado,'ruc','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'ruc' && ascdesc === 'desc') || (ordenado === 'ruc' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarEmpresa(1,buscar,criterio,paginado,'ruc','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="20%">RAZON SOCIAL
                                                <template v-if="(ordenado !== 'razon_social' && ascdesc === 'asc') || (ordenado === 'razon_social' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarEmpresa(1,buscar,criterio,paginado,'razon_social','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'razon_social' && ascdesc === 'desc') || (ordenado === 'razon_social' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarEmpresa(1,buscar,criterio,paginado,'razon_social','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="20%">NOMBRE
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'asc') || (ordenado === 'nombre' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarEmpresa(1,buscar,criterio,paginado,'nombre','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'desc') || (ordenado === 'nombre' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarEmpresa(1,buscar,criterio,paginado,'nombre','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="25%">SLOGAN</th>
                                            <th scope="col" width="10%">ESTADO
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'asc') || (ordenado === 'condicion' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarEmpresa(1,buscar,criterio,paginado,'condicion','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'desc') || (ordenado === 'condicion' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarEmpresa(1,buscar,criterio,paginado,'condicion','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="10%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayEmpresa.length">
                                        <tr v-for="empresa in arrayEmpresa" :key="empresa.id">
                                            <td v-text="empresa.id" align="center" scope="row" data-label="#"></td>
                                            <td v-text="empresa.ruc" data-label="RUC"></td>
                                            <td v-text="empresa.razon_social" data-label="RAZON SOCIAL"></td>
                                            <td v-text="empresa.nombre" data-label="NOMBRE"></td>
                                            <td data-label="SLOGAN"><em>"{{ empresa.slogan }}"</em></td>
                                            <td align="center" data-label="ESTADO">
                                                <div v-if="empresa.condicion"><span class="badge badge-success">Activo</span></div>
                                                <div v-else><span class="badge badge-secondary">Inactivo</span></div>                                    
                                            </td>
                                            <td align="center" data-label="ACCIONES">
                                                <a class="btn btn-sm btn-default" @click="abrirModal('empresa','actualizar',empresa)"><i class="icon-note" title="Editar"></i></a>                                   
                                                <template v-if="empresa.condicion">
                                                    <a class="btn btn-sm btn-default" @click="desactivarEmpresa(empresa.id)"><i class="icon-ban" title="Desactivar"></i></a>
                                                </template>
                                                <template v-else>
                                                    <a class="btn btn-sm btn-default" @click="activarEmpresa(empresa.id)"><i class="icon-check" title="Actualizar"></i></a>
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
                        <span class="modal-title text-title" v-text="tituloModal"></span>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-building"></i></span>                                        
                                        <input type="number" v-model="ruc" class="form-control col-4" v-bind:class="{ 'is-invalid': e_ruc }" placeholder="RUC">
                                        <input type="text" v-model="razon_social" maxlength="60" class="form-control col-8" v-bind:class="{ 'is-invalid': e_razon_social }" placeholder="Razón Social">
                                    </div>
                                </div>                                                                                
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-signature"></i></span>                                        
                                        <input type="text" v-model="nombre" maxlength="60" class="form-control col-4" v-bind:class="{ 'is-invalid': e_nombre }" placeholder="Nombre">
                                        <input type="text" maxlength="100" v-model="slogan" class="form-control col-8 text-cursiva" placeholder="Slogan">
                                    </div>
                                </div>                                                                                
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="email" v-model="email" class="form-control" placeholder="Email">
                                    </div>
                                </div> 
                            </div> 
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-globe"></i></span>
                                        <input type="url" v-model="web" class="form-control" placeholder="Web">
                                    </div>                                        
                                </div> 
                                                                         
                            </div>    
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" v-model="nombre_propietario" class="form-control" placeholder="Nombre Propietario">                                                            
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                        <input type="number" v-model="celular_propietario" class="form-control" placeholder="Celular Propietario">                                                            
                                    </div>
                                </div>
                            </div>    
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-info btn-sm" @click="registrarEmpresa()">Guardar</button>                        
                        <button type="button" v-if="tipoAccion==2" class="btn btn-success btn-sm" @click="actualizarEmpresa()">Actualizar</button>    
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
                empresa_id: 0,
                ruc : '',
                razon_social : '',
                nombre : '',
                slogan : '',
                email : '',
                web : '',
                nombre_propietario : '',
                celular_propietario : '',

                arrayEmpresa : [],

                modal : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorEmpresa : 0,
                errorMostrarMsjEmpresa : [],
                e_ruc : false,
                e_razon_social : false,
                e_nombre : false,
                e_email : false,

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
            listarEmpresa (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/empresa?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayEmpresa = respuesta.empresas.data;
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
                me.listarEmpresa(page,buscar,criterio,paginado,ordenado,ascdesc);
            },
            registrarEmpresa(){
               if (this.validarEmpresa()){ return; }
                let me = this;

                axios.post('/empresa/registrar',{
                    'ruc': this.ruc,
                    'razon_social': this.razon_social,
                    'nombre': this.nombre,
                    'slogan': this.slogan,
                    'email': this.email,
                    'web': this.web,
                    'nombre_propietario': this.nombre_propietario,
                    'celular_propietario': this.celular_propietario
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
                    me.listarEmpresa(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarEmpresa(){
               if (this.validarEmpresa()){ return; }
                let me = this;

                axios.put('/empresa/actualizar',{
                    'ruc': this.ruc,
                    'razon_social': this.razon_social,
                    'nombre': this.nombre,
                    'slogan': this.slogan,
                    'email': this.email,
                    'web': this.web,
                    'nombre_propietario': this.nombre_propietario,
                    'celular_propietario': this.celular_propietario,
                    'id': this.empresa_id
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
                    me.listarEmpresa(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },            
            desactivarEmpresa(id){
               Swal.fire({
                title: 'Desactivar la empresa?',
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
                    axios.put('/empresa/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEmpresa(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
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
            activarEmpresa(id){
               Swal.fire({
                title: 'Activar la empresa?',
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
                    axios.put('/empresa/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarEmpresa(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
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
            validarEmpresa(){
                this.errorEmpresa=0;
                this.errorMostrarMsjEmpresa =[];

                if (!this.ruc) {this.e_ruc = true; this.errorMostrarMsjEmpresa.push('ruc');}else{this.e_ruc = false}
                if (!this.razon_social) {this.e_razon_social = true; this.errorMostrarMsjEmpresa.push('razon_social');}else{this.e_razon_social = false}
                if (!this.nombre) {this.e_nombre = true; this.errorMostrarMsjEmpresa.push('nombre');}else{this.e_nombre = false}
                if (!this.email) {this.e_email = true; this.errorMostrarMsjEmpresa.push('email');}else{this.e_email = false}

                if (this.errorMostrarMsjEmpresa.length) this.errorEmpresa = 1;

                return this.errorEmpresa;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';

                this.errorEmpresa=0;
                this.errorMostrarMsjEmpresa = [];
                this.e_ruc = false;
                this.e_razon_social = false;
                this.e_nombre = false;
                this.e_email = false;
                
                this.ruc = '';
                this.razon_social = '';
                this.nombre = '';
                this.slogan = '';
                this.email = '';
                this.web = '';
                this.nombre_propietario = '';
                this.celular_propietario = '';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "empresa":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Empresa';
                                this.tipoAccion = 1;

                                this.ruc = '';
                                this.razon_social = '';
                                this.nombre = '';
                                this.slogan = '';
                                this.email = '';
                                this.web = '';
                                this.nombre_propietario = '';
                                this.celular_propietario = '';
                                
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Empresa';
                                this.tipoAccion=2;

                                this.empresa_id=data['id'];

                                this.ruc = data['ruc'];
                                this.razon_social = data['razon_social'];
                                this.nombre = data['nombre'];
                                this.slogan = data['slogan'];
                                this.email = data['email'];
                                this.web = data['web'];
                                this.nombre_propietario = data['nombre_propietario'];
                                this.celular_propietario = data['celular_propietario'];
                                
                                break;
                            }                            
                        }
                    }
                }
            },
            ceroBusqueda(){
                this.buscar='';
                this.listarEmpresa(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
            }
        },
        mounted() {
            this.listarEmpresa(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>