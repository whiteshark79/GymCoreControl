<template>

    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Cuadres de Caja</h3></div>
                            <div class="card-tools">
                                <template v-if="listado!=0">
                                    <button type="button" class="btn btn-sm btn-primary" @click="mostrarDetalle('')" v-if="btnActivo==0"><i class="fas fa-plus-circle">  Nuevo Cuadre </i></button>
                                </template>
                            </div>
                        </div>                      
 
                        <!-- Listado -->
                        <template v-if="listado==1">
                            <div class="card-body">
                                <div class="form-group row justify-content-between">
                                    <div class="row col-sm-12 col-md-12">
                                        <div class="input-group input-group-sm col-sm-11 col-md-11">                                
                                            <select class="form-control col-sm-3 col-md-2" v-model="criterio" @change="ceroBusqueda();">
                                                <option value="fecha_hora">Fecha</option>                                   
                                            </select> 
                                            <input type="date" v-model="buscar" class="form-control col-sm-3 col-md-3">                                                                          
                                            <button type="submit" @click="listarCuadreCaja(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>                                 
                                            <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="fas fa-redo"></i> </button>
                                        </div>
                                        
                                        <div class="input-group input-group-sm col-sm-1 col-md-1">                                     
                                            <select class="form-control col-sm-6 col-md-12" v-model="paginado" @change="listarCuadreCaja(1,buscar,criterio,paginado,ordenado,ascdesc)">
                                            <option value="10">10</option>
                                            <option value="25">25</option>
                                            <option value="50">50</option>
                                            </select>
                                        </div>
                                    </div>

                                </div>

                                <div class="table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-sm table-hover" id="dtTable">
                                        <thead  class="thead-table">
                                            <tr align="center">
                                                <th scope="col" width="3%">#</th>
                                                <th scope="col" width="12%">FECHA
                                                    <template v-if="(ordenado !== 'fecha_hora' && ascdesc === 'asc') || (ordenado === 'fecha_hora' && ascdesc === 'desc') ">
                                                        <a href="#" @click="listarCuadreCaja(1,buscar,criterio,paginado,'fecha_hora','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'fecha_hora' && ascdesc === 'desc') || (ordenado === 'fecha_hora' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarCuadreCaja(1,buscar,criterio,paginado,'fecha_hora','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>
                                                <th scope="col" width="14%">INSCRIPCIONES</th>                                                                                                                                        
                                                <th scope="col" width="14%">GASTOS</th>
                                                <th scope="col" width="14%">VENTAS</th>
                                                <th scope="col" width="14%">COMPRAS</th>
                                                <th scope="col" width="17%">TOTAL</th>                                                          
                                                <th scope="col" width="10%">ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayCaja.length">
                                            <tr v-for="caja in arrayCaja" :key="caja.id">
                                                <td align="center" v-text="caja.id" scope="row" data-label="#"></td>
                                                <td align="center" v-text="caja.fecha_hora" data-label="FECHA"></td>
                                                <td align="right" data-label="INSCRIPCIONES"><small>$</small> {{ caja.inscripciones }}</td>
                                                <td align="right" data-label="GASTOS"><small>$</small> {{ caja.gastos }}</td>
                                                <td align="right" data-label="VENTAS"><small>$</small> {{ caja.ventas  }}</td>
                                                <td align="right" data-label="COMPRAS"><small>$</small> {{ caja.compras }}</td>
                                                <td align="right" data-label="TOTAL"><small>$</small> {{ caja.total  }}<i class="fas fa-sort-up" style="color:green;" v-if="caja.total>0"></i><i class="fas fa-sort-down" style="color:red;" v-else></i></td>                                                
                                                <td align="center" data-label="ACCIONES">
                                                    <a class="btn btn-sm btn-default" @click="mostrarDetalle(caja.fecha_hora)"><i class="far fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-default" @click="pdfCaja(caja.fecha_hora)"><i class="fas fa-print"></i></a>                        
                                                    <template v-if="caja.estado=='Cancelado'">
                                                        <a class="btn btn-sm btn-default" @click="desactivarVenta(caja.id)"><i class="fas fa-ban" title="Desactivar"></i></a>  
                                                    </template> 
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
                        </template>
                        <!-- Fin Listado -->

                        <!-- Detalle -->
                        <template v-else-if="listado==0">     
                            <div class="card-body">                                
                                <div class="row">
                                    <div class="col-lg-6">     
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">Ingresos</h3>
                                                <!-- card tools -->
                                                <div class="card-tools">
                                                <h3><span class="badge badge-success"><small>$</small>{{ valIngresos = (parseFloat(inscripcionesDeudaMes) + parseFloat(ventasDeudaMes)) }}</span></h3>
                                                </div>
                                                <!-- /.card-tools -->
                                            </div>
                                                <div class="card-body">
                                                
                                                    <ul class="nav nav-tabs" id="myTab" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="inscripcion-tab" data-toggle="tab" href="#inscripcion" role="tab" aria-controls="inscripcion" aria-selected="true"><h6>Inscripciones</h6></a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="venta-tab" data-toggle="tab" href="#venta" role="tab" aria-controls="venta" aria-selected="false"><h6>Ventas</h6></a>
                                                        </li>                                                    
                                                    </ul>
                                                    <div class="tab-content" id="myTabContent">
                                                        <div class="tab-pane fade show active" id="inscripcion" role="tabpanel" aria-labelledby="inscripcion-tab">

                                                            <div class="table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar_">
                                                                <table class="table table-bordered table-sm table-hover" id="dtTable">
                                                                    <thead  class="thead-table">
                                                                        <tr align="center">
                                                                            <th width="40%">ALUMNO</th> 
                                                                            <th width="12%">SUBTOTAL</th>
                                                                            <th width="12%">IVA</th>
                                                                            <th width="12%">TOTAL</th>
                                                                            <th width="12%">ABONO</th>
                                                                            <th width="12%">SALDO</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody v-if="arrayInscripcionesC.length">
                                                                        <tr v-for="inscripcionC in arrayInscripcionesC" :key="inscripcionC.id">
                                                                            <td>{{inscripcionC.alumno}}</td>
                                                                            <td align="right"><small>$</small> {{ (inscripcionC.total-inscripcionC.impuesto*inscripcionC.total).toFixed(2) }}</td>
                                                                            <td align="right"><small>$</small> {{ (inscripcionC.impuesto*inscripcionC.total).toFixed(2) }}</td>
                                                                            <td align="right"><small>$</small> {{ inscripcionC.total }}</td> 
                                                                            <td align="right"><small>$</small> {{ inscripcionC.abono }}</td>
                                                                            <td align="right"><small>$</small> {{ (inscripcionC.total-inscripcionC.abono).toFixed(2) }}</td> 
                                            
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
                                                            <table width="150" align="right">                                                                
                                                                <tr>
                                                                    <td align="left"><strong>Cancelado:</strong></td>
                                                                    <td align="right"><small>$</small> {{ inscripcionesValorMes }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left"><strong>Deuda:</strong></td>
                                                                    <td align="right"><small>$</small> {{ (inscripcionesValorMes-inscripcionesDeudaMes).toFixed(2) }}</td>
                                                                </tr>  
                                                                <tr>
                                                                    <td align="left"><strong>Total:</strong></td>
                                                                    <td align="right" style="border-top-style: solid;"><small>$</small> {{ inscripcionesDeudaMes }}</td>
                                                                </tr>                                                                                                                    
                                                            </table>

                                                        </div>
                                                        <div class="tab-pane fade" id="venta" role="tabpanel" aria-labelledby="venta-tab">

                                                            <div class="table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar_">
                                                                <table class="table table-bordered table-sm table-hover" id="dtTable">
                                                                    <thead  class="thead-table">
                                                                        <tr align="center">
                                                                            <th width="40%">CLIENTE</th> 
                                                                            <th width="12%">SUBTOTAL</th>
                                                                            <th width="12%">IVA</th>
                                                                            <th width="12%">TOTAL</th>
                                                                            <th width="12%">ABONO</th>
                                                                            <th width="12%">SALDO</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody v-if="arrayVentasC.length">
                                                                        <tr v-for="ventaC in arrayVentasC" :key="ventaC.id">
                                                                            <td>{{ventaC.cliente}}</td>
                                                                            <td align="right"><small>$</small> {{ (ventaC.total-ventaC.impuesto*ventaC.total).toFixed(2) }}</td>
                                                                            <td align="right"><small>$</small> {{ (ventaC.impuesto*ventaC.total).toFixed(2) }}</td>
                                                                            <td align="right"><small>$</small> {{ ventaC.total }}</td>
                                                                            <td align="right"><small>$</small> {{ ventaC.abono }}</td>
                                                                            <td align="right"><small>$</small> {{ (ventaC.total-ventaC.abono).toFixed(2) }}</td>                                                           
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
                                                            <table width="150" align="right">                                                                
                                                                <tr>
                                                                    <td align="left"><strong>Cancelado:</strong></td>
                                                                    <td align="right"><small>$</small> {{ ventasValorMes }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left"><strong>Deuda:</strong></td>
                                                                    <td align="right"><small>$</small> {{ (ventasValorMes-ventasDeudaMes).toFixed(2) }}</td>
                                                                </tr>  
                                                                <tr>
                                                                    <td align="left"><strong>Total:</strong></td>
                                                                    <td align="right" style="border-top-style: solid;"><small>$</small> {{ ventasDeudaMes }}</td>
                                                                </tr>                                                                                                                    
                                                            </table>
                                                            

                                                        </div>
                                                    </div>
                                                </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-6">           
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h3 class="card-title">Egresos</h3>
                                                <!-- card tools -->
                                                <div class="card-tools">
                                                <h3><span class="badge badge-warning"><small>$</small>{{ valEgresos = (parseFloat(gastosDeudaMes) + parseFloat(ingresosDeudaMes)) }}</span></h3>
                                                </div>
                                                <!-- /.card-tools -->
                                            </div>
                                            <div class="card-body">

                                                <ul class="nav nav-tabs" id="myTab_" role="tablist">
                                                        <li class="nav-item">
                                                            <a class="nav-link active" id="gasto-tab" data-toggle="tab" href="#gasto" role="tab" aria-controls="gasto" aria-selected="true"><h6>Gastos</h6></a>
                                                        </li>
                                                        <li class="nav-item">
                                                            <a class="nav-link" id="ingreso-tab" data-toggle="tab" href="#ingreso" role="tab" aria-controls="ingreso" aria-selected="false"><h6>Compras</h6></a>
                                                        </li>                                                    
                                                    </ul>
                                                    <div class="tab-content" id="myTabContent_">
                                                        <div class="tab-pane fade show active" id="gasto" role="tabpanel" aria-labelledby="gasto-tab">

                                                            <div class="table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar_">
                                                                <table class="table table-bordered table-sm table-hover" id="dtTable">
                                                                    <thead  class="thead-table">
                                                                        <tr align="center">
                                                                            <th width="40%">PROVEEDOR</th> 
                                                                            <th width="12%">SUBTOTAL</th>
                                                                            <th width="12%">IVA</th>
                                                                            <th width="12%">TOTAL</th>
                                                                            <th width="12%">ABONO</th>
                                                                            <th width="12%">SALDO</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody v-if="arrayGastosC.length">
                                                                        <tr v-for="gastoC in arrayGastosC" :key="gastoC.id">
                                                                            <td>{{gastoC.proveedor}}</td>
                                                                            <td align="right"><small>$</small> {{ (gastoC.total-gastoC.impuesto*gastoC.total).toFixed(2) }}</td>
                                                                            <td align="right"><small>$</small> {{ (gastoC.impuesto*gastoC.total).toFixed(2) }}</td>
                                                                            <td align="right"><small>$</small> {{ gastoC.total }}</td> 
                                                                            <td align="right"><small>$</small> {{ gastoC.abono }}</td>
                                                                            <td align="right"><small>$</small> {{ (gastoC.total-gastoC.abono).toFixed(2) }}</td>                                                          
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
                                                            <table width="150" align="right">                                                                
                                                                <tr>
                                                                    <td align="left"><strong>Cancelado:</strong></td>
                                                                    <td align="right"><small>$</small> {{ gastosValorMes }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left"><strong>Deuda:</strong></td>
                                                                    <td align="right"><small>$</small> {{ (gastosValorMes-gastosDeudaMes).toFixed(2) }}</td>
                                                                </tr>   
                                                                <tr>
                                                                    <td align="left"><strong>Total:</strong></td>
                                                                    <td align="right" style="border-top-style: solid;"><small>$</small> {{ gastos = gastosDeudaMes }}</td>
                                                                </tr>                                                                                                                   
                                                            </table>

                                                        </div>
                                                        <div class="tab-pane fade" id="ingreso" role="tabpanel" aria-labelledby="ingreso-tab">

                                                            <div class="table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar_">
                                                                <table class="table table-bordered table-sm table-hover" id="dtTable">
                                                                    <thead  class="thead-table">
                                                                        <tr align="center">
                                                                            <th width="40%">PROVEEDOR</th> 
                                                                            <th width="12%">SUBTOTAL</th>
                                                                            <th width="12%">IVA</th>
                                                                            <th width="12%">TOTAL</th>
                                                                            <th width="12%">ABONO</th>
                                                                            <th width="12%">SALDO</th>
                                                                        </tr>
                                                                    </thead>
                                                                    <tbody v-if="arrayIngresosC.length">
                                                                        <tr v-for="ingresoC in arrayIngresosC" :key="ingresoC.id">
                                                                            <td>{{ingresoC.proveedor}}</td>
                                                                            <td align="right"><small>$</small> {{ (ingresoC.total-ingresoC.impuesto*ingresoC.total).toFixed(2) }}</td>
                                                                            <td align="right"><small>$</small> {{ (ingresoC.impuesto*ingresoC.total).toFixed(2) }}</td>
                                                                            <td align="right"><small>$</small> {{ ingresoC.total }}</td>                                                                             
                                                                            <td align="right"><small>$</small> {{ ingresoC.abono }}</td>
                                                                            <td align="right"><small>$</small> {{ (ingresoC.total-ingresoC.abono).toFixed(2) }}</td>                                                            
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
                                                            <table width="150" align="right">                                                                
                                                                <tr>
                                                                    <td align="left"><strong>Cancelado:</strong></td>
                                                                    <td align="right"><small>$</small> {{ ingresosValorMes }}</td>
                                                                </tr>
                                                                <tr>
                                                                    <td align="left"><strong>Deuda:</strong></td>
                                                                    <td align="right"><small>$</small> {{ (ingresosValorMes-ingresosDeudaMes).toFixed(2) }}</td>
                                                                </tr>   
                                                                <tr>
                                                                    <td align="left"><strong>Total:</strong></td>
                                                                    <td align="right" style="border-top-style: solid;"><small>$</small> {{ ingresos = ingresosDeudaMes }}</td>
                                                                </tr>                                                                                                                   
                                                            </table>

                                                        </div>
                                                    </div>
                                                                                                                                  
                                            </div>                                            
                                        </div>
                                    </div>
                                </div>                                
                            </div> 
                            <div class="card-footer text-center">                                
                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary btn-sm">Cerrar</button>
                                <template v-if="btnSave==0">
                                    <button type="button" class="btn btn-primary btn-sm" @click="registrarCuadreCaja()">Guardar</button>   
                                    <div class="custom-control custom-checkbox float-right">
                                        <input class="custom-control-input" type="checkbox" id="cbPdf" value="1" v-model="cbPdf">
                                        <label for="cbPdf" class="custom-control-label">Generar PDF</label>
                                    </div>
                                </template>
                                                               
                            </div>                       
                        </template>
                        <!-- Fin Detalle -->
                        

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
                arrayCaja : [],

                arrayVentasC : [],
                arrayInscripcionesC : [],
                arrayGastosC : [],
                arrayIngresosC : [],
                arrayIngresosCancelado : [],
                arrayIngresosDeuda : [],
                arrayEgresosCancelado : [],
                arrayEgresosDeuda : [],

                
                ventasValorMes :0,
                inscripcionesValorMes :0,              
                ventasDeudaMes :0,
                inscripcionesDeudaMes :0,              
                gastosValorMes :0,
                ingresosValorMes :0,               
                gastosDeudaMes :0,
                ingresosDeudaMes :0,   

                valIngresos :0.0,
                valEgresos :0.0,
               
                listado:1,
                btnSave:0,
                btnActivo:0,
                
                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },                
                offset : 3,
                criterio : 'fecha_hora',
                buscar : '',
                cbPdf : 0,
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
            hoyFecha(){
                var hoy = new Date();
                var dd = hoy.getDate();
                var mm = hoy.getMonth()+1;
                var yyyy = hoy.getFullYear();

                if(dd < 10) dd = '0'+dd;
                if(mm < 10) mm = '0'+mm;
        
                return yyyy+'-'+mm+'-'+dd;      
            }, 
            listarCuadreCaja (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/caja?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayCaja = respuesta.cajas.data;
                    me.pagination= respuesta.pagination;
                    me.btnActivo= respuesta.activo;
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
                me.listarCuadreCaja(page,buscar,criterio,paginado,ordenado,ascdesc);
            },   
            registrarCuadreCaja(){                
                
                let me = this;

                axios.post('/caja/registrar',{
                    'inscripciones': this.inscripcionesDeudaMes,
                    'gastos' : this.gastosDeudaMes,
                    'ventas' : this.ventasDeudaMes,
                    'compras' : this.ingresosDeudaMes,
                    'total' : (parseFloat(this.inscripcionesDeudaMes) + parseFloat(this.ventasDeudaMes)) - (parseFloat(this.gastosDeudaMes) + parseFloat(this.ingresosDeudaMes))

                }).then(function (response) {
                    me.listado=1;
                    Swal.fire({
                        position: 'top-end',
                        icon: 'success',
                        title: '<h5>Registro creado</h5>',
                        width: 250,
                        showConfirmButton: false,
                        timer: 1500
                    })
                    me.listarCuadreCaja(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc); 
                    me.inscripciones=0.0;
                    me.gastos=0.0;
                    me.ventas=0.0;
                    me.compras=0.0;
                    me.total=0.0;  

                    if(me.cbPdf) { 
                        window.open('caja/pdf/'+me.hoyFecha());
                    }                   
                    

                }).catch(function (error) {
                    console.log(error);
                });
            },           
            mostrarDetalle(fecha){
                let me=this;
                me.listado=0;

                if(fecha){
                    var urlvc= '/venta/listarVentasDiario?fecha=' + fecha;
                    var urlic= '/inscripcion/listarInscripcionesDiario?fecha=' + fecha;
                    var urlgc= '/gasto/listarGastosDiario?fecha=' + fecha;
                    var urlinc= '/ingreso/listarIngresosDiario?fecha=' + fecha;
                    var urlie= '/caja/InsOuts?fecha=' + fecha;
                    me.btnSave = 1;
                }else{
                    var urlvc= '/venta/listarVentasDiario';
                    var urlic= '/inscripcion/listarInscripcionesDiario';
                    var urlgc= '/gasto/listarGastosDiario';
                    var urlinc= '/ingreso/listarIngresosDiario';
                    var urlie= '/caja/InsOuts';

                }

                
                axios.get(urlvc).then(function (response) {
                    var respuesta_vc= response.data;
                    me.arrayVentasC = respuesta_vc.ventasDia;
                })
                .catch(function (error) {
                    console.log(error);
                });        

                
                axios.get(urlic).then(function (response) {
                    var respuesta_ic= response.data;
                    me.arrayInscripcionesC = respuesta_ic.inscripcionesDia;
                })
                .catch(function (error) {
                    console.log(error);
                }); 

                
                axios.get(urlgc).then(function (response) {
                    var respuesta_gc= response.data;
                    me.arrayGastosC = respuesta_gc.gastosDia;
                })
                .catch(function (error) {
                    console.log(error);
                }); 

                
                axios.get(urlinc).then(function (response) {
                    var respuesta_inc= response.data;
                    me.arrayIngresosC = respuesta_inc.ingresosDia;
                })
                .catch(function (error) {
                    console.log(error);
                }); 

                
                axios.get(urlie).then(function (response) {
                    var respuesta_vic= response.data;
                    var respuesta_vid= response.data;
                    var respuesta_vec= response.data;
                    var respuesta_ved= response.data;                    
                    me.arrayIngresosCancelado = respuesta_vic.ingresosCancelado;
                    me.arrayIngresosDeuda = respuesta_vid.ingresosDeuda;
                    me.arrayEgresosCancelado = respuesta_vec.egresosCancelado;
                    me.arrayEgresosDeuda = respuesta_ved.egresosDeuda;

                    me.loadInOuts(); 
                })
                .catch(function (error) {
                    console.log(error);
                });      
            },
            loadInOuts(){
                let me=this;

                me.arrayIngresosCancelado.map(function(w){
                me.ventasValorMes = w.ventasValorMes;
                me.inscripcionesValorMes = w.inscripcionesValorMes;
                });

                me.arrayIngresosDeuda.map(function(x){
                me.ventasDeudaMes = x.ventasDeudaMes;
                me.inscripcionesDeudaMes = x.inscripcionesDeudaMes;
                });

                me.arrayEgresosCancelado.map(function(y){
                me.gastosValorMes = y.gastosValorMes;
                me.ingresosValorMes = y.ingresosValorMes;
                });

                me.arrayEgresosDeuda.map(function(z){
                me.gastosDeudaMes = z.gastosDeudaMes;
                me.ingresosDeudaMes = z.ingresosDeudaMes;
                });
            },
            ocultarDetalle(){
                this.listado=1;
            },  
            pdfCaja(fecha){
                window.open('http://localhost:8000/caja/pdf/'+fecha+','+'_blank');
            },
            desactivarVenta(id){
               Swal.fire({
                title: 'Anular la caja?',
                icon: 'warning',
                width: 450,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, anular'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/caja/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarCuadreCaja(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc);
                        Swal.fire(
                        'Desactivado!',
                        'El registro ha sido anulado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } 
                }) 
            },
            ceroBusqueda(){
                this.buscar='';
                this.listarCuadreCaja(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
            }
        },
        mounted() {
            this.listarCuadreCaja(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>