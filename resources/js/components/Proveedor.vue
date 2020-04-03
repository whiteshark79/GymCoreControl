<template>

    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Proveedores</h3></div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary" @click="abrirModal('persona','registrar')"><i class="icon-plus">  Nuevo Proveedor</i></button>
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
                                        <button type="submit" @click="listarPersona(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="icon-magnifier"></i> Buscar</button>                                 
                                        <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="icon-reload"></i> </button>
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
                                            <th scope="col" width="25%">RAZÓN SOCIAL
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'asc') || (ordenado === 'nombre' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'nombre','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'desc') || (ordenado === 'nombre' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'nombre','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>                                            
                                            <th scope="col" width="25%">DIRECCIÓN
                                                <template v-if="(ordenado !== 'direccion' && ascdesc === 'asc') || (ordenado === 'direccion' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'direccion','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'direccion' && ascdesc === 'desc') || (ordenado === 'direccion' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'direccion','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="18%">EMAIL</th>
                                            <th scope="col" width="10%">CONTACTO</th>                             
                                            <th scope="col" width="10%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayPersona.length">
                                        <tr v-for="persona in arrayPersona" :key="persona.id">
                                            <td align="center" v-text="persona.num_documento" scope="row" data-label="DOC"></td>
                                            <td v-text="persona.nombre" data-label="RAZÓN SOCIAL"></td>
                                            <td v-text="persona.direccion" data-label="DIRECCIÓN"></td>
                                            <td v-text="persona.email" data-label="EMAIL"></td>
                                            <td v-text="persona.nombre_contacto" data-label="CONTACTO"></td>
                                            <td align="center" data-label="ACCIONES">
                                                <a class="btn btn-sm btn-default" @click="abrirModal('persona','actualizar',persona)"><i class="icon-note" title="Editar"></i></a>                                                
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
                                        <span class="input-group-text"><i class="fas fa-industry"></i></span>
                                        <select v-model="tipo_documento" class="form-control col-2">
                                            <option value="0" disabled>--Doc.--</option>
                                            <option value="C">Cédula</option>
                                            <option value="R">RUC</option>                                          
                                        </select>
                                        <input type="text" v-model="num_documento" id="num_documento" class="form-control col-4" v-bind:class="{ 'is-invalid': e_num_documento }" @change="existePersonaId()" placeholder="No. de documento">
                                        <input type="hidden" :value="num_documento" id="ci">
                                        <input type="text" v-model="nombre" maxlength="60" id="nombre" class="form-control col-6" v-bind:class="{ 'is-invalid': e_nombre }" placeholder="Razón Social">
                                    </div>
                                    <span class="text-error" v-show="stsPersonaId">No de documento ya existe</span>
                                </div>                                                                                
                            </div>
                            
                            <div class="form-row">
                                <div class="form-group col-md-12">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-map-marker-alt"></i></span>
                                        <input type="text" v-model="direccion" class="form-control" v-bind:class="{ 'is-invalid': e_direccion }" placeholder="Dirección">
                                    </div>                                        
                                </div>                                                                                                        
                            </div>                                                
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-phone-alt"></i></span>
                                        <input type="text" v-model="celular" id="celular" class="form-control" v-bind:class="{ 'is-invalid': e_celular }" placeholder="Teléfono">
                                    </div>                                        
                                </div> 
                                <div class="form-group col-md-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="text" v-model="email" id="email" class="form-control" @change="existePersonaEmail()" placeholder="Email">
                                        <input type="hidden" :value="email" id="mail">
                                    </div>
                                    <span class="text-error" v-show="stsPersonaEmail">Correo ya existe</span>
                                </div>                                           
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-user"></i></span>
                                        <input type="text" v-model="nombre_contacto" id="nombre_contacto" class="form-control" placeholder="Nombre y apellido contacto">                                                            
                                    </div>
                                </div>
                                <div class="form-group col-md-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-mobile-alt"></i></span>
                                        <input type="text" v-model="celular_contacto" id="celular_contacto" class="form-control" placeholder="Celular contacto">                                                            
                                    </div>
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="form-group col-md-6">
                                    <div class="input-group input-group-sm">
                                        <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                        <input type="text" v-model="email_contacto" id="email_contacto" class="form-control" placeholder="Email contacto">                                                            
                                    </div>
                                </div>
                            </div>                           

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-info btn-sm" @click="registrarPersona()" :disabled="stsPersona!=''">Guardar</button>                        
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
import Inputmask from 'inputmask';
    export default {
        data (){
            return {
                persona_id: 0,
                tipo_documento : 'R',
                num_documento : '',                
                nombre : '',               
                direccion : '',
                celular : '',
                email : '',
                nombre_contacto : '',
                celular_contacto : '',
                email_contacto : '',
                arrayPersona : [],

                stsPersona : '',
                stsPersonaId : '',
                stsPersonaEmail : '',

                modal : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorPersona : 0,
                errorMostrarMsjPersona : [],
                e_num_documento : false,
                e_nombre : false,
                e_direccion : false,
                e_celular : false, 

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
            validarInput(){                
                Inputmask("99-99999999").mask(num_documento);
                Inputmask("09-999-9999").mask(celular);
                Inputmask({
                            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
                            greedy: false,
                            onBeforePaste: function (pastedValue, opts) {
                            pastedValue = pastedValue.toLowerCase();
                            return pastedValue.replace("mailto:", "");
                            },
                            definitions: {
                            '*': {
                                validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                                casing: "lower"
                            }
                            }
                        }).mask(email);
                Inputmask("Aa{3,15} Aa{3,15}").mask(nombre_contacto); 
                Inputmask("09-999-9999").mask(celular_contacto); 
                Inputmask({
                            mask: "*{1,20}[.*{1,20}][.*{1,20}][.*{1,20}]@*{1,20}[.*{2,6}][.*{1,2}]",
                            greedy: false,
                            onBeforePaste: function (pastedValue, opts) {
                            pastedValue = pastedValue.toLowerCase();
                            return pastedValue.replace("mailto:", "");
                            },
                            definitions: {
                            '*': {
                                validator: "[0-9A-Za-z!#$%&'*+/=?^_`{|}~\-]",
                                casing: "lower"
                            }
                            }
                        }).mask(email_contacto);                            
                
                         

            }, 
            listarPersona (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/proveedor?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
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
            cambiarPagina(page,buscar,criterio,paginado,ordenado,ascdesc){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarPersona(page,buscar,criterio,paginado,ordenado,ascdesc);
            },
            existePersonaId(){
                let me=this;

                me.ci=document.getElementById('ci').value;
                
                var url= '/cliente/selectPersonaId?num_documento='+me.ci;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.stsPersonaId = respuesta.stsPersonaId;
                    me.habilitarGuardar();                     
                })                
                .catch(function (error) {
                    console.log(error);
                }); 
            },
            existePersonaEmail(){
                let me=this;

                me.mail=document.getElementById('mail').value;
                
                var url= '/cliente/selectPersonaEmail?email='+me.mail;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.stsPersonaEmail = respuesta.stsPersonaEmail; 
                    me.habilitarGuardar();                    
                })                
                .catch(function (error) {
                    console.log(error);
                });          
            },
            habilitarGuardar(){
                let me=this;
                if(me.stsPersonaId || me.stsPersonaEmail)
                {
                    me.stsPersona=1;
                }else{
                    me.stsPersona='';
                    }
            },
            registrarPersona(){
               if (this.validarPersona()){ return; }
                let me = this;

                axios.post('/proveedor/registrar',{
                    'tipo_documento' : this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'nombre' : this.nombre,                   
                    'direccion' : this.direccion,                  
                    'celular' : this.celular,
                    'email' : this.email,
                    'nombre_contacto' : this.nombre_contacto,                  
                    'celular_contacto' : this.celular_contacto,
                    'email_contacto' : this.email_contacto
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

                axios.put('/proveedor/actualizar',{
                    'tipo_documento' : this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'nombre' : this.nombre,                   
                    'direccion' : this.direccion,                  
                    'celular' : this.celular,
                    'email' : this.email,
                    'nombre_contacto' : this.nombre_contacto,                  
                    'celular_contacto' : this.celular_contacto,
                    'email_contacto' : this.email_contacto,
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
            validarPersona(){
                this.errorPersona=0;
                this.errorMostrarMsjPersona =[];

                if (!this.num_documento) {this.e_num_documento = true; this.errorMostrarMsjPersona.push('num_documento');}else{this.e_num_documento = false}
                if (!this.nombre) {this.e_nombre = true; this.errorMostrarMsjPersona.push('nombre');}else{this.e_nombre = false}
                if (!this.direccion) {this.e_direccion = true; this.errorMostrarMsjPersona.push('direccion');}else{this.e_direccion = false}
                if (!this.celular) {this.e_celular = true; this.errorMostrarMsjPersona.push('celular');}else{this.e_celular = false}
                

                if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;

                return this.errorPersona;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';

                this.errorPersona=0;
                this.errorMostrarMsjPersona = [];

                this.stsPersona = '';
                this.stsPersonaId = '';
                this.stsPersonaEmail = '';

                this.e_num_documento = false;
                this.e_nombre = false;
                this.e_direccion = false;
                this.e_celular = false;
                
                this.tipo_documento = 'R';
                this.num_documento = '';
                this.nombre = '';
                this.direccion = '';                
                this.celular = '';
                this.email = '';
                this.nombre_contacto = '';
                this.celular_contacto = '';
                this.email_contacto = '';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Proveedor';
                                this.tipoAccion = 1;
                                
                                this.tipo_documento = 'R';
                                this.num_documento = '';
                                this.nombre = '';
                                this.direccion = '';                
                                this.celular = '';
                                this.email = '';
                                this.nombre_contacto = '';
                                this.celular_contacto = '';
                                this.email_contacto = '';
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Proveedor';
                                this.tipoAccion=2;

                                this.persona_id=data['id'];
                                this.tipo_documento=data['tipo_documento'];
                                this.num_documento=data['num_documento'];                                
                                this.nombre = data['nombre'];                            
                                this.direccion= data['direccion'];
                                this.celular= data['celular'];
                                this.email= data['email'];
                                this.nombre_contacto= data['nombre_contacto'];
                                this.celular_contacto= data['celular_contacto'];
                                this.email_contacto= data['email_contacto'];
                                break;
                            }
                        }
                    }
                }
                this.validarInput();
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