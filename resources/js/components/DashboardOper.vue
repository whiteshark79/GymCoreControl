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
                                    <select class="form-control col-3" v-model="criterio" @onchange="ceroBusqueda();">
                                        <option value="fecha_ini">Fecha</option>
                                        <option value="idalumno">Alumno</option>
                                        <option value="idmodalidad">Modalidad</option>                                      
                                    </select>                                    
                                    <template v-if="criterio=='fecha_ini'">
                                        <input type="date" v-model="buscar" class="form-control col-4">
                                    </template>
                                    <template v-if="criterio=='idalumno'">
                                        <div class="col-md-7">                                                         
                                            <v-select
                                            id="buscar"
                                            @search="selectAlumno"
                                            label="nombre"
                                            :options="arrayAlumno"
                                            placeholder="Buscar Alumnos..."
                                            @input="getDatosAlumno"                                    
                                            ></v-select>
                                        </div> 
                                    </template>
                                    <template v-if="criterio=='idmodalidad'">
                                        <select class="form-control col-5" v-model="buscar">
                                            <option value="" disabled>--Seleccione--</option>
                                            <option v-for="modalidad in arrayModalidad" :key="modalidad.id" :value="modalidad.id" v-text="modalidad.nombre"></option>
                                        </select>
                                    </template>                                                                        
                                    <button type="submit" @click="listarInscripcionAlumno(1,buscar,criterio,paginado)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> </button>
                                    <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="fas fa-redo"></i> </button>                                 
                                </div>                      
                                <div class="input-group input-group-sm col-2">                                     
                                    <select class="form-control" v-model="paginado" @change="listarInscripcionAlumno(1,buscar,criterio,paginado)">
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
                                            <th width="34%">NOMBRE</th> 
                                            <th width="21%">MODALIDAD</th>                                                                                       
                                            <th width="15%">FECHA</th>
                                            <th width="15%">FECHA FIN</th>
                                            <th width="10%">ESTADO</th>
                                            <th width="5%">OPC</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayInscripcionAlumno.length">
                                        <tr v-for="inscripcion in arrayInscripcionAlumno" :key="inscripcion.id">
                                            <td align="center" v-text="inscripcion.id"></td>
                                            <td v-text="inscripcion.alumno"></td>
                                            <td v-text="inscripcion.modalidad"></td>
                                            <td align="center" v-text="inscripcion.fecha_ini"></td>                                  
                                            <td align="center" v-text="inscripcion.fecha_fin"></td>
                                            <td align="center">
                                                <div v-if="inscripcion.fecha_fin <= hoyFecha() "><span class="badge badge-danger">Caducado</span></div>
                                                <div v-else><span class="badge badge-success">Activo</span></div>                                    
                                            </td>
                                            <td align="center">
                                                <a class="btn btn-sm btn-default" @click="anotarAsistencia(inscripcion.id)"><i class="far fa-calendar-check"></i></a>  
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
                            <div class="card-title"><h3>Ventas</h3></div>                            
                        </div>  
                        <div class="card-body">
                            <div class="form-group row justify-content-between">
                                <div class="input-group input-group-sm col-10">                                
                                    <select class="form-control col-3" v-model="criterio_" @onchange="ceroBusqueda_();">
                                        <option value="fecha_hora">Fecha</option>
                                        <option value="idcliente">Alumno</option>                                      
                                    </select>                                    
                                    <template v-if="criterio_=='fecha_hora'">
                                        <input type="date" v-model="buscar_" class="form-control col-4">
                                    </template>
                                    <template v-if="criterio_=='idcliente'">
                                        <div class="col-md-7">                                                         
                                        <v-select
                                            id="buscar_"
                                            @search="selectCliente"
                                            label="nombre"
                                            :options="arrayCliente"
                                            placeholder="Buscar Cliente..."
                                            @input="getDatosCliente"                                    
                                        ></v-select>
                                        </div>
                                    </template>                                                                          
                                    <button type="submit" @click="listarVentaCliente(1,buscar_,criterio_,paginado_)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> </button>
                                    <button type="button" @click="ceroBusqueda_();" class="btn btn-info btn-sm ml-1"><i class="fas fa-redo"></i> </button>                                  
                                </div>                      
                                <div class="input-group input-group-sm col-2">                                     
                                    <select class="form-control" v-model="paginado" @change="listarVentaCliente(1,buscar_,criterio_,paginado_)">
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
                                            <th width="34%">NOMBRE</th>                                                                                       
                                            <th width="28%">FECHA VENTA</th>
                                            <th width="11%">TOTAL</th>
                                            <th width="11%">ABONO</th>
                                            <th width="11%">SALDO</th>
                                            <th width="5%">OPC</th>
                                        </tr>
                                    </thead>
                                    <tbody v-if="arrayVentaCliente.length">
                                        <tr v-for="venta in arrayVentaCliente" :key="venta.id">
                                            <td v-text="venta.cliente"></td>
                                            <td align="center"> {{venta.fecha_hora}}</td>                                  
                                            <td align="center">$ {{venta.total}}</td>
                                            <td align="center">$ {{venta.abono}}</td>
                                            <td align="center">$ {{ (venta.total-venta.abono).toFixed(2) }}</td>
                                            <td align="center">
                                                <a class="btn btn-sm btn-default" @click="listarVentaDetalleCliente(venta.id, venta.total, venta.abono)"><i class="far fa-credit-card"></i></a>  
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
                    <tbody v-if="arrayVentaDetalleCliente.length">
                        <tr v-for="detalle in arrayVentaDetalleCliente" :key="detalle.id"> 
                            <td align="left">{{detalle.articulo}}</td>
                            <td align="right">{{detalle.cantidad}}</td>
                            <td align="right">$ {{detalle.precio}}</td>
                            <td align="right">$ {{detalle.subtotal}}</td>                                                                                                                 
                        </tr>
                    </tbody>                                    
                  </table>
                </div>
                <div class="modal-footer">
                  <input v-model="venta_id" type="hidden"> 
                  <label for="abono" class="text-info">Saldo: </label>
                  <input v-model="saldo" type="number" step="0.1" min="0" :max="(total-abono)" class="form-control form-control-sm col-3">
                  <template v-if="modal<0"><input v-model="abono" type="number"><input v-model="total" type="number"></template>                    
                  <button type="button" class="btn btn-primary btn-sm" @click="pagarDeuda()">Pagar</button>
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
  import 'vue-select/dist/vue-select.css';
  import vSelect from 'vue-select';
  export default {
    data (){
      return {
        venta_id : 0,
        saldo : 0,
        abono : 0,
        total : 0,
        modal : 0,
        tituloModal : '',

        arrayVentaCliente:[],        
        arrayVentaDetalleCliente:[],
        arrayInscripcionAlumno:[],  
        
        arrayModalidad : [],
        arrayCliente:[],
        arrayAlumno : [],

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
    components: {
      vSelect
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

      listarInscripcionAlumno(page,buscar,criterio,paginado){
        let me=this;
        var url= '/inscripcion/listarInscripcionAlumno?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado;
        axios.get(url).then(function (response) {
            //console.log(response);
            var respuesta= response.data;
            me.arrayInscripcionAlumno = respuesta.inscripcionesM.data;
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
        me.listarInscripcionAlumno(page,buscar,criterio,paginado);
      },   
      selectAlumno(search,loading){
        let me=this;
        loading(true)

        var url= '/alumno/selectAlumno?filtro='+search;
        axios.get(url).then(function (response) {
            let respuesta = response.data;
            q: search
            me.arrayAlumno=respuesta.alumnos;
            loading(false)
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      getDatosAlumno(val1){
        let me = this;
        me.loading = true;
        me.buscar = val1.id;
      },
      ceroBusqueda(){
        this.buscar='';
        this.listarInscripcionAlumno(1,this.buscar,this.criterio,this.paginado);
      },
      

      listarVentaCliente(page_,buscar_,criterio_,paginado_){
        let me=this;
        var url= '/venta/listarVentaCliente?page='+page_+'&buscar='+buscar_+'&criterio='+criterio_+'&paginado='+paginado_;
        axios.get(url).then(function (response) {
            //console.log(response);
            var respuesta= response.data;
            me.arrayVentaCliente = respuesta.ventasM.data; 
             me.pagination_= respuesta.pagination_;              
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      listarVentaDetalleCliente(id, total, abono){
        let me=this;

        me.modal = 1;
        me.tituloModal = 'Consultar detalle';        
        me.abono = abono;
        me.total = total;
        me.saldo = (total-abono);
        me.venta_id = id;


        var url= '/venta/listarVentasDetallesAlumno?id=' + id;
        axios.get(url).then(function (response) {
            var respuesta= response.data;
            me.arrayVentaDetalleCliente = respuesta.ventasDA;            
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      selectCliente(search,loading){
        let me=this;
        loading(true)

        var url= '/cliente/selectCliente?filtro='+search;
        axios.get(url).then(function (response) {
            let respuesta = response.data;
            q: search
            me.arrayCliente=respuesta.clientes;
            loading(false)
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      getDatosCliente(val1){
        let me = this;
        me.loading = true;
        me.buscar_ = val1.id;
      },      
      ceroBusqueda_(){
        this.buscar='';
        this.listarVentaCliente(1,this.buscar_,this.criterio_,this.paginado_);
      },
      cerrarModal(){
        this.venta_id = 0,
        this.saldo = 0,
        this.abono = 0,
        this.total = 0,
        this.modal=0;
        this.tituloModal='';
      },
      pagarDeuda(){        
        let me = this;        

        axios.put('/venta/pagarDeuda',{
          'saldo': this.saldo,
          'abono': this.abono,
          'total': this.total,
          'id': this.venta_id
        }).then(function (response) {
            me.cerrarModal();
            me.listarVentaCliente(1,me.buscar_,me.criterio_,me.paginado_);
        }).catch(function (error) {
            console.log(error);
        }); 
      },
      cambiarPagina_(page_,buscar_,criterio_,paginado_){
        let me = this;
        //Actualiza la página actual
        me.pagination_.current_page_ = page_;
        //Envia la petición para visualizar la data de esa página
        me.listarVentaCliente(page_,buscar_,criterio_,paginado_);
      }
      

    },
    mounted() {
        this.selectModalidad();     
        this.listarInscripcionAlumno(1,this.buscar,this.criterio,this.paginado);
        this.listarVentaCliente(1,this.buscar_,this.criterio_,this.paginado_);
    }
  }
</script>