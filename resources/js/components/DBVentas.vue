<template>

    <main class="main"> 
      <div class="container-fluid">

        <div class="row mt-2">                  

          <div class="col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cash-register"></i></span>
                <div class="info-box-content">                        
                  <span class="info-box-text">{{v_msj}}</span>
                  <span class="info-box-number">Mes: ${{v_val_mes}} <small>( {{v_qtx_mes}} )</small></span>
                  <span class="info-box-number">Total: ${{v_val_total}}  <small>( {{v_qtx_total}} )</small></span>      
              </div>
            </div>
          </div> 
          <div class="col-md-3">
            <div class="info-box">
              <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>
              <div class="info-box-content">
                  <span class="info-box-text">{{i_msj}}</span>
                  <span class="info-box-number">Mes: ${{i_val_mes}} <small>( {{i_qtx_mes}} )</small></span>
                  <span class="info-box-number">Total: ${{i_val_total}}  <small>( {{i_qtx_total}} )</small></span>           
              </div>
            </div>
          </div>                  
                            
        </div>                      
        
        <div class="row">
          <div class="col-md-6">
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
          <div class="col-md-6">
            <div class="card">
              <div class="card-header">
                  <h4>Registro de Ventas</h4>
              </div>
              <div class="card-content">
                <div class="table-responsive-sm table-wrapper-scroll-y my-custom-mini-scrollbar">
                  <table class="table table-bordered table-sm table-hover" id="dtTable">
                      <thead class="thead-table">
                          <tr align="center">                                  
                            <th width="5%">#</th> 
                            <th width="34%">NOMBRE</th>                                                                                       
                            <th width="25%">FECHA VENTA</th>
                            <th width="12%">TOTAL</th>
                            <th width="12%">ABONO</th>
                            <th width="12%">SALDO</th>
                          </tr>
                      </thead>
                      <tbody v-if="arrayVentaCliente.length">
                          <tr v-for="venta in arrayVentaCliente" :key="venta.id">
                              <td align="center" v-text="venta.id"></td>
                              <td v-text="venta.cliente"></td>
                              <td align="center"> {{venta.fecha_hora}}</td>                                  
                              <td align="center">$ {{venta.total}}</td>
                              <td align="center">$ {{venta.abono}}</td>
                              <td align="center">$ {{ (venta.total-venta.abono).toFixed(2) }}</td>                                                                      
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
              </div>                      
            </div>                    
          </div>  
        </div>
        
      </div>      
                
                
            
            
    </main>
</template>

<script>
  export default {
    data (){
      return {
        arrayVentaCliente:[],

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
      listarVentaCliente(){
        let me=this;
        var url= '/venta/listarVentaCliente';
        axios.get(url).then(function (response) {
            //console.log(response);
            var respuesta= response.data;
            me.arrayVentaCliente = respuesta.ventasM;            
        })
        .catch(function (error) {
            console.log(error);
        });
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
        me.ingresos.map(function(x){
          me.varMesIngreso.push(x.mes);
          me.varTotalIngreso.push(x.total);
        });
        me.ventas.map(function(x){
          me.varMesVenta.push(x.mes);
          me.varTotalVenta.push(x.total);
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
              backgroundColor: 'rgba(250, 217, 85, 0.2)',
              borderColor: 'rgba(166, 144, 56, 0.5)',
              hoverBackgroundColor: "rgba(166, 144, 56, 0.5)",
              hoverBorderColor: "rgba(250, 217, 85, 0.2)",
              borderWidth: 1
            },{
              label: 'Ventas',
              data: me.varTotalVenta,
              backgroundColor: 'rgba(23, 162, 184, 0.2)',
              borderColor: 'rgba(15, 108, 122, 0.5)',
              hoverBackgroundColor: "rgba(15, 108, 122, 0.5)",
              hoverBorderColor: "rgba(23, 162, 184, 0.2)",
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
    },
    mounted() {       
      this.listarVentaCliente();
      this.widgetInOuts();
      this.getIngVen();      
    }
  }
</script>