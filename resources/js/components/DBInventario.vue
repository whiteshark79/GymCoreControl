<template>
 
    <main class="main">
        <div class="container-fluid">

            <div class="row mt-1">
                <div class="col-md-6">
                    <div class="card callout callout-primary">
                        <div class="card-header">
                        <h4>Porcentaje de Ventas</h4>                 
                        </div>                      
                        <div class="card-content">
                            <div class="ct-chart">
                                <canvas id="chart_articulos">                                                
                                </canvas>
                            </div>                        
                        </div>                          
                                        
                    </div>
                </div>

                <div class="col-md-6">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-title"><h3>Artículos</h3></div> 
                        </div>
                        <div class="card-body">
                            <div class="form-group row justify-content-between">
                                <div class="input-group input-group-sm col-10">                                
                                    <select class="form-control col-3 " v-model="criterio"  @onchange="ceroBusqueda();"> 
                                        <option value="nombre">Articulo</option>
                                        <option value="fecha_hora">Mes</option>
                                    </select>
                                    <template v-if="criterio=='nombre'">
                                        <input type="text" v-model="buscar" @keyup.enter="listarArticuloVenta(1,buscar,criterio,paginado)" class="form-control col-5" placeholder="Artículo a buscar">
                                    </template>
                                    <template v-if="criterio=='fecha_hora'">
                                        <select class="form-control col-5" v-model="buscar"> 
                                            <option value="">--Seleccione--</option>                                                              
                                            <option v-for="mes in arrayMeses" :key="mes.id" :value="mes.id" v-text="mes.nombre"></option>
                                        </select>
                                    </template>                          
                                    
                                    <button type="submit" @click="listarArticuloVenta(1,buscar,criterio,paginado)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>
                                    <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="fas fa-redo"></i> </button>                                   
                                </div>
                                <div class="input-group input-group-sm  col-2">                                     
                                    <select class="form-control" v-model="paginado" @change="listarArticuloVenta(1,buscar,criterio,paginado)">
                                    <option value="10">10</option>
                                    <option value="25">25</option>
                                    <option value="50">50</option>
                                    </select>
                                </div>
                            </div> 
                            <div class="table-responsive-sm table-wrapper-scroll-y my-custom-mini-scrollbar_">
                                <table class="table table-bordered table-sm table-hover" id="dtTable">
                                    <thead  class="thead-table"> 
                                        <tr align="center">
                                            <th width="20%">MES</th>
                                            <th >ARTICULO</th>
                                            <th width="10%">SUBTOTAL</th>
                                            <th width="10%">OPC</th>                                     
                                        </tr> 
                                    </thead>
                                    <tbody v-if="arrayArticuloVenta.length">
                                        <tr v-for="venta in arrayArticuloVenta" :key="venta.id">
                                            <td v-text="venta.mes"></td>
                                            <td v-text="venta.nombre_articulo"></td>
                                            <td align="right" width="5%">$ {{venta.subtotal}}</td>
                                            <td align="center">
                                                <a class="btn btn-sm btn-default" @click="verGraf()"><i class="fas fa-chart-pie" title="Grafico"></i></a>
                                            </td>
                                        </tr>
                                    </tbody>
                                    <tbody v-else>
                                        <tr>
                                            <td colspan="8" class="text-center">
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
    export default {
        data (){            
            return {                
                arrayArticuloVenta : [],
                mes : '',
                nombre_articulo : '',
                subtotal : 0,
                arrayMeses: [],
                varArticulo:null,
                charArticulo:null,
                articulos:[],
                varNombreArticulo:[],
                varSubtotalArticulo:[],
                varCntArticulo:0,                
                
                varBackgroundColor:'',
                backgroundcolor:[],
                hoverbackgroundcolor:[],       
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
                paginado : 10
                
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
            cambiarPagina(page,buscar,criterio,paginado){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarArticuloVenta(page,buscar,criterio,paginado);
            },
            listarArticuloVenta(page,buscar,criterio,paginado){
                let me=this;
                var url= '/venta/listarArticuloVenta?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticuloVenta = respuesta.detallesA.data;
                    me.pagination= respuesta.pagination; 
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            selectMeses(){
                let me=this;
                var url= '/venta/mesVenta';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayMeses = respuesta.mesVentaArray;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },            
            getArticulos(){
                let me=this;
                var url= '/dashboard/grafArticulo';                
                axios.get(url).then(function (response) {
                var respuesta= response.data;
                me.articulos = respuesta.articulos;
                //cargamos los datos del chart
                me.loadArticulos();
                })
                .catch(function (error) {
                    console.log(error);
                });               
            },
            loadArticulos(){
                let me=this;
                me.articulos.map(function(x){
                    me.varBackgroundColor = Math.random()*255+','+Math.random()*255+','+Math.random()*255;
                    me.varNombreArticulo.push(x.articulo);
                    me.varSubtotalArticulo.push(x.subtotal);
                    me.backgroundcolor.push('rgba('+me.varBackgroundColor+',0.3)');
                    me.hoverbackgroundcolor.push('rgba('+me.varBackgroundColor+',0.5)'); 
                });
                
                me.varArticulo=document.getElementById('chart_articulos').getContext('2d');
                me.charArticulo = new Chart(me.varArticulo, {
                    type: 'doughnut',
                    data: {
                        labels: me.varNombreArticulo,
                        datasets: [{
                            label: 'Articulos',
                            data: me.varSubtotalArticulo,
                            backgroundColor: me.backgroundcolor,
                            borderColor: me.hoverbackgroundcolor,
                            hoverBackgroundColor: me.hoverbackgroundcolor,
                            hoverBorderColor: me.backgroundcolor,
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
            ceroBusqueda(){
                this.buscar='';
                this.listarArticuloVenta(1,this.buscar,this.criterio,this.paginado);
            }                     
        },
        mounted() {
            this.selectMeses();
            this.getArticulos();
            this.listarArticuloVenta(1,this.buscar,this.criterio,this.paginado);
        }
    }
</script>