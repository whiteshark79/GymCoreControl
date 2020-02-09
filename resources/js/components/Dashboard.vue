<template>

    <main class="main">
      <div class="row mt-3">
        <div class="container-fluid">
          <div class="col-md-12">
            <div class="card card-outline card-primary">
              <div class="card-header">
                <div class="card-title"><h3>Dashboard</h3></div>                
              </div>
              <div class="card-body">              
                <div class="row">
                  

                  <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">{{in_msj}}</span>
                        <span class="info-box-number">Mes: ${{in_val_mes}} <small>( {{in_qtx_mes}} )</small></span>
                        <span class="info-box-number">Total: ${{in_val_total}}  <small>( {{in_qtx_total}} )</small></span> 
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                      <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-hand-holding-usd"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">{{g_msj}}</span>
                        <span class="info-box-number">Mes: ${{g_val_mes}} <small>( {{g_qtx_mes}} )</small></span>
                        <span class="info-box-number">Total: ${{g_val_total}}  <small>( {{g_qtx_total}} )</small></span>
                      </div>
                    </div>
                  </div>                    

                  <div class="clearfix hidden-md-up"></div>

                  <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                      <span class="info-box-icon bg-warning elevation-1"><i class="fas fa-shopping-cart"></i></span>
                      <div class="info-box-content">
                          <span class="info-box-text">{{i_msj}}</span>
                          <span class="info-box-number">Mes: ${{i_val_mes}} <small>( {{i_qtx_mes}} )</small></span>
                          <span class="info-box-number">Total: ${{i_val_total}}  <small>( {{i_qtx_total}} )</small></span>           
                      </div>
                    </div>
                  </div>                  
                  <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box">
                      <span class="info-box-icon bg-info elevation-1"><i class="fas fa-cash-register"></i></span>
                        <div class="info-box-content">                        
                          <span class="info-box-text">{{v_msj}}</span>
                          <span class="info-box-number">Mes: ${{v_val_mes}} <small>( {{v_qtx_mes}} )</small></span>
                          <span class="info-box-number">Total: ${{v_val_total}}  <small>( {{v_qtx_total}} )</small></span>      
                      </div>
                    </div>
                  </div>                  
                </div>              

                <div class="row">
                  <div class="col-md-6">
                    <div class="card card-chart">
                      <div class="card-header">
                          <h4>Inscripciones vs Gastos</h4>                      
     
                      </div>
                      <div class="card-content">
                        <div class="ct-chart">
                            <canvas id="chart_insgas">                                                
                            </canvas>
                        </div>
                      </div>                      
                    </div>
                  </div>

                  <div class="col-md-6">
                    <div class="card">
                      <div class="card-header">
                          <h4>Registro de Alumnos</h4>
                      </div>
                      <div class="card-content">
                        <div class="table-responsive-sm">
                          <table class="table table-bordered table-sm table-hover" id="dtTable">
                              <thead class="thead-table">
                                  <tr align="center">                                  
                                    <th width="5%">#</th> 
                                    <th width="37%">NOMBRE</th>                                                                                       
                                    <th width="22%">FECHA REGISTRO</th>
                                    <th width="20%">FECHA FIN</th>
                                    <th width="10%">ESTADO</th>
                                  </tr>
                              </thead>
                              <tbody v-if="arrayInscripcionAlumno.length">
                                  <tr v-for="inscripcion in arrayInscripcionAlumno" :key="inscripcion.id">
                                      <td align="center" v-text="inscripcion.id"></td>
                                      <td v-text="inscripcion.alumno"></td>
                                      <td align="center" v-text="inscripcion.fecha_ini"></td>                                  
                                      <td align="center" v-text="inscripcion.fecha_fin"></td>
                                      <td align="center">
                                          <div v-if="inscripcion.fecha_fin <= hoyFecha() "><span class="badge badge-danger">Caducado</span></div>
                                          <div v-else><span class="badge badge-success">Activo</span></div>                                    
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
                      </div>                      
                    </div>                    
                  </div>                 
                </div>                      
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="card card-chart">
                      <div class="card-header">
                          <h4>Compras vs Ventas</h4>
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
        </div>
      </div>
        
      
    </main>
</template>

<script>
  export default {
    data (){
      return {
        arrayInscripcionAlumno:[],
        //fecha_hoy: new Date().getDate(),

        ArrayWIngresos:[],
        ArrayWVentas:[],
        ArrayWInscripciones:[],
        ArrayWGastos:[],
        ArrayWAlumnos:[],
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
        in_val_total:0,
        in_val_mes:0,
        in_qtx_total:0,
        in_qtx_mes:0,
        in_msj:'',
        g_val_total:0,
        g_val_mes:0,
        g_qtx_total:0,
        g_qtx_mes:0,
        g_msj:'',
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

        varInsGas:null,
        charInsGas:null,
        inscripciones:[],
        gastos:[],
        varTotalInscripcion:[],
        varTotalGasto:[],
        varMesInscripcion:[],
        varMesGasto:[]
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

      listarAlumnoMes(){
        let me=this;
        var url= '/inscripcion/listarAlumnoMes';
        axios.get(url).then(function (response) {
            //console.log(response);
            var respuesta= response.data;
            me.arrayInscripcionAlumno = respuesta.inscripcionesM;            
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
              var respuesta_win= response.data;
              var respuesta_wg= response.data;
              me.ArrayWIngresos = respuesta_wi.wingresos;
              me.ArrayWVentas = respuesta_wv.wventas;
              me.ArrayWInscripciones = respuesta_win.winscripciones;
              me.ArrayWGastos = respuesta_wg.wgastos;
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
        me.ArrayWInscripciones.map(function(x){
          me.in_val_total = x.in_val_total;
          me.in_val_mes = x.in_val_mes;
          me.in_qtx_total = x.in_qtx_total;
          me.in_qtx_mes = x.in_qtx_mes;
          me.in_msj = x.in_msj;
        });
        me.ArrayWGastos.map(function(x){
          me.g_val_total = x.g_val_total;
          me.g_val_mes = x.g_val_mes;
          me.g_qtx_total = x.g_qtx_total;
          me.g_qtx_mes = x.g_qtx_mes;
          me.g_msj = x.g_msj;
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
      getInsGas(){
        let me=this;
        var url= '/dashboard/grafInOuts';
        axios.get(url).then(function (response) {
          var respuesta_in= response.data;
          var respuesta_g= response.data;
          me.inscripciones = respuesta_in.inscripciones;
          me.gastos = respuesta_g.gastos;
          //cargamos los datos del chart
          me.loadInsGas();
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      loadInsGas(){
        let me=this;
        me.inscripciones.map(function(x){
          me.varMesInscripcion.push(x.mes);
          me.varTotalInscripcion.push(x.total);
        });
        me.gastos.map(function(x){
          me.varMesGasto.push(x.mes);
          me.varTotalGasto.push(x.total);
        });

        var mesInsGas =  (me.varMesGasto > me.varMesInscripcion) ? me.varMesGasto : me.varMesInscripcion;
        //console.log(mesInsGas);

        me.varInsGas=document.getElementById('chart_insgas').getContext('2d');//id canvas donde se mostrará el graf

        me.charInsGas = new Chart(me.varInsGas, {
          type: 'bar',
          data: {
            labels: mesInsGas, 
            datasets: [{
              label: 'Inscripciones',
              data: me.varTotalInscripcion,
              backgroundColor: 'rgba(40, 167, 69, 0.2)',
              borderColor: 'rgba(26, 111, 46, 0.5)',
              hoverBackgroundColor: "rgba(26, 111, 46, 0.5)",
              hoverBorderColor: "rgba(40, 167, 69, 0.2)",
              borderWidth: 1
            },{
              label: 'Gastos',
              data: me.varTotalGasto,
              backgroundColor: 'rgba(108, 117, 125, 0.2)',
              borderColor: 'rgba(72, 78, 83, 0.5)',
              hoverBackgroundColor: "rgba(72, 78, 83, 0.5)",
              hoverBorderColor: "rgba(108, 117, 125, 0.2)",
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
      this.listarAlumnoMes();
      this.widgetInOuts();
      this.getIngVen();
      this.getInsGas();        
    }
  }
</script>