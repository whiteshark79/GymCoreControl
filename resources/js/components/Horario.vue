<template>
 
    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Horarios</h3></div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary btn-sm" @click="abrirModal('horario','registrar')"><i class="fas fa-plus-circle">  Nuevo Horario</i></button>
                            </div>
                        </div>                      

                        <div class="card-body">
                            <div class="form-group row justify-content-between">
                                <div class="input-group input-group-sm col-7">                                
                                    <select class="form-control col-2 " v-model="criterio" @change="ceroBusqueda();">
                                    <option value="periodo">Periodo</option>
                                    </select>
                                    <template v-if="criterio=='periodo'">
                                        <select class="form-control col-4" v-model="buscar">
                                            <option value="" disabled>--Periodo--</option>
                                            <option value="Mañana">Mañana</option>
                                            <option value="Tarde">Tarde</option>
                                            <option value="Noche">Noche</option>                                            
                                        </select>
                                    </template>
                                    <button type="submit" @click="listarHorario(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>
                                    <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="fas fa-redo"></i> </button>                               
                                </div>
                                <div class="col-4"></div>
                                <div class="input-group input-group-sm col-1">                                     
                                    <select class="form-control" v-model="paginado" @change="listarHorario(1,buscar,criterio,paginado,ordenado,ascdesc)">
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
                                                    <a href="#" @click="listarHorario(1,buscar,criterio,paginado,'id','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'id' && ascdesc === 'desc') || (ordenado === 'id' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarHorario(1,buscar,criterio,paginado,'id','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="15%">LOCAL
                                                <template v-if="(ordenado !== 'idlocal' && ascdesc === 'asc') || (ordenado === 'idlocal' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarHorario(1,buscar,criterio,paginado,'idlocal','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'idlocal' && ascdesc === 'desc') || (ordenado === 'idlocal' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarHorario(1,buscar,criterio,paginado,'idlocal','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="20%">HORARIO
                                                <template v-if="(ordenado !== 'hora_ini' && ascdesc === 'asc') || (ordenado === 'hora_ini' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarHorario(1,buscar,criterio,paginado,'hora_ini','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'hora_ini' && ascdesc === 'desc') || (ordenado === 'hora_ini' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarHorario(1,buscar,criterio,paginado,'hora_ini','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="15%">PERIODO
                                                <template v-if="(ordenado !== 'periodo' && ascdesc === 'asc') || (ordenado === 'periodo' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarHorario(1,buscar,criterio,paginado,'periodo','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'periodo' && ascdesc === 'desc') || (ordenado === 'periodo' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarHorario(1,buscar,criterio,paginado,'periodo','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="25%">DESCRIPCION</th>
                                            <th width="10%">ESTADO
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'asc') || (ordenado === 'condicion' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarHorario(1,buscar,criterio,paginado,'condicion','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'desc') || (ordenado === 'condicion' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarHorario(1,buscar,criterio,paginado,'condicion','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="10%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayHorario.length">
                                        <tr v-for="horario in arrayHorario" :key="horario.id">
                                            <td v-text="horario.id" align="center"></td>
                                            <td v-text="horario.local" align="center"></td>
                                            <td align="center">{{horario.hora_ini}} - {{horario.hora_fin}}</td>
                                            <td v-text="horario.periodo" align="center"></td>
                                            <td v-text="horario.descripcion"></td>
                                            <td align="center">
                                                <div v-if="horario.condicion"><span class="badge badge-success">Activo</span></div>
                                                <div v-else><span class="badge badge-secondary">Inactivo</span></div>                                    
                                            </td>
                                            <td align="center">
                                                <a class="btn btn-sm btn-default" @click="abrirModal('horario','actualizar',horario)"><i class="fas fa-edit" title="Editar"></i></a>                                   
                                                <template v-if="horario.condicion">
                                                    <a class="btn btn-sm btn-default" @click="desactivarHorario(horario.id)"><i class="fas fa-ban" title="Desactivar"></i></a>
                                                </template>
                                                <template v-else>
                                                    <a class="btn btn-sm btn-default" @click="activarHorario(horario.id)"><i class="fas fa-sync" title="Actualizar"></i></a>
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
                                <div class="input-group input-group-sm mb-3 col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Desde: </span>
                                    </div>
                                    <input type="time" v-model="hora_ini" class="form-control" v-bind:class="{ 'is-invalid': e_hora_ini }">
                                </div>
                                <div class="input-group input-group-sm mb-3 col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Hasta: </span>
                                    </div>
                                    <input type="time" v-model="hora_fin" class="form-control" v-bind:class="{ 'is-invalid': e_hora_fin }"> 
                                </div>                                
                            </div>
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-3 col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Turno: </span>
                                    </div>
                                    <select v-model="periodo" class="form-control" v-bind:class="{ 'is-invalid': e_periodo }">
                                        <option value="0" disabled>--Turno--</option>
                                        <option value="Mañana">Mañana</option>
                                        <option value="Tarde">Tarde</option>
                                        <option value="Noche">Noche</option>                                            
                                    </select>
                                </div>
                                <div class="input-group input-group-sm mb-3 col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Locales: </span>
                                    </div>
                                    <select class="form-control" v-bind:class="{ 'is-invalid': e_idlocal }" v-model="idlocal">
                                        <option value="0" disabled>--Local--</option>
                                        <option v-for="local in arrayLocal" :key="local.id" :value="local.id" v-text="local.nombre"></option>
                                    </select>
                                </div>                                
                            </div>
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-3 col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text">Descripción: </span>
                                    </div>
                                    <textarea  v-model="descripcion" class="form-control" rows="2" maxlength="60"></textarea>
                                </div>                                                            
                            </div>                                                                   

                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-info btn-sm" @click="registrarHorario()">Guardar</button>                        
                        <button type="button" v-if="tipoAccion==2" class="btn btn-success btn-sm" @click="actualizarHorario()">Actualizar</button>  
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
                horario_id: 0,
                idlocal: 0,
                hora_ini : '00:00',
                hora_fin : '00:00',
                periodo : 0,
                descripcion : '',
                arrayHorario : [],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,

                arrayLocal : [],

                errorHorario : 0,
                errorMostrarMsjHorario : [],
                
                e_idlocal : false,
                e_hora_ini : false,
                e_hora_fin : false,
                e_periodo : false,

                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'periodo',
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
            listarHorario (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/horario?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayHorario = respuesta.horarios.data;
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
                me.listarHorario(page,buscar,criterio,paginado,ordenado,ascdesc);
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
            registrarHorario(){
               if (this.validarHorario()){ return; }
                let me = this;

                axios.post('/horario/registrar',{
                    'idlocal': this.idlocal,
                    'hora_ini': this.hora_ini, 
                    'hora_fin': this.hora_fin,
                    'periodo': this.periodo,
                    'descripcion': this.descripcion
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarHorario(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                });
            }, 
            actualizarHorario(){
               if (this.validarHorario()){ return; }
                let me = this;

                axios.put('/horario/actualizar',{
                    'idlocal': this.idlocal,
                    'hora_ini': this.hora_ini,
                    'hora_fin': this.hora_fin,
                    'periodo': this.periodo,
                    'descripcion': this.descripcion,
                    'id': this.horario_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarHorario(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },            
            desactivarHorario(id){
               Swal.fire({
                title: 'Desactivar el horario?',
                text: "Puede activarla nuevamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, desactivarlo'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/horario/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarHorario(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc);
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
            activarHorario(id){
               Swal.fire({
                title: 'Activar el horario?',
                text: "Puede desactivarla nuevamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, activarlo'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/horario/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarHorario(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc);
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
            validarHorario(){
                this.errorHorario=0;
                this.errorMostrarMsjHorario =[];

                if (!this.idlocal) {this.e_idlocal = true; this.errorMostrarMsjHorario.push('idlocal');}else{this.e_idlocal = false}
                if (!this.hora_ini) {this.e_hora_ini = true; this.errorMostrarMsjHorario.push('hora_ini');}else{this.e_hora_ini = false}
                if (!this.hora_fin) {this.e_hora_fin = true; this.errorMostrarMsjHorario.push('hora_fin');}else{this.e_hora_fin = false}
                if (this.periodo == 0) {this.e_periodo = true; this.errorMostrarMsjHorario.push('periodo');}else{this.e_periodo = false}

                if (this.errorMostrarMsjHorario.length) this.errorHorario = 1;

                return this.errorHorario;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';

                this.errorHorario=0;
                this.errorMostrarMsjHorario = [];
                this.e_idlocal = false;
                this.e_hora_ini = false;
                this.e_hora_fin = false;
                this.e_periodo = false;
                
                this.idlocal= 0;
                this.hora_ini= '00:00';
                this.hora_fin='00:00';
                this.periodo=0;
                this.descripcion='';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "horario":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Horario';
                                this.idlocal= 0;
                                this.hora_ini= '00:00';
                                this.hora_fin = '00:00';
                                this.periodo = 0;
                                this.descripcion='';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Horario';
                                this.tipoAccion=2;
                                this.horario_id=data['id'];
                                this.idlocal = data['idlocal'];
                                this.hora_ini = data['hora_ini'];
                                this.hora_fin = data['hora_fin'];
                                this.periodo = data['periodo'];
                                this.descripcion= data['descripcion'];
                                break;
                            }                            
                        }
                    }
                }
                this.selectLocal();
            },
            ceroBusqueda(){
                this.buscar='';
                this.listarHorario(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
            }
        },
        mounted() {
            this.listarHorario(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>