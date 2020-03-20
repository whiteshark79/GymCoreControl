<template>
  
    <main class="main">
        <div class="container-fluid">
            <div class="row mt-3">
                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title"><h3>Inscripciones</h3></div>                            
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
                                    <button type="submit" @click="listarInscripcionesAlumnoId(1,buscar,criterio,paginado)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                                    <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="fas fa-redo"></i> </button>                                
                                </div>                                
                                <div class="input-group input-group-sm col-2">                                     
                                    <select class="form-control" v-model="paginado" @change="listarInscripcionesAlumnoId(1,buscar,criterio,paginado)">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    </select>
                                </div> 
                            </div>                            
                            <div class="table-responsive-sm table-wrapper-scroll-y my-custom-mini-scrollbar">
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

                <div class="col-md-6">
                    <div class="card card-primary card-outline">
                        <div class="card-header">
                            <div class="card-title"><h3>Compras</h3></div>                            
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
                                    <button type="submit" @click="listarVentasCabeceraAlumno(1,buscar_,criterio_,paginado_)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                                    <button type="button" @click="ceroBusqueda_();" class="btn btn-info btn-sm ml-1"><i class="fas fa-redo"></i> </button>                                 
                                </div>
                                <div class="input-group input-group-sm col-2">                                     
                                    <select class="form-control" v-model="paginado_" @change="listarVentasCabeceraAlumno(1,buscar_,criterio_,paginado_)">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    </select>
                                </div> 
                            </div>
                            <div class="table-responsive-sm table-wrapper-scroll-y my-custom-mini-scrollbar">
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
                                                <a class="btn btn-sm btn-default" @click="listarVentasDetalleAlumno(venta.id)"><i class="far fa-eye"></i></a>  
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
        this.selectModalidad();   
        this.listarInscripcionesAlumnoId(1,this.buscar,this.criterio,this.paginado);
        this.listarVentasCabeceraAlumno(1,this.buscar_,this.criterio_,this.paginado_);
    }
  }
</script>