<template> 
  <main class="main">
    <div class="container-fluid p-0">      

      <!--====================================================
                      ABOUT
      ======================================================-->
      <section class="resume-section p-3 p-lg-5 d-flex d-column" id="about">        

          <div class="mp-auto col-sm-6 col-md-5" > 

                   
              
              <h1 class="mb-0">{{nombre}} <span class="text-primary">{{apellido}}</span></h1>
              <div class="text-cursiva">            
                  <p class="mb-0">{{f_descripcion}}</p>
                  <footer class="blockquote-footer">{{f_autor}}</footer>  
              </div>
              <br>
              <div class="card-header">
                <div class="card-title"><h5><i class="far fa-id-card mr-1"></i> Datos Generales</h5></div>                
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm" v-if="stsDatos==0" @click="activarDatos()"><i class="fas fa-edit fa-lg"></i></button> 
                  <button type="button" class="btn btn-success btn-sm" v-if="stsDatos==1" @click="actualizarAlumno()" :disabled="stsPersona!=''"><i class="fas fa-save fa-lg"></i></button>  
                </div>
              </div>          
              <div class="row">                                        
                <div class="profile-user-info">                
                    <div class="profile-info-row">
                        <div class="profile-info-name">Usuario </div>
                        <div class="profile-info-value"><span>{{usuario}}</span></div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Local </div>
                        <div class="profile-info-value"><i class="fas fa-store-alt"></i><span> {{local}}</span></div>
                    </div>
                    <div class="profile-info-row">
                      <div class="profile-info-name">C.I. </div>
                      <div class="profile-info-value">
                        <input type="number" v-model="num_documento" class="form-control form-control-sm" v-bind:class="{ 'is-invalid': e_num_documento }" placeholder="Número de documento" @change="existePersonaId()" :disabled="stsDatos == 0">
                        <input type="hidden" v-model="num_documento_">
                        <span class="text-error" v-show="stsPersonaId">No de documento ya existe</span>
                      </div>                  
                    </div>                
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Cumpleaños </div>
                        <div class="profile-info-value">
                          <input type="date" v-model="fec_nacimiento" class="form-control form-control-sm" v-bind:class="{ 'is-invalid': e_fec_nacimiento }" :disabled="stsDatos == 0">
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Correo </div>
                        <div class="profile-info-value">
                          <input type="email" v-model="email" class="form-control form-control-sm" v-bind:class="{ 'is-invalid': e_email }" placeholder="Email" @change="existePersonaEmail()"  :disabled="stsDatos == 0"> 
                          <input type="hidden" v-model="email_">
                          <span class="text-error" v-show="stsPersonaEmail">Correo ya existe</span>
                        </div>                    
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Celular </div>
                        <div class="profile-info-value">
                          <input type="number" v-model="celular" class="form-control form-control-sm" v-bind:class="{ 'is-invalid': e_celular }" placeholder="Celular" :disabled="stsDatos == 0">
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-name"> Dirección </div>
                        <div class="profile-info-value">
                          <textarea  v-model="direccion" class="form-control form-control-sm" v-bind:class="{ 'is-invalid': e_direccion }" rows="2" maxlength="60" :disabled="stsDatos == 0"></textarea>
                        </div>
                    </div>
                                      
                </div>    
              </div> 

          </div>     
       
          
      </section>

      <!--====================================================
                        LABORAL
      ======================================================-->      
      <section class="resume-section p-3 p-lg-5 " id="laboral">
        <div class="row mp-auto">
          <div class="col-12">
            <h2 class="text-center">LABORAL</h2>
            <div class="mb-5 heading-border"></div>
          </div>
          <div class="resume-item col-md-12 col-sm-12" > 
            <div class="card mx-0 p-4 mb-5" style="border-color: #17a2b8; box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.21);">
              
              <div class="card-header">
                <div class="card-title"><h5><i class="fas fa-briefcase mr-1"></i>Datos Laborales</h5></div>                
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm" v-if="stsLaboral==0" @click="activarLaboral()"><i class="fas fa-edit fa-lg"></i></button>                   
                  <button type="button" class="btn btn-success btn-sm" v-if="stsLaboral==1" @click="actualizarAlumnoLaboral()"><i class="fas fa-save fa-lg"></i></button>                                   
                </div>
              </div>
              <div class="row">
                <div class="col-md-6">   
                  <div class="profile-user-info">
                    <div class="profile-info-row">
                      <div class="profile-info-field">Estudiante </div>
                      <div class="profile-info-value">
                        <select v-model="estudiante" class="form-control form-control-sm" :disabled="stsLaboral == 0">
                          <option value="0" disabled>--Estudiante--</option>
                          <option value="S">Si</option>
                          <option value="N">No</option>                                       
                        </select>
                      </div>
                    </div>
                    <div class="profile-info-row">
                      <div class="profile-info-field">Universidad </div>
                      <div class="profile-info-value">
                        <select class="form-control form-control-sm " v-model="idprovincia" :disabled="stsLaboral == 0" @change="selectUniversidadId()" @click="activarUniversidad()">
                          <option v-for="provincia in arrayProvincia" :key="provincia.id" :value="provincia.id" v-text="provincia.nombre"></option>
                        </select>
                        <br>
                        <select class="form-control form-control-sm " v-model="iduniversidad" :disabled="stsLaboral_ == 0">
                            <option v-for="universidad in arrayUniversidad" :key="universidad.id" :value="universidad.id" v-text="universidad.nombre"></option>
                        </select>
                      </div>
                    </div>
                    <div class="profile-info-row">
                      <div class="profile-info-field"> Profesión </div>
                      <div class="profile-info-value">
                        <select class="form-control form-control-sm " v-model="idprofesion" :disabled="stsLaboral == 0">                                                                
                          <option v-for="profesion in arrayProfesion" :key="profesion.id" :value="profesion.id" v-text="profesion.nombre" ></option>
                        </select>
                      </div>
                    </div>                      
                  </div>  
                </div>
                <div class="col-md-6">
                  <div class="profile-user-info">
                    <div class="profile-info-row">
                      <div class="profile-info-field">Situación Laboral </div>
                      <div class="profile-info-value">
                        <select v-model="sit_laboral" class="form-control form-control-sm " :disabled="stsLaboral == 0">
                          <option value="0" disabled>--Sit. Laboral--</option>
                          <option value="E">Empresario</option>
                          <option value="D">Dependiente</option>
                          <option value="I">Independiente</option>
                          <option value="P">Desempleado</option>                                           
                        </select>
                      </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-field">Empresa </div>
                        <div class="profile-info-value">
                          <input type="text" maxlength="60" v-model="empresa" class="form-control form-control-sm" placeholder="Nombre Empresa" :disabled="stsLaboral == 0">
                        </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-field"> Cargo </div>
                        <div class="profile-info-value">
                          <input type="text" maxlength="30" v-model="cargo" class="form-control form-control-sm" placeholder="Cargo" :disabled="stsLaboral == 0">
                        </div>
                    </div>                      
                  </div>
                </div>
              </div>     
            </div>  
          </div>
        </div>
      </section>

      <!--====================================================
                        FISICO
      ======================================================-->      
      <section class="resume-section p-3 p-lg-5 " id="fisico">
        <div class="row mp-auto">
          <div class="col-12">
            <h2 class="text-center">FISICO</h2>
            <div class="mb-5 heading-border"></div>
          </div>
          <div class="resume-item col-md-12 col-sm-12" > 
            <div class="card mx-0 p-4 mb-5" style="border-color: #17a2b8; box-shadow: 2px 2px 2px rgba(0, 0, 0, 0.21);">
              
              <div class="card-header">
                <div class="card-title"><h5><i class="fas fa-walking mr-1"></i>Datos Físicos</h5></div>                
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm" v-if="stsFisico==0" @click="activarFisico()"><i class="fas fa-edit fa-lg"></i></button>
                  <button type="button" class="btn btn-success btn-sm" v-if="stsFisico==1" @click="actualizarAlumnoFisico()"><i class="fas fa-save fa-lg"></i></button>                                                                     
                </div>
              </div>
              <div class="row">
                <div class="col-md-4">   
                  <div class="profile-user-info">
                    <div class="profile-info-row">
                      <div class="profile-info-field">Edad </div>
                      <div class="profile-info-value">
                        <input type="number" min="8" max="80" v-model="edad" class="form-control form-control-sm" placeholder="Edad" :disabled="stsFisico == 0">
                      </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-field">Activo? </div>
                        <div class="profile-info-value">
                          <select v-model="nivel_actividad" class="form-control form-control-sm" :disabled="stsFisico == 0">
                            <option value="0" disabled>--Nivel de Actividad--</option>
                            <option value="S">Sedentarismo/a</option>
                            <option value="PA">Poco activo</option>
                            <option value="A">Activo</option>
                            <option value="MA">Muy activo</option>                                      
                          </select>
                        </div>
                    </div>                                          
                  </div> 
                </div>
                <div class="col-md-4"> 
                  <div class="profile-user-info">
                    <div class="profile-info-row">
                      <div class="profile-info-field">Peso <small>(lbs.)</small></div>
                      <div class="profile-info-value">
                        <input type="number" min="60" max="300" v-model="peso" class="form-control form-control-sm"  placeholder="Peso (lbs.)" :disabled="stsFisico == 0">
                      </div>
                    </div>
                    <div class="profile-info-row">
                        <div class="profile-info-field">Ejercicios? </div>
                        <div class="profile-info-value">
                          <select v-model="tipo_actividad" class="form-control form-control-sm" :disabled="stsFisico == 0">
                            <option value="0" disabled>--Tipo de Actividad--</option>
                            <option value="NA">No aplica</option>
                            <option value="C">Caminar</option>
                            <option value="G">Gimnasio</option>
                            <option value="CF">Crossfit</option>
                            <option value="AM">Artes Marciales</option>                                          
                          </select>
                        </div>
                    </div>                                        
                  </div>   
                </div>
                <div class="col-md-4"> 
                  <div class="profile-user-info">
                    <div class="profile-info-row">
                      <div class="profile-info-field">Estatura <small>(cms.)</small></div>
                      <div class="profile-info-value">
                        <input type="number" min="100" max="200" v-model="estatura" class="form-control form-control-sm"  placeholder="Estatura (cms.)" :disabled="stsFisico == 0">
                      </div>
                    </div>
                    <div class="profile-info-row">
                      <div class="profile-info-field">Objetivo? </div>
                      <div class="profile-info-value">
                        <select v-model="objetivo" class="form-control form-control-sm" :disabled="stsFisico == 0">
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
        </div>
      </section>


      <!--====================================================
                        INSCRIPCIONES
      ======================================================-->      
      <section class="resume-section p-3 p-lg-5 " id="inscripcion">
        <div class="row mp-auto">
          <div class="col-12">
            <h2 class="text-center">INSCRIPCIONES</h2>
            <div class="mb-5 heading-border"></div>
          </div>
          <div class="resume-item col-md-12 col-sm-12">             
            <div class="card card-primary card-outline">
              <div class="card-header">
                  <div class="card-title"><h5><i class="fas fa-dumbbell mr-1"></i> Inscripciones</h5></div>                            
              </div>  
              <div class="card-body">
                <div class="form-group row justify-content-between">
                  <div class="input-group input-group-sm col-10">                                
                    <select class="form-control col-3 " v-model="criterio" @onchange="ceroBusqueda();">
                      <option value="fecha_ini">Fecha</option>
                      <option value="idmodalidad">Modalidad</option>                                      
                    </select>                                    
                    <template v-if="criterio=='fecha_ini'">
                      <input type="date" v-model="buscar" class="form-control col-4">
                    </template>
                    <template v-else>
                      <select class="form-control col-5" v-model="buscar">
                          <option value="" disabled>--Seleccione--</option>
                          <option v-for="modalidad in arrayModalidad" :key="modalidad.id" :value="modalidad.id" v-text="modalidad.nombre"></option>
                      </select>
                    </template>                                                                          
                    <button type="submit" @click="listarInscripcionesAlumnoId(1,buscar,criterio,paginado)" class="btn btn-primary btn-sm"><i class="icon-magnifier"></i></button>
                    <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="icon-reload"></i> </button>                                
                  </div>                                
                  <div class="input-group input-group-sm col-2">                                     
                    <select class="form-control" v-model="paginado" @change="listarInscripcionesAlumnoId(1,buscar,criterio,paginado)">
                      <option value="10">10</option>
                      <option value="25">25</option>
                      <option value="50">50</option>
                    </select>
                  </div> 
                </div>                            
                <div class="table-responsive-sm table-wrapper-scroll-y my-custom-mini-scrollbar_">
                  <table class="table table-bordered table-sm table-hover" id="dtTable">
                    <thead class="thead-table">
                      <tr align="center">                                                                                                                        
                        <th width="15%">FECHA</th>
                        <th width="15%">FECHA FIN</th>
                        <th width="21%">MODALIDAD</th> 
                        <th width="13%">ABONO</th>
                        <th width="13%">SALDO</th>
                        <th width="13%">TOTAL</th>     
                        <th width="10%">ESTADO</th>
                      </tr>
                    </thead>
                    <tbody v-if="arrayInscripcionesAlumno.length">
                      <tr v-for="inscripcion in arrayInscripcionesAlumno" :key="inscripcion.id">
                        <td align="center" v-text="inscripcion.fecha_ini"></td>                                  
                        <td align="center" v-text="inscripcion.fecha_fin"></td>
                        <td align="right" v-text="inscripcion.modalidad"></td>
                        <td align="right">$ {{inscripcion.abono}}</td>
                        <td align="right">$ {{inscripcion.saldo}}</td>
                        <td align="right">$ {{inscripcion.total}}</td>
                        <td align="center">
                          <div v-if="inscripcion.fecha_fin <= hoyFecha() "><span class="badge badge-danger">Caducado</span></div>
                          <div v-else><span class="badge badge-success">Activo</span></div>                                    
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
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page - 1,buscar,criterio,paginado)">« Ant</a>
                    </li>
                    <li class="page-item" v-for="page in pagesNumber" :key="page" :class="[page == isActived ? 'active' : '']">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(page,buscar,criterio,paginado)" v-text="page"></a>
                    </li>
                    <li class="page-item" v-if="pagination.current_page < pagination.last_page">
                        <a class="page-link" href="#" @click.prevent="cambiarPagina(pagination.current_page + 1,buscar,criterio,paginado)">Sig »</a>
                    </li>
                  </ul>
                </nav>

              </div>
            </div>

          </div>
        </div>
      </section>


      <!--====================================================
                        COMPRAS
      ======================================================-->      
      <section class="resume-section p-3 p-lg-5 " id="compra">
        <div class="row mp-auto">
          <div class="col-12">
            <h2 class="text-center">COMPRAS</h2>
            <div class="mb-5 heading-border"></div>
          </div>
          <div class="resume-item col-md-12 col-sm-12" > 

            <div class="card card-primary card-outline">
              <div class="card-header">
                  <div class="card-title"><h5><i class="fas fa-shopping-basket mr-1"></i> Compras</h5></div>                            
              </div> 
              <div class="card-body">
                <div class="form-group row justify-content-between">
                  <div class="input-group input-group-sm col-10">                                
                    <select class="form-control col-3 " v-model="criterio_" @onchange="ceroBusqueda_();">
                        <option value="fecha_hora">Fecha</option>
                        <option value="estado">Estado</option>                                      
                    </select>                                    
                    <template v-if="criterio_=='fecha_hora'">
                        <input type="date" v-model="buscar_" class="form-control col-4">
                    </template>
                    <template v-else-if="criterio_=='estado'">
                        <select class="form-control col-5" v-model="buscar_">
                            <option value="" disabled>--Seleccione--</option>
                            <option value="Debe">Debe</option>
                            <option value="Cancelado">Cancelado</option>
                        </select>
                    </template>                                                                          
                    <button type="submit" @click="listarVentasCabeceraAlumno(1,buscar_,criterio_,paginado_)" class="btn btn-primary btn-sm"><i class="icon-magnifier"></i></button>
                    <button type="button" @click="ceroBusqueda_();" class="btn btn-info btn-sm ml-1"><i class="icon-reload"></i> </button>                                 
                  </div>
                  <div class="input-group input-group-sm col-2">                                     
                    <select class="form-control" v-model="paginado_" @change="listarVentasCabeceraAlumno(1,buscar_,criterio_,paginado_)">
                      <option value="10">10</option>
                      <option value="25">25</option>
                      <option value="50">50</option>
                    </select>
                  </div> 
                </div>
                <div class="table-responsive-sm table-wrapper-scroll-y my-custom-mini-scrollbar_">
                  <table class="table table-bordered table-sm table-hover" id="dtTable">
                    <thead class="thead-table">
                      <tr align="center">                                                                                                                        
                        <th width="5%">#</th>
                        <th width="35%">FECHA</th>
                        <th width="20%">ABONO</th>
                        <th width="20%">TOTAL</th>  
                        <th width="10%">ESTADO</th>
                        <th width="10%">ACCIONES</th>
                      </tr>
                    </thead>
                    <tbody v-if="arrayVentasCabeceraAlumno.length">
                      <tr v-for="venta in arrayVentasCabeceraAlumno" :key="venta.id"> 
                        <td align="center">{{venta.id}}</td>
                        <td align="center">{{venta.fecha_hora}}</td>
                        <td align="right">$ {{venta.abono}}</td>
                        <td align="right">$ {{venta.total}}</td>
                        <td align="center">
                            <div v-if="venta.estado=='Cancelado'"><span class="badge badge-success">{{venta.estado}}</span></div>
                            <div v-else-if="venta.estado=='Debe'"><span class="badge badge-warning">{{venta.estado}}</span></div>  
                            <div v-else><span class="badge badge-danger">{{venta.estado}}</span></div>                                    
                        </td>
                        <td align="center">
                            <a class="btn btn-sm btn-default" @click="listarVentasDetalleAlumno(venta.id)"><i class="icon-eye"></i></a>  
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
                    <li class="page-item" v-if="pagination_.current_page_ > 1">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina_(pagination_.current_page_ - 1,buscar_,criterio_,paginado_)">« Ant</a>
                    </li>
                    <li class="page-item" v-for="page_ in pagesNumber_" :key="page_" :class="[page_ == isActived_ ? 'active' : '']">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina_(page_,buscar_,criterio_,paginado_)" v-text="page_"></a>
                    </li>
                    <li class="page-item" v-if="pagination_.current_page_ < pagination_.last_page_">
                      <a class="page-link" href="#" @click.prevent="cambiarPagina_(pagination_.current_page_ + 1,buscar_,criterio_,paginado_)">Sig »</a>
                    </li>
                  </ul>
                </nav>

              </div>
            </div>


          </div>
        </div>
      </section>
      
    </div>

<!--Inicio del modal agregar/actualizar-->
    <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
        <div class="modal-dialog modal-primary modal-sm modal-dialog-centered modal-dialog-vertical" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <span class="modal-title text-title" v-text="tituloModal"></span>
                    <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-bordered table-sm table-hover" id="dtTable">
                                <thead class="thead-table">
                                    <tr align="center">
                                        <th width="54%">Artículo</th>
                                        <th width="18%">Qtx</th>
                                        <th width="18%">Precio</th>  
                                        <th width="18%">Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody v-if="arrayVentasDetalleAlumno.length">
                                    <tr v-for="detalle in arrayVentasDetalleAlumno" :key="detalle.id"> 
                                        <td align="left">{{detalle.articulo}}</td>
                                        <td align="right">{{detalle.cantidad}}</td>
                                        <td align="right">$ {{detalle.precio}}</td>
                                        <td align="right">$ {{detalle.subtotal}}</td>                                                                                                                 
                                    </tr>
                                </tbody>                                    
                            </table>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>     
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
          frase_id: '',
          tipo_documento : 'C',
          num_documento : '',   
          num_documento_ : '',              
          nombre : '',
          apellido : '',
          local : '',
          fec_nacimiento : '',                
          direccion : '',
          celular : '',
          email : '',
          email_ : '',    
          
          file: '',

          usuario : '',
          sexo : 0,
          estado_civil : 0,
          hijos : 0,
          sector : 0,
          idlocal : 1,
          idprofesion : 1,
          sit_laboral : 0,
          empresa : '',
          cargo : '',
          estudiante : 0,
          idprovincia : 1,
          iduniversidad : 1,
          edad : '',
          peso : '',
          estatura : '',
          nivel_actividad : 0,
          tipo_actividad : 0,
          objetivo : 0,
          
          arrayProfesion: [],
          arrayUniversidad: [],
          arrayProvincia: [],
          
          arrayFrase: [],
          f_descripcion: '',
          f_autor: '',

          stsPersona : '',
          stsPersonaId : '',
          stsPersonaEmail : '',

          errorPersona : 0,
          errorMostrarMsjPersona : [],                
          e_num_documento : false,
          e_nombre : false,
          e_sexo : false,
          e_fec_nacimiento : false,
          e_celular : false,
          e_email : false,
          e_direccion : false,

          stsDatos : 0,
          stsLaboral : 0,
          stsLaboral_ : 0,
          stsFisico : 0,

          arrayModalidad : [],

          arrayInscripcionesAlumno:[],
          arrayVentasCabeceraAlumno:[],
          arrayVentasDetalleAlumno:[],

          modal : 0,
          tituloModal : '',

          pagination : {
              'total' : 0,
              'current_page' : 0,
              'per_page' : 0,
              'last_page' : 0,
              'from' : 0,
              'to' : 0,
          },
          offset : 3,
          criterio : 'fecha_ini',
          buscar : '',
          paginado : 10,

          pagination_ : {
              'total_' : 0,
              'current_page_' : 0,
              'per_page_' : 0,
              'last_page_' : 0,
              'from_' : 0,
              'to_' : 0,
          },
          offset_ : 3,
          criterio_ : 'fecha_hora',
          buscar_ : '',
          paginado_ : 10

        }
      },
      computed:{
        isActived: function(){
            return this.pagination.current_page;
        },
        isActived_: function(){
            return this.pagination_.current_page_;
        },
        //Calcula los elementos de la paginación
        pagesNumber: function() {
            if(!this.pagination.to) { return []; }      
        
            var from = this.pagination.current_page - this.offset; 
            if(from < 1) { from = 1; }

            var to = from + (this.offset * 2); 
            if(to >= this.pagination.last_page){ to = this.pagination.last_page; }  

            var pagesArray = [];
            while(from <= to) { pagesArray.push(from); from++; }

            return pagesArray;             

        },
        pagesNumber_: function() {
            if(!this.pagination_.to_) { return []; }      
        
            var from_ = this.pagination_.current_page_ - this.offset_; 
            if(from_ < 1) { from_ = 1; }

            var to_ = from_ + (this.offset_ * 2); 
            if(to_ >= this.pagination_.last_page_){ to_ = this.pagination_.last_page_; }  

            var pagesArray_ = [];
            while(from_ <= to_) { pagesArray_.push(from_); from_++; }

            return pagesArray_;             

        }                  
      },
      methods : {    

        activarDatos(){
          this.stsDatos = 1;
        },
        activarLaboral(){
          this.stsLaboral = 1;
        }, 
        activarFisico(){
          this.stsFisico = 1;
        },               
        activarUniversidad(){
          this.stsLaboral_ = 1;
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
        selectUniversidadId(){
          let me=this;

          var url= '/universidad/selectUniversidadId?idprovincia=' + me.idprovincia;
          axios.get(url).then(function (response) {
              //console.log(response);
              var respuesta= response.data;
              me.arrayUniversidad = respuesta.universidadesId;
          })
          .catch(function (error) {
              console.log(error);
          });
        },
        selectFraseId(){
          let me=this;
          var url= '/frase/selectFraseId';
          axios.get(url).then(function (response) {
            //console.log(response);
            var respuesta= response.data;
            me.arrayFrase = respuesta.frases;

            me.arrayFrase.map(function(x){
              me.f_descripcion = x.descripcion;
              me.f_autor = x.autor;
            });
          })
          .catch(function (error) {
              console.log(error);
          });
        },
        verAlumno(){
          let me=this;

          var arrayPersona=[];
          var url= '/alumno/selectAlumnoId';

          axios.get(url).then(function (response) {
            var respuesta= response.data;
            arrayPersona = respuesta.personas;

            me.persona_id=arrayPersona[0]['id'];
            me.tipo_documento=arrayPersona[0]['tipo_documento'];
            me.num_documento=arrayPersona[0]['num_documento'];   
            me.num_documento_=arrayPersona[0]['num_documento'];                               
            me.nombre = arrayPersona[0]['nombre'];
            me.apellido = arrayPersona[0]['apellido'];
            me.fec_nacimiento = arrayPersona[0]['fec_nacimiento'];                               
            me.direccion= arrayPersona[0]['direccion'];
            me.celular= arrayPersona[0]['celular'];
            me.email= arrayPersona[0]['email'];
            me.email_= arrayPersona[0]['email'];
            me.perfil= arrayPersona[0]['perfil'];            

            me.usuario=arrayPersona[0]['usuario'];
            me.avatar= arrayPersona[0]['avatar'];
            me.sexo= arrayPersona[0]['sexo'];
            me.sector= arrayPersona[0]['sector'];
            me.idlocal= arrayPersona[0]['idlocal'];
            me.local= arrayPersona[0]['local'];
            me.estado_civil= arrayPersona[0]['estado_civil'];
            me.hijos= arrayPersona[0]['hijos'];
            me.idprofesion= arrayPersona[0]['idprofesion'];
            me.sit_laboral= arrayPersona[0]['sit_laboral'];
            me.empresa= arrayPersona[0]['empresa'];
            me.cargo= arrayPersona[0]['cargo'];
            me.estudiante= arrayPersona[0]['estudiante'];
            me.idprovincia= arrayPersona[0]['idprovincia'];
            me.iduniversidad= arrayPersona[0]['iduniversidad'];
            me.edad= arrayPersona[0]['edad'];
            me.peso= arrayPersona[0]['peso'];
            me.estatura= arrayPersona[0]['estatura'];
            me.nivel_actividad= arrayPersona[0]['nivel_actividad'];
            me.tipo_actividad= arrayPersona[0]['tipo_actividad'];
            me.objetivo= arrayPersona[0]['objetivo'];
          })
          .catch(function (error) {
              console.log(error);
          });
        },
        existePersonaId(){
          let me=this;    

          if(me.num_documento != me.num_documento_){
            var url= '/cliente/selectPersonaId?num_documento='+me.num_documento;
            axios.get(url).then(function (response) {
              //console.log(response);
              var respuesta= response.data;
              me.stsPersonaId = respuesta.stsPersonaId;      
              me.habilitarGuardar();               
            })                
            .catch(function (error) {
                console.log(error);
            });
          }else{
            me.stsPersona=''; 
            me.stsPersonaId='';
          }           
        },
        existePersonaEmail(){
          let me=this;

          if(me.email != me.email_){
            var url= '/cliente/selectPersonaEmail?email='+this.email;
            axios.get(url).then(function (response) {
              //console.log(response);
              var respuesta= response.data;
              me.stsPersonaEmail = respuesta.stsPersonaEmail;  
              me.habilitarGuardar();                   
            })                
            .catch(function (error) {
                console.log(error);
            });
          }else{
            me.stsPersona=''; 
            me.stsPersonaEmail='';
          }     
        },
        habilitarGuardar(){
          let me=this;
          if(me.stsPersonaId || me.stsPersonaEmail){ me.stsPersona=1;
          }else{ me.stsPersona=''; }
        },         
        actualizarAlumno(){ 
          let me = this;         

          axios.put('/cliente/actualizarAlumno',{
            'num_documento' : this.num_documento,
            'fec_nacimiento' : this.fec_nacimiento, 
            'email' : this.email,                 
            'celular' : this.celular,
            'direccion' : this.direccion,
            'id': this.persona_id
          }).then(function (response) {            
              me.stsDatos = 0;
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '<h5>Registro actualizado</h5>',
                width: 250,
                showConfirmButton: false,
                timer: 1500
              })
            }).catch(function (error) {
                console.log(error);
          });        

        },
        actualizarAlumnoLaboral(){ 
          let me = this;         

          axios.put('/alumno/actualizarAlumnoLaboral',{
            'estudiante' : this.estudiante,
            'iduniversidad' : this.iduniversidad, 
            'idprofesion' : this.idprofesion,                 
            'sit_laboral' : this.sit_laboral,
            'empresa' : this.empresa, 
            'cargo' : this.cargo, 
            'id': this.persona_id
          }).then(function (response) {
              me.stsLaboral = 0;
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '<h5>Registro actualizado</h5>',
                width: 250,
                showConfirmButton: false,
                timer: 1500
              })
            }).catch(function (error) {
                console.log(error);
          }); 

        },
        actualizarAlumnoFisico(){ 
          let me = this;         

          axios.put('/alumno/actualizarAlumnoFisico',{
            'edad' : this.edad,
            'peso' : this.peso, 
            'estatura' : this.estatura,                 
            'nivel_actividad' : this.nivel_actividad,
            'tipo_actividad' : this.tipo_actividad, 
            'objetivo' : this.objetivo, 
            'id': this.persona_id
          }).then(function (response) {
              me.stsFisico = 0;
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '<h5>Registro actualizado</h5>',
                width: 250,
                showConfirmButton: false,
                timer: 1500
              })
            }).catch(function (error) {
                console.log(error);
          }); 

        },
        validarPersona(){
              this.errorPersona=0;
              this.errorMostrarMsjPersona =[];

            if (!this.num_documento) {this.e_num_documento = true; this.errorMostrarMsjPersona.push('num_documento');}else{this.e_num_documento = false}
            if (!this.nombre) {this.e_nombre = true; this.errorMostrarMsjPersona.push('nombre');}else{this.e_nombre = false}
            if (!this.sexo) {this.e_sexo = true; this.errorMostrarMsjPersona.push('sexo');}else{this.e_sexo = false}
            if (!this.fec_nacimiento) {this.e_fec_nacimiento = true; this.errorMostrarMsjPersona.push('fec_nacimiento');}else{this.e_fec_nacimiento = false}
            if (!this.celular) {this.e_celular = true; this.errorMostrarMsjPersona.push('celular');}else{this.e_celular = false}
            if (!this.email) {this.e_email = true; this.errorMostrarMsjPersona.push('email');}else{this.e_email = false}

              if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;
              return this.errorPersona;
        },



        hoyFecha(){
          var hoy = new Date();
          var dd = hoy.getDate();
          var mm = hoy.getMonth()+1;
          var yyyy = hoy.getFullYear();

          if(dd < 10) dd = '0'+dd;
          if(mm < 10) mm = '0'+mm;
  
          return yyyy+'-'+mm+'-'+dd;      
        },      
        selectModalidad(){
          let me=this;
          var url= '/modalidad/selectModalidad';
          axios.get(url).then(function (response) {
              //console.log(response);
              var respuesta= response.data;
              me.arrayModalidad = respuesta.modalidades;
          })
          .catch(function (error) {
              console.log(error);
          });
        },
        listarInscripcionesAlumnoId(page,buscar,criterio,paginado){
          let me=this;
          var url= '/inscripcion/listarInscripcionesAlumnoId?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado;
          axios.get(url).then(function (response) {
              var respuesta= response.data;
              me.arrayInscripcionesAlumno = respuesta.inscripcionesA.data;            
              me.pagination= respuesta.pagination;          
          })
          .catch(function (error) {
              console.log(error);
          });
        },
        cambiarPagina(page,buscar,criterio,paginado){
          let me = this;
          //Actualiza la página actual
          me.pagination.current_page = page;
          //Envia la petición para visualizar la data de esa página
          me.listarInscripcionesAlumnoId(page,buscar,criterio,paginado);
        },
        listarVentasCabeceraAlumno(page_,buscar_,criterio_,paginado_){
          let me=this;
          var url= '/venta/listarVentasCabeceraAlumno?page='+page_+'&buscar='+buscar_+'&criterio='+criterio_+'&paginado='+paginado_;
          axios.get(url).then(function (response) {
              var respuesta= response.data;
              me.arrayVentasCabeceraAlumno = respuesta.ventasCA.data; 
              me.pagination_= respuesta.pagination_;          
          })
          .catch(function (error) {
              console.log(error);
          });
        },
        cambiarPagina_(page_,buscar_,criterio_,paginado_){
          let me = this;
          //Actualiza la página actual
          me.pagination_.current_page_ = page_;
          //Envia la petición para visualizar la data de esa página
          me.listarVentasCabeceraAlumno(page_,buscar_,criterio_,paginado_);
        },
        listarVentasDetalleAlumno(id){
          let me=this;

          me.modal = 1;
          me.tituloModal = 'Consultar detalle';

          var url= '/venta/listarVentasDetallesAlumno?id=' + id;
          axios.get(url).then(function (response) {
              var respuesta= response.data;
              me.arrayVentasDetalleAlumno = respuesta.ventasDA;            
          })
          .catch(function (error) {
              console.log(error);
          });
        },      
        cerrarModal(){
          this.modal=0;
          this.tituloModal='';
        },
        ceroBusqueda(){
          this.buscar='';
          this.listarInscripcionesAlumnoId(1,this.buscar,this.criterio,this.paginado);
        },
        ceroBusqueda_(){
          this.buscar_='';
          this.listarVentasCabeceraAlumno(1,this.buscar_,this.criterio_,this.paginado_);
        }
      },
      mounted() {
        this.verAlumno();
        this.selectProfesion();
        this.selectProvincia();
        this.selectUniversidad();
        this.selectFraseId();

        this.selectModalidad();   
        this.listarInscripcionesAlumnoId(1,this.buscar,this.criterio,this.paginado);
        this.listarVentasCabeceraAlumno(1,this.buscar_,this.criterio_,this.paginado_);
      }
    }
</script>