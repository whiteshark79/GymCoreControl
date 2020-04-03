<template>

    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Alumnos</h3></div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary" @click="abrirModal('persona','registrar')"><i class="icon-plus">  Nuevo Alumno</i></button>
                            </div>
                        </div>                      

                        <div class="card-body">                            
                            <div class="form-group row justify-content-between">
                                <div class="row col-sm-12 col-md-12">

                                    <div class="input-group input-group-sm col-sm-11 col-md-11">                                
                                        <select class="form-control col-sm-3 col-md-2" v-model="criterio" @change="ceroBusqueda();">
                                            <option value="nombre">Nombre</option>
                                            <option value="num_documento">Documento</option>
                                            <option value="fec_nacimiento">Cumpleaños</option>
                                        </select>
                                        <template v-if="criterio=='num_documento'">
                                            <input type="number" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control col-sm-3 col-md-3" placeholder="No. de cédula">
                                        </template>
                                        <template v-else-if="criterio=='fec_nacimiento'">
                                            <input type="date" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control col-sm-3 col-md-3">
                                        </template>
                                        <template v-else>
                                            <input type="text" v-model="buscar" @keyup.enter="listarPersona(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control col-sm-3 col-md-3" placeholder="Texto a buscar">
                                        </template>
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
                                            <th scope="col" width="27%">NOMBRE
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'asc') || (ordenado === 'nombre' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'nombre','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'desc') || (ordenado === 'nombre' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'nombre','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>                                                                                       
                                            <th scope="col" width="10%">CUMPLEAÑOS
                                                <template v-if="(ordenado !== 'fec_nacimiento' && ascdesc === 'asc') || (ordenado === 'fec_nacimiento' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'fec_nacimiento','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'fec_nacimiento' && ascdesc === 'desc') || (ordenado === 'fec_nacimiento' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'fec_nacimiento','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th scope="col" width="15%">CELULAR</th>
                                            <th scope="col" width="28%">EMAIL</th>              
                                            <th scope="col" width="10%">ACCIONES</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayPersona.length">
                                        <tr v-for="persona in arrayPersona" :key="persona.id">
                                            <td align="center" v-text="persona.num_documento" scope="row" data-label="DOC"></td>
                                            <td v-text="persona.nombre" data-label="NOMBRE"></td>
                                            <td align="center" v-text="persona.fec_nacimiento" data-label="CUMPLEAÑOS"></td>
                                            <td v-text="persona.celular" data-label="CELULAR"></td>
                                            <td v-text="persona.email" data-label="EMAIL"></td>
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
            <div class="modal-dialog modal-primary modal-lg modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title text-title" v-text="tituloModal"></span>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="accordion" id="dtAccordion">
                                <div class="card">
                                    <div class="card-header" id="datosGenerales">                                        
                                        <button class="btn btn-link btn-sm" type="button" data-toggle="collapse" data-target="#c1" aria-expanded="true" aria-controls="c1">
                                        Datos Generales
                                        </button>                                        
                                    </div>
                                    <div id="c1" class="collapse show" aria-labelledby="datosGenerales" data-parent="#dtAccordion">
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="form-group col-md-8">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="far fa-id-card"></i></span>
                                                        <select v-model="tipo_documento" class="form-control col-4">
                                                            <option value="0" disabled>--Doc--</option>
                                                            <option value="C">Cédula</option>
                                                            <option value="R">RUC</option>
                                                            <option value="P">Pasaporte</option>                                            
                                                        </select>
                                                        <input type="text" v-model="num_documento" id="num_documento" class="form-control col-8" v-bind:class="{ 'is-invalid': e_num_documento }" @change="existePersonaId()" placeholder="Número de documento">
                                                        <input type="hidden" :value="num_documento" id="ci">                                                                                                     
                                                    </div>
                                                    <span class="text-error" v-show="stsPersonaId">No de documento ya existe</span>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-user-lock"></i></span>
                                                        <input type="text" v-model="usuario" id="usuario" class="form-control" v-bind:class="{ 'is-invalid': e_usuario }" @change="existeUsuario()" placeholder="Usuario">
                                                        <input type="hidden" :value="usuario" id="user">
                                                    </div>    
                                                    <span class="text-error" v-show="stsUsuarioUser">Usuario ya existe</span>                                     
                                                </div>                                                
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-8">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fa fa-user"></i></span>
                                                        <input type="text" v-model="nombre" id="nombre" class="form-control" v-bind:class="{ 'is-invalid': e_nombre }" placeholder="Nombre y Apellido">
                                                    </div>                                        
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-restroom"></i></span>
                                                        <select v-model="sexo" class="form-control" v-bind:class="{ 'is-invalid': e_sexo }">
                                                            <option value="0" disabled>--Sexo--</option>
                                                            <option value="H">Hombre</option>
                                                            <option value="M">Mujer</option>                                       
                                                        </select>
                                                    </div>                                        
                                                </div>                                                                                                         
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-5">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fa fa-calendar-alt"></i></span>
                                                        <input type="date" v-model="fec_nacimiento" class="form-control" v-bind:class="{ 'is-invalid': e_fec_nacimiento }">
                                                    </div>                                        
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fa fa-tag"></i></span>
                                                        <select v-model="estado_civil" class="form-control col-9">
                                                            <option value="0" disabled>--Estado Civil--</option>
                                                            <option value="S">Soltero/a</option>
                                                            <option value="U">Unión de Hecho</option>
                                                            <option value="C">Casado/a</option>
                                                            <option value="D">Divorciado/a</option>
                                                            <option value="V">Viudo/a</option>                                        
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-3">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-baby"></i></span>
                                                        <select v-model="hijos" class="form-control">
                                                            <option value="0" disabled>--Hijos--</option>
                                                            <option value="S">Si</option>
                                                            <option value="N">No</option>                                       
                                                        </select>
                                                    </div>                                      
                                                </div>                                                                                                         
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fa fa-mobile-alt"></i></span>
                                                        <input type="text" v-model="celular" id="celular" class="form-control" v-bind:class="{ 'is-invalid': e_celular }" placeholder="Celular">
                                                    </div>                                        
                                                </div>
                                                <div class="form-group col-md-6">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fa fa-envelope"></i></span>
                                                        <input type="text" v-model="email" id="email" class="form-control" v-bind:class="{ 'is-invalid': e_email }" @change="existePersonaEmail()" placeholder="Email">
                                                        <input type="hidden" :value="email" id="mail">                                                   
                                                    </div>   
                                                    <span class="text-error" v-show="stsPersonaEmail">Correo ya existe</span>                                     
                                                </div>                                                                                                         
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-9">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-home"></i></span>
                                                        <input type="text" maxlength="60" v-model="direccion" class="form-control col-10" placeholder="Dirección">
                                                        <select v-model="sector" class="form-control col-3">
                                                            <option value="0" disabled>--Sector--</option>
                                                            <option value="N">Norte</option>
                                                            <option value="C">Centro</option>
                                                            <option value="S">Sur</option>                                            
                                                        </select>
                                                    </div>                                        
                                                </div>    
                                                <div class="form-group col-md-3">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-store-alt"></i></span>
                                                        <select class="form-control" v-model="idlocal">   
                                                            <option value="0" disabled>--Local--</option>                                                             
                                                            <option v-for="local in arrayLocal" :key="local.id" :value="local.id" v-text="local.nombre"></option>
                                                        </select>
                                                    </div>                                        
                                                </div>                                                                                                                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="datosLaborales">                                        
                                        <button class="btn btn-link collapsed  btn-sm" type="button" data-toggle="collapse" data-target="#c2" aria-expanded="false" aria-controls="c2">
                                        Datos Laborales
                                        </button>                                      
                                    </div>
                                    <div id="c2" class="collapse" aria-labelledby="datosLaborales" data-parent="#dtAccordion">
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-briefcase"></i></span>
                                                        <select class="form-control col-8" v-model="idprofesion">                                                                
                                                                <option v-for="profesion in arrayProfesion" :key="profesion.id" :value="profesion.id" v-text="profesion.nombre"></option>
                                                        </select>
                                                        <select v-model="sit_laboral" class="form-control">
                                                            <option value="0" disabled>--Sit. Laboral--</option>
                                                            <option value="E">Empresario</option>
                                                            <option value="D">Dependiente</option>
                                                            <option value="I">Independiente</option>
                                                            <option value="P">Desempleado</option>                                           
                                                        </select>
                                                    </div>
                                                </div>                                                                                               
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-12">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-building"></i></span>
                                                        <input type="text" maxlength="60" v-model="empresa" class="form-control" placeholder="Nombre Empresa">
                                                        <input type="text" maxlength="30" v-model="cargo" class="form-control" placeholder="Cargo">
                                                    </div>
                                                </div>                                                                                               
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-user-graduate"></i></span>
                                                        <select v-model="estudiante" class="form-control">
                                                            <option value="0" disabled>--Estudiante--</option>
                                                            <option value="S">Si</option>
                                                            <option value="N">No</option>                                       
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-8">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-university"></i></span>
                                                        <select class="form-control" v-model="iduniversidad">
                                                            <option v-for="universidad in arrayUniversidad" :key="universidad.id" :value="universidad.id" v-text="universidad.nombre"></option>
                                                        </select>
                                                    </div>
                                                </div>                                                                                              
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-header" id="datosFisicos">
                                        <button class="btn btn-link collapsed  btn-sm" type="button" data-toggle="collapse" data-target="#c3" aria-expanded="false" aria-controls="c3">
                                        Datos Físicos
                                        </button>                                      
                                    </div>
                                    <div id="c3" class="collapse" aria-labelledby="datosFisicos" data-parent="#dtAccordion">
                                        <div class="card-body">
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-birthday-cake"></i></span>
                                                        <input type="number" step="1" min="4" max="80" v-model="edad" class="form-control" placeholder="Edad">                                                        
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-weight fa-lg"></i></span>
                                                        <input type="number" min="60" max="300" v-model="peso" class="form-control"  placeholder="Peso (lbs.)">
                                                    </div>                                        
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-arrows-alt-v"></i></span>
                                                        <input type="number" min="100" max="200" v-model="estatura" class="form-control"  placeholder="Estatura (cms.)">                                                      
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="form-row">
                                                <div class="form-group col-md-4">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-heartbeat"></i></span>
                                                        <select v-model="nivel_actividad" class="form-control">
                                                            <option value="0" disabled>--Nivel de Actividad--</option>
                                                            <option value="S">Sedentarismo/a</option>
                                                            <option value="PA">Poco activo</option>
                                                            <option value="A">Activo</option>
                                                            <option value="MA">Muy activo</option>                                      
                                                        </select>                                                     
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-walking"></i></span>
                                                        <select v-model="tipo_actividad" class="form-control">
                                                            <option value="0" disabled>--Tipo de Actividad--</option>
                                                            <option value="NA">No aplica</option>
                                                            <option value="C">Caminar</option>
                                                            <option value="G">Gimnasio</option>
                                                            <option value="CF">Crossfit</option>
                                                            <option value="AM">Artes Marciales</option>                                          
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="form-group col-md-4">
                                                    <div class="input-group input-group-sm">
                                                        <span class="input-group-text"><i class="fas fa-bullseye"></i></span>
                                                        <select v-model="objetivo" class="form-control">
                                                            <option value="0" disabled>--Objetivo--</option>
                                                            <option value="BP">Bajar de peso</option>
                                                            <option value="FR">Fuerza-Resistencia</option>
                                                            <option value="DP">Defensa Personal</option>
                                                            <option value="C">Competir</option>
                                                            <option value="T">Terapia</option>
                                                            <option value="RL">Recuperación Lesión</option>                                         
                                                        </select>
                                                    </div>
                                                </div>                                                                                             
                                            </div>
                                        </div>
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
                tipo_documento : 'C',
                num_documento : '',                
                nombre : '',
                fec_nacimiento : '',                
                direccion : '',
                celular : '',
                email : '',
                usuario : '',
                sexo : 0,
                estado_civil : 0,
                hijos : 0,
                sector : 0,
                idlocal : 0,
                idprofesion : 1,
                sit_laboral : 0,
                empresa : '',
                cargo : '',
                estudiante : 0,
                iduniversidad : 1,
                edad : '',
                peso : '',
                estatura : '',
                nivel_actividad : 0,
                tipo_actividad : 0,
                objetivo : 0,

                arrayPersona : [],
                arrayProfesion: [],
                arrayUniversidad: [],
                arrayLocal: [],

                stsPersona : '',
                stsPersonaId : '',
                stsPersonaEmail : '',
                stsUsuarioUser : '',

                modal : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorPersona : 0,
                errorMostrarMsjPersona : [],                
                e_num_documento : false,
                e_nombre : false,
                e_usuario : false,
                e_sexo : false,
                e_fec_nacimiento : false,
                e_celular : false,
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
            validarInput(){                
                Inputmask("99-99999999").mask(num_documento);
                Inputmask("a{5,15}").mask(usuario);
                Inputmask("Aa{3,15} Aa{3,15}").mask(nombre);                              
                Inputmask("099-999-9999").mask(celular);
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

            },         
            listarPersona (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/alumno?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
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
            selectProfesion(){
                let me=this;
                var url= '/profesion/selectProfesion';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayProfesion = respuesta.profesiones;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectUniversidad(){
                let me=this;
                var url= '/universidad/selectUniversidad';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayUniversidad = respuesta.universidades;
                })
                .catch(function (error) {
                    console.log(error);
                });
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
            existeUsuario(){
                let me=this;

                me.user=document.getElementById('user').value;
                
                var url= '/user/selectUsuario?usuario='+me.user;
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.stsUsuarioUser = respuesta.stsUsuarioUser;   
                    me.habilitarGuardar();            
                })                
                .catch(function (error) {
                    console.log(error);
                });                     
            },
            habilitarGuardar(){
                let me=this;
                if(me.stsPersonaId || me.stsPersonaEmail || me.stsUsuarioUser)
                {
                    me.stsPersona=1;
                }else{
                    me.stsPersona='';
                    }
            },
            registrarPersona(){
               if (this.validarPersona()){ return; }
                let me = this;

                axios.post('/alumno/registrar',{ 
                    'tipo_documento' : this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'nombre' : this.nombre,
                    'fec_nacimiento' : this.fec_nacimiento,                    
                    'direccion' : this.direccion,                  
                    'celular' : this.celular,
                    'email' : this.email,
                    'usuario' : this.usuario,
                    'sexo' : this.sexo,
                    'estado_civil' : this.estado_civil,
                    'hijos' : this.hijos,
                    'sector' : this.sector,
                    'idlocal' : this.idlocal,
                    'idprofesion' : this.idprofesion,
                    'sit_laboral' : this.sit_laboral,
                    'empresa' : this.empresa,
                    'cargo' : this.cargo,
                    'estudiante' : this.estudiante,
                    'iduniversidad' : this.iduniversidad,
                    'edad' : this.edad,
                    'peso' : this.peso,
                    'estatura' : this.estatura,
                    'nivel_actividad' : this.nivel_actividad,
                    'tipo_actividad' : this.tipo_actividad,
                    'objetivo' : this.objetivo
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

                axios.put('/alumno/actualizar',{
                    'tipo_documento' : this.tipo_documento,
                    'num_documento' : this.num_documento,
                    'nombre' : this.nombre,
                    'fec_nacimiento' : this.fec_nacimiento,                    
                    'direccion' : this.direccion,                  
                    'celular' : this.celular,
                    'email' : this.email,
                    'usuario' : this.usuario,
                    'sexo' : this.sexo,
                    'estado_civil' : this.estado_civil,
                    'hijos' : this.hijos,
                    'sector' : this.sector,
                    'idlocal' : this.idlocal,
                    'idprofesion' : this.idprofesion,
                    'sit_laboral' : this.sit_laboral,
                    'empresa' : this.empresa,
                    'cargo' : this.cargo,
                    'estudiante' : this.estudiante,
                    'iduniversidad' : this.iduniversidad,
                    'edad' : this.edad,
                    'peso' : this.peso,
                    'estatura' : this.estatura,
                    'nivel_actividad' : this.nivel_actividad,
                    'tipo_actividad' : this.tipo_actividad,
                    'objetivo' : this.objetivo,
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
                if (!this.usuario) {this.e_usuario = true; this.errorMostrarMsjPersona.push('usuario');}else{this.e_usuario = false}
                if (!this.sexo) {this.e_sexo = true; this.errorMostrarMsjPersona.push('sexo');}else{this.e_sexo = false}
                if (!this.fec_nacimiento) {this.e_fec_nacimiento = true; this.errorMostrarMsjPersona.push('fec_nacimiento');}else{this.e_fec_nacimiento = false}
                if (!this.celular) {this.e_celular = true; this.errorMostrarMsjPersona.push('celular');}else{this.e_celular = false}
                if (!this.email) {this.e_email = true; this.errorMostrarMsjPersona.push('email');}else{this.e_email = false}

                 if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;
                 return this.errorPersona;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';

                this.errorPersona = 0;
                this.errorMostrarMsjPersona = []; 
                 
                this.stsPersona = '';
                this.stsPersonaId = '';
                this.stsPersonaEmail = '';
                this.stsUsuarioUser = '';

                this.e_num_documento = false;
                this.e_nombre = false;
                this.e_sexo = false;
                this.e_fec_nacimiento = false;
                this.e_celular = false;
                this.e_email = false;
                
                this.tipo_documento = 'C';
                this.num_documento = '';
                this.nombre = '';
                this.fec_nacimiento = '';
                this.direccion = '';                
                this.celular = '';
                this.email = '';
                this.usuario = '';                
                this.sexo = 0;
                this.estado_civil = 0;
                this.hijos = 0;
                this.sector = 0;
                this.idprofesion = 1;
                this.sit_laboral = 0;
                this.empresa = '';
                this.cargo = '';
                this.estudiante = 0;
                this.iduniversidad = 1;
                this.edad = '';
                this.peso = '';
                this.estatura = '';
                this.nivel_actividad = 0;
                this.tipo_actividad = 0;
                this.objetivo = 0;                
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "persona":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Alumno';
                                this.tipoAccion = 1;
                                
                                this.tipo_documento = 'C';
                                this.num_documento = '';
                                this.nombre = '';
                                this.fec_nacimiento = '';
                                this.direccion = '';                
                                this.celular = '';
                                this.email = '';
                                this.usuario = '';                
                                this.sexo = 0;
                                this.estado_civil = 0;
                                this.hijos = 0;
                                this.sector = 0;
                                this.idlocal = 0;
                                this.idprofesion = 1;
                                this.sit_laboral = 0;
                                this.empresa = '';
                                this.cargo = '';
                                this.estudiante = 0;
                                this.iduniversidad = 1;
                                this.edad = '';
                                this.peso = '';
                                this.estatura = '';
                                this.nivel_actividad = 0;
                                this.tipo_actividad = 0;
                                this.objetivo = 0;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Alumno';
                                this.tipoAccion=2;

                                this.persona_id=data['id'];
                                this.tipo_documento=data['tipo_documento'];
                                this.num_documento=data['num_documento'];                                
                                this.nombre = data['nombre'];
                                this.fec_nacimiento = data['fec_nacimiento'];                               
                                this.direccion= data['direccion'];
                                this.celular= data['celular'];
                                this.email= data['email'];
                                this.usuario=data['usuario'];
                                this.sexo= data['sexo'];
                                this.sector= data['sector'];
                                this.idlocal= data['idlocal'];
                                this.estado_civil= data['estado_civil'];
                                this.hijos= data['hijos'];
                                this.idprofesion= data['idprofesion'];
                                this.sit_laboral= data['sit_laboral'];
                                this.empresa= data['empresa'];
                                this.cargo= data['cargo'];
                                this.estudiante= data['estudiante'];
                                this.iduniversidad= data['iduniversidad'];
                                this.edad= data['edad'];
                                this.peso= data['peso'];
                                this.estatura= data['estatura'];
                                this.nivel_actividad= data['nivel_actividad'];
                                this.tipo_actividad= data['tipo_actividad'];
                                this.objetivo= data['objetivo'];
                                break;
                            }
                        }
                    }
                }
                this.selectProfesion();
                this.selectUniversidad();
                this.selectLocal();
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