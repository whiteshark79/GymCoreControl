<template>

    <main class="main"> 
      <div class="container-fluid">

        <div class="row mt-1">
          <div class="col-sm-6">
            <div class="card">
              <div class="card-body">
                <div class="row">
                  <div class="col-12 col-sm-6 col-md-6">
                    <div class="info-box">
                      <span class="info-box-icon bg-info elevation-1"><i class="icon-basket"></i></span>
                        <div class="info-box-content">                        
                          <span class="info-box-text">{{v_msj}}</span>
                          <span class="info-box-number">Mes: ${{v_val_mes}} <small>( {{v_qtx_mes}} )</small></span>
                          <span class="info-box-number">Total: ${{v_val_total}}  <small>( {{v_qtx_total}} )</small></span>      
                      </div>
                    </div> 
                  </div>

                  <div class="col-12 col-sm-6 col-md-6">
                    <div class="info-box">
                      <span class="info-box-icon bg-warning elevation-1"><i class="icon-handbag"></i></span>
                      <div class="info-box-content">
                          <span class="info-box-text">{{i_msj}}</span>
                          <span class="info-box-number">Mes: ${{i_val_mes}} <small>( {{i_qtx_mes}} )</small></span>
                          <span class="info-box-number">Total: ${{i_val_total}}  <small>( {{i_qtx_total}} )</small></span>           
                      </div>
                    </div>
                  </div>
                </div>
                <div class="row">
                  <div class="col-md-12">
                    <div class="card callout callout-info">
                      <div class="card-header">
                          <h4>Ventas vs Compras</h4>
                      </div>
                      <div class="card-content">
                        <div class="ct-chart">
                            <canvas id="chart_ingven">                                                
                            </canvas>
                        </div>
                      </div>                          
                    </div>
                  </div>
                </div> 
              </div>
            </div>
          </div>
          <div class="col-sm-6">  
            <div class="card">
              <div class="card-header">
                  <div class="card-title"><h3>Ventas</h3></div>
              </div>
              <div class="card-body">
                <div class="form-group row justify-content-between">
                  <div class="row col-sm-12 col-md-12">
                    <div class="input-group input-group-sm col-sm-10 col-md-10">                                
                        <select class="form-control col-sm-3 col-md-3" v-model="criterio_" @onchange="ceroBusqueda();">
                            <option value="fecha_hora">Fecha</option>
                            <option value="idcliente">Cliente</option>                                      
                        </select>                                    
                        <template v-if="criterio_=='fecha_hora'">
                            <input type="date" v-model="buscar_" class="form-control col-sm-5 col-md-4">
                        </template>
                        <template v-if="criterio_=='idcliente'">
                          <div class="col-sm-6 col-md-5">                                                         
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
                        <button type="submit" @click="listarVentaCliente(1,buscar_,criterio_,paginado_)" class="btn btn-primary btn-sm"><i class="icon-magnifier"></i> </button>
                        <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="icon-reload"></i> </button>                                  
                    </div>                      
                    <div class="input-group input-group-sm col-sm-2 col-md-2">                                     
                        <select class="form-control col-sm-12 col-md-12" v-model="paginado_" @change="listarVentaCliente(1,buscar_,criterio_,paginado_)">
                          <option value="10">10</option>
                          <option value="25">25</option>
                          <option value="50">50</option>
                        </select>
                    </div> 
                  </div>
                </div>
                <div class="table-responsive-sm table-wrapper-scroll-y my-custom-mini-scrollbar_">
                  <table class="table table-bordered table-sm table-hover" id="dtTable">
                      <thead class="thead-table">
                          <tr align="center">                             
                            <th scope="col" width="36%">NOMBRE</th>                                                                                       
                            <th scope="col" width="16%">FECHA</th>
                            <th scope="col" width="13%">TOTAL</th>
                            <th scope="col" width="13%">ABONO</th>
                            <th scope="col" width="13%">SALDO</th>
                            <th scope="col" width="9%">OPC</th>
                          </tr>
                      </thead>
                      <tbody v-if="arrayVentaCliente.length">
                          <tr v-for="venta in arrayVentaCliente" :key="venta.id">
                            <td v-text="venta.cliente" scope="row" data-label="NOMBRE"></td>
                            <td align="center" data-label="FECHA"> {{venta.fecha_hora}}</td>                                  
                            <td align="center" data-label="TOTAL">$ {{venta.total}}</td>
                            <td align="center" data-label="ABONO">$ {{venta.abono}}</td>
                            <td align="center" data-label="SALDO">$ {{ (venta.total-venta.abono).toFixed(2) }}</td>
                            <td align="center" data-label="OPC">
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
                  <template v-if="modal<0"><input v-model="abono" type="number" min="0"><input v-model="total" type="number"></template>                    
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

        ArrayWIngresos:[],
        ArrayWVentas:[],
        i_val_total:0,
        i_val_mes:'0',
        i_qtx_total:0,
        i_qtx_mes:0,
        i_msj:'',
        v_val_total:0,
        v_val_mes:0,
        v_qtx_total:0,
        v_qtx_mes:0,
        v_msj:'',        
        alumnosM:0,
        alumnosH:0,
        a_msj:'',

        varIngVen:null,//id donde se muestra graf
        charIngVen:null,//crea el graf alimentado por valores vinculados al id del canvas            
        ingresos:[],
        ventas:[],
        varTotalIngreso:[],
        varTotalVenta:[],
        varMesIngreso:[],       
        varMesVenta:[],

        varBackgroundColorV:'',
        backgroundcolorV:[],
        hoverbackgroundcolorV:[],
        varBackgroundColorIn:'',
        backgroundcolorIn:[],
        hoverbackgroundcolorIn:[],

        arrayCliente:[],

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
      isActived_: function(){
            return this.pagination_.current_page_;
        },
      //Calcula los elementos de la paginación
      pagesNumber_: function() {
        if(!this.pagination_.to_) { return []; }      
    
        var from_ = this.pagination_.current_page_ - this.offset_; 
        if(from_ < 1) { from_ = 1; }

        var to_ = from_ + (this.offset_ * 2); 
        if(to_ >= this.pagination_.last_page_){ to_ = this.pagination_.last_page_; }  

        var pagesArray_ = [];
        while(from_ <= to_) { pagesArray_.push(from_); from_++; }

        return pagesArray_;             

      },
      calcularTotal: function(){
          let me=this;
          var resultado=0.0;
          for(var i=0;i<this.arrayDetalle.length;i++){
              resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad-this.arrayDetalle[i].descuento)
          }
          me.abono= resultado;
          return resultado;
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
      cambiarPagina_(page_,buscar_,criterio_,paginado_){
        let me = this;
        //Actualiza la página actual
        me.pagination_.current_page_ = page_;
        //Envia la petición para visualizar la data de esa página
        me.listarVentaCliente(page_,buscar_,criterio_,paginado_);
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
      widgetInOuts(){
        let me=this;
          var url= '/dashboard/widgetInOuts';
          axios.get(url).then(function (response) {
              var respuesta_wi= response.data;
              var respuesta_wv= response.data;
              me.ArrayWIngresos = respuesta_wi.wingresos;
              me.ArrayWVentas = respuesta_wv.wventas;
              me.loadWidgetInOuts();       
          })
          .catch(function (error) {
              console.log(error);
          });
      },   
      loadWidgetInOuts(){
        let me=this;
        
        me.ArrayWIngresos.map(function(x){
          me.i_val_total = x.i_val_total;
          me.i_val_mes = x.i_val_mes;
          me.i_qtx_total = x.i_qtx_total;
          me.i_qtx_mes = x.i_qtx_mes;
          me.i_msj = x.i_msj;
        });
        me.ArrayWVentas.map(function(x){
          me.v_val_total = x.v_val_total;
          me.v_val_mes = x.v_val_mes;
          me.v_qtx_total = x.v_qtx_total;
          me.v_qtx_mes = x.v_qtx_mes;
          me.v_msj = x.v_msj;
        });
      },
      getIngVen(){
        let me=this;
        var url= '/dashboard/grafInOuts';
        axios.get(url).then(function (response) {
          var respuesta_i= response.data;
          var respuesta_v= response.data;
          me.ingresos = respuesta_i.ingresos;
          me.ventas = respuesta_v.ventas;
          //cargamos los datos del chart
          me.loadIngVen();
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      loadIngVen(){
        let me=this;
        me.varBackgroundColorIn = Math.random()*255+','+Math.random()*255+','+Math.random()*255;
        me.varBackgroundColorV = Math.random()*255+','+Math.random()*255+','+Math.random()*255;

        me.ingresos.map(function(x){          
          me.varMesIngreso.push(x.mes);
          me.varTotalIngreso.push(x.total);
          me.backgroundcolorIn.push('rgba('+me.varBackgroundColorIn+',0.3)');
          me.hoverbackgroundcolorIn.push('rgba('+me.varBackgroundColorIn+',0.5)'); 
        });
        me.ventas.map(function(x){          
          me.varMesVenta.push(x.mes);
          me.varTotalVenta.push(x.total);
          me.backgroundcolorV.push('rgba('+me.varBackgroundColorV+',0.3)');
          me.hoverbackgroundcolorV.push('rgba('+me.varBackgroundColorV+',0.5)');
        });

        var mesIngVen =  (me.varMesVenta > me.varMesIngreso) ? me.varMesVenta : me.varMesIngreso;
        //console.log(mes);

        me.varIngVen=document.getElementById('chart_ingven').getContext('2d');//id canvas donde se mostrará el graf

        me.charIngVen = new Chart(me.varIngVen, {
          type: 'line',
          data: {
            labels: mesIngVen, 
            datasets: [{
              label: 'Compras',
              data: me.varTotalIngreso,
              backgroundColor: me.backgroundcolorIn,
              borderColor: me.hoverbackgroundcolorIn,
              hoverBackgroundColor: me.hoverbackgroundcolorIn,
              hoverBorderColor: me.backgroundcolorIn,
              borderWidth: 1
            },{
              label: 'Ventas',
              data: me.varTotalVenta,
              backgroundColor: me.backgroundcolorV,
              borderColor: me.hoverbackgroundcolorV,
              hoverBackgroundColor: me.hoverbackgroundcolorV,
              hoverBorderColor: me.backgroundcolorV,
              borderWidth: 1
          }]
          },
          options: {
            scales: {
              yAxes: [{
                ticks: {
                  beginAtZero:true
                }
              }]
            }
          }
        });
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
      ceroBusqueda(){
        this.buscar_='';
        this.listarVentaCliente(1,this.buscar_,this.criterio_,this.paginado_);
      }
    },
    mounted() {       
      this.listarVentaCliente(1,this.buscar_,this.criterio_,this.paginado_);
      this.widgetInOuts();
      this.getIngVen();      
    }
  }
</script>