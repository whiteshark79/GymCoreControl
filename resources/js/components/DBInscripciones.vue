<template>

  <main class="main">      
    <div class="container-fluid">  

      <div class="row mt-1">
        <div class="col-sm-6">
          <div class="card">
            <div class="card-body">
              <div class="row">
                <div class="info-box col-6">
                  <span class="info-box-icon bg-success elevation-1"><i class="fas fa-users"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">{{in_msj}}</span>
                    <span class="info-box-number">Mes: ${{in_val_mes}} <small>( {{in_qtx_mes}} )</small></span>
                    <span class="info-box-number">Total: ${{in_val_total}}  <small>( {{in_qtx_total}} )</small></span> 
                  </div>
                </div>
                <div class="info-box col-6">
                  <span class="info-box-icon bg-secondary elevation-1"><i class="fas fa-hand-holding-usd"></i></span>
                  <div class="info-box-content">
                    <span class="info-box-text">{{g_msj}}</span>
                    <span class="info-box-number">Mes: ${{g_val_mes}} <small>( {{g_qtx_mes}} )</small></span>
                    <span class="info-box-number">Total: ${{g_val_total}}  <small>( {{g_qtx_total}} )</small></span>
                  </div>
                </div>
              </div>

              <div class="row">
                <div class="card callout callout-success col-12">
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
            </div>
          </div>
        </div>

        <div class="col-sm-6">
          
          <div class="card">
            <div class="card-header">
                <div class="card-title"><h3>Inscripciones</h3></div>
            </div>
            <div class="card-body">
              <div class="form-group row justify-content-between">
                <div class="input-group input-group-sm col-10">                                
                    <select class="form-control col-3" v-model="criterio" @onchange="ceroBusqueda();">
                        <option value="fecha_ini">Fecha</option>
                        <option value="idalumno">Alumno</option>                                      
                    </select>                                    
                    <template v-if="criterio=='fecha_ini'">
                        <input type="date" v-model="buscar" class="form-control col-5">
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
              <div class="table-responsive-sm table-wrapper-scroll-y my-custom-mini-scrollbar_">
                <table class="table table-bordered table-sm table-hover" id="dtTable">
                    <thead class="thead-table">
                        <tr align="center">    
                          <th width="36%">NOMBRE</th> 
                          <th width="22%">MODALIDAD</th>                                                                                       
                          <th width="16%">FECHA</th>
                          <th width="16%">FECHA FIN</th>
                          <th width="10%">ESTADO</th>
                        </tr>
                    </thead>
                    <tbody v-if="arrayInscripcionAlumno.length">
                        <tr v-for="inscripcion in arrayInscripcionAlumno" :key="inscripcion.id">
                            <td v-text="inscripcion.alumno"></td>
                            <td v-text="inscripcion.modalidad"></td>
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
    </div>                    
          
  </main>
</template>

<script>
  import 'vue-select/dist/vue-select.css';
  import vSelect from 'vue-select';
  export default {
    data (){
      return {
        arrayInscripcionAlumno:[],
        
        ArrayWInscripciones:[],
        ArrayWGastos:[],
        ArrayWAlumnos:[],  
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

        varInsGas:null,
        charInsGas:null,
        
        inscripciones:[],
        varTotalInscripcion:[],        
        varMesInscripcion:[],
        varBackgroundColorI:'',
        backgroundcolorI:[],
        hoverbackgroundcolorI:[],

        gastos:[],        
        varTotalGasto:[],
        varMesGasto:[],
        varBackgroundColorG:'',
        backgroundcolorG:[],
        hoverbackgroundcolorG:[],

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
        paginado : 10
      }
    },
    components: {
      vSelect
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
      hoyFecha(){
        var hoy = new Date();
        var dd = hoy.getDate();
        var mm = hoy.getMonth()+1;
        var yyyy = hoy.getFullYear();

        if(dd < 10) dd = '0'+dd;
        if(mm < 10) mm = '0'+mm;
 
        return yyyy+'-'+mm+'-'+dd;      
      },
      cambiarPagina(page,buscar,criterio,paginado){
        let me = this;
        //Actualiza la página actual
        me.pagination.current_page = page;
        //Envia la petición para visualizar la data de esa página
        me.listarInscripcionAlumno(page,buscar,criterio,paginado);
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
      widgetInOuts(){ 
        let me=this; 
          var url= '/dashboard/widgetInOuts';
          axios.get(url).then(function (response) {
              var respuesta_win= response.data;
              var respuesta_wg= response.data;
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
          me.varBackgroundColorI = Math.random()*255+','+Math.random()*255+','+Math.random()*255;
          me.varMesInscripcion.push(x.mes);
          me.varTotalInscripcion.push(x.total);
          me.backgroundcolorI.push('rgba('+me.varBackgroundColorI+',0.3)');
          me.hoverbackgroundcolorI.push('rgba('+me.varBackgroundColorI+',0.5)'); 
        });
        me.gastos.map(function(x){
          me.varBackgroundColorG = Math.random()*255+','+Math.random()*255+','+Math.random()*255;
          me.varMesGasto.push(x.mes);
          me.varTotalGasto.push(x.total);
          me.backgroundcolorG.push('rgba('+me.varBackgroundColorG+',0.3)');
          me.hoverbackgroundcolorG.push('rgba('+me.varBackgroundColorG+',0.5)'); 
        });

        var mesInsGas =  (me.varMesGasto > me.varMesInscripcion) ? me.varMesGasto : me.varMesInscripcion;
        //console.log(mesInsGas);

        me.varInsGas=document.getElementById('chart_insgas').getContext('2d');//id canvas donde se mostrará el graf

        me.charInsGas = new Chart(me.varInsGas, {
          type: 'bar',
          data: {
            labels: mesInsGas, 
            datasets: [
              {
                label: 'Inscripciones',
                data: me.varTotalInscripcion,
                backgroundColor: me.backgroundcolorI,
                borderColor: me.hoverbackgroundcolorI,
                hoverBackgroundColor: me.hoverbackgroundcolorI,
                hoverBorderColor: me.backgroundcolorI,
                borderWidth: 1
              },{
                label: 'Gastos',
                data: me.varTotalGasto,
                backgroundColor: me.backgroundcolorG,
                borderColor: me.hoverbackgroundcolorG,
                hoverBackgroundColor: me.hoverbackgroundcolorG,
                hoverBorderColor: me.backgroundcolorG,
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
      }
    },
    mounted() {        
      this.listarInscripcionAlumno(1,this.buscar,this.criterio,this.paginado);
      this.widgetInOuts();
      this.getInsGas();        
    }
  }
</script>