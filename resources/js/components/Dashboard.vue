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
                        <span class="info-box-icon bg-info elevation-1"><i class="fas fa-hand-holding-usd"></i></span>
                          <div class="info-box-content">                        
                            <span class="info-box-text">{{v_msj}}</span>
                            <span class="info-box-number">Mes: ${{v_val_mes}} <small>( {{v_qtx_mes}} )</small></span>
                            <span class="info-box-number">Total: ${{v_val_total}}  <small>( {{v_qtx_total}} )</small></span>      
                        </div>
                      </div>
                    </div>                           

                  <div class="clearfix hidden-md-up"></div>

                  <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                      <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">{{is_msj}}</span>
                        <span class="info-box-number">Mes: ${{is_val_mes}} <small>( {{is_qtx_mes}} )</small></span>
                        <span class="info-box-number">Total: ${{is_val_total}}  <small>( {{is_qtx_total}} )</small></span> 
                      </div>
                    </div>
                  </div>
                  <div class="col-12 col-sm-6 col-md-3">
                    <div class="info-box mb-3">
                      <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-restroom"></i></span>
                      <div class="info-box-content">
                        <span class="info-box-text">{{a_msj}}</span>
                        <span class="info-box-number">Mujeres: {{alumnosM}}</span>
                        <span class="info-box-number">Hombres: {{alumnosH}}</span>
                      </div>
                    </div>
                  </div>
                </div>                        
                
                <div class="row">
                  <div class="col-md-6">
                    <div class="card card-chart">
                      <div class="card-header">
                          <h4>Compras</h4>
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
                    <div class="card card-chart">
                      <div class="card-header">
                          <h4>Inscripciones</h4>
                      </div>
                      <div class="card-content">
                          <div class="ct-chart">
                              <canvas id="chart_ins">                                                
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
        ArrayWIngresos:[],
        ArrayWVentas:[],
        ArrayWInscripciones:[],
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
        is_val_total:0,
        is_val_mes:0,
        is_qtx_total:0,
        is_qtx_mes:0,
        is_msj:'',
        alumnosM:0,
        alumnosH:0,
        a_msj:'',

        varIngVen:null,//id donde se muestra graf
        charIngVen:null,//crea el graf alimentado por valores vinculados al id del canvas        
        ingresos:[],
        varTotalIngreso:[],
        varMesIngreso:[],        
        ventas:[],
        varTotalVenta:[],
        varMesVenta:[],

        varInscripciones:null,
        charInscripciones:null,
        inscripciones:[],
        varTotalInscripcion:[],
        varMesInscripcion:[],
      }
    },
    methods : {     

      widgetIngresos(){
        let me=this;
          var url= '/dashboard/widgetIngresosVentas';
          axios.get(url).then(function (response) {
              var respuesta= response.data;
              me.ArrayWIngresos = respuesta.wingresos;
              me.loadWidgetIngresos();       
          })
          .catch(function (error) {
              console.log(error);
          });
      },      
      widgetVentas(){
        let me=this;
          var url= '/dashboard/widgetIngresosVentas';
          axios.get(url).then(function (response) {
              var respuesta= response.data;
              me.ArrayWVentas = respuesta.wventas;
              me.loadWidgetVentas();            
          })
          .catch(function (error) {
              console.log(error);
          });
      },
      widgetInscripciones(){
        let me=this;
          var url= '/dashboard/widgetInscripciones';
          axios.get(url).then(function (response) {
              var respuesta= response.data;
              me.ArrayWInscripciones = respuesta.winscripciones;
              me.loadWidgetInscripciones();            
          })
          .catch(function (error) {
              console.log(error);
          });
      },
      widgetAlumnos(){
        let me=this;
          var url= '/dashboard/widgetAlumnos';
          axios.get(url).then(function (response) {
              var respuesta= response.data;
              me.ArrayWAlumnos = respuesta.alumnos;
              me.loadWidgetAlumnos();            
          })
          .catch(function (error) {
              console.log(error);
          });
      },
      loadWidgetIngresos(){
        let me=this;
        me.ArrayWIngresos.map(function(x){
          me.i_val_total = x.i_val_total;
          me.i_val_mes = x.i_val_mes;
          me.i_qtx_total = x.i_qtx_total;
          me.i_qtx_mes = x.i_qtx_mes;
          me.i_msj = x.i_msj;
        });
      },      
      loadWidgetVentas(){
        let me=this;
        me.ArrayWVentas.map(function(x){
          me.v_val_total = x.v_val_total;
          me.v_val_mes = x.v_val_mes;
          me.v_qtx_total = x.v_qtx_total;
          me.v_qtx_mes = x.v_qtx_mes;
          me.v_msj = x.v_msj;
        });
      },
      loadWidgetInscripciones(){
        let me=this;
        me.ArrayWInscripciones.map(function(x){
          me.is_val_total = x.is_val_total;
          me.is_val_mes = x.is_val_mes;
          me.is_qtx_total = x.is_qtx_total;
          me.is_qtx_mes = x.is_qtx_mes;
          me.is_msj = x.is_msj;
        });
      },      
      loadWidgetAlumnos(){
        let me=this;
        me.ArrayWAlumnos.map(function(x){
          me.alumnosM = x.alumnosM;
          me.alumnosH = x.alumnosH;
          me.a_msj = x.a_msj;
        });
      },  
      
      getIngVen(){
        let me=this;
        var url= '/dashboard/grafIngVenIns';
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
        me.varIngVen=document.getElementById('chart_ingven').getContext('2d');//id canvas donde se mostrará el graf

        me.charIngVen = new Chart(me.varIngVen, {
          type: 'bar',
          data: {
            labels: me.varMesIngreso,
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
      getInscripciones(){
        let me=this;
        var url= '/dashboard/grafIngVenIns';
        axios.get(url).then(function (response) {
          var respuesta= response.data;
          me.inscripciones = respuesta.inscripciones;
          //cargamos los datos del chart
          me.loadIncripciones();
        })
        .catch(function (error) {
            console.log(error);
        });
      },      
      loadIncripciones(){
          let me=this;
          me.inscripciones.map(function(x){
            me.varMesInscripcion.push(x.mes);
            me.varTotalInscripcion.push(x.total);
          });
          me.varInscripcion=document.getElementById('chart_ins').getContext('2d');

          me.charInscripcion = new Chart(me.varInscripcion, {
              type: 'bar',
              data: {
                  labels: me.varMesInscripcion,
                  datasets: [{
                      label: 'Inscripciones',
                      data: me.varTotalInscripcion,
                      backgroundColor: 'rgba(40, 167, 69, 0.2)',
                      borderColor: 'rgba(26, 111, 46, 0.5)',
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
      }
    },
    mounted() {        
      this.widgetIngresos();
      this.widgetVentas();
      this.widgetInscripciones();
      this.widgetAlumnos();
      this.getIngVen();
      this.getInscripciones();        
    }
  }
</script>