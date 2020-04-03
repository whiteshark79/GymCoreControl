<template>

    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Gastos</h3></div>
                            <div class="card-tools">
                                <template v-if="listado!=0">
                                    <button type="button" class="btn btn-sm btn-primary" @click="mostrarDetalle()"><i class="icon-plus">  Nuevo Gasto</i></button>
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
                                                <option value="idproveedor">Proveedor</option>
                                                <option value="fecha_hora">Fecha</option>
                                                <option value="tipo_comprobante">Tipo Doc.</option>
                                                <option value="num_comprobante">Núm. Doc.</option>                                           
                                            </select>
                                            <template v-if="criterio=='idproveedor'">
                                                <div class="col-sm-3 col-md-3">                                                        
                                                    <v-select
                                                        id="buscar"
                                                        @search="selectProveedor"
                                                        label="nombre"
                                                        :options="arrayProveedor"
                                                        placeholder="Buscar Proveedores..."
                                                        @input="getDatosProveedor2"                                    
                                                    ></v-select>
                                                </div>
                                            </template> 
                                            <template v-else-if="criterio=='fecha_hora'">
                                                <input type="date" v-model="buscar" class="form-control  col-sm-3 col-md-3">
                                            </template>
                                            <template v-else-if="criterio=='tipo_comprobante'">
                                                <select class="form-control form-control-sm  col-sm-3 col-md-3" v-model="buscar">
                                                    <option value="FACTURA" selected>Factura</option>
                                                    <option value="NOTA">Nota</option>                                                
                                                </select>
                                            </template>
                                            <template v-else>
                                                <input type="number" v-model="buscar" @keyup.enter="listarGasto(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control  col-sm-3 col-md-3" placeholder="No del comprobante">
                                            </template>                                       
                                            <button type="submit" @click="listarGasto(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="icon-magnifier"></i> Buscar</button>
                                            <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="icon-reload"></i> </button>                             
                                        </div>
                                        <div class="input-group input-group-sm col-sm-1 col-md-1">                                     
                                        <select class="form-control" v-model="paginado" @change="listarGasto(1,buscar,criterio,paginado,ordenado,ascdesc)">
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
                                                <th scope="col" width="12%">FECHA
                                                    <template v-if="(ordenado !== 'fecha_hora' && ascdesc === 'asc') || (ordenado === 'fecha_hora' && ascdesc === 'desc') ">
                                                        <a href="#" @click="listarGasto(1,buscar,criterio,paginado,'fecha_hora','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'fecha_hora' && ascdesc === 'desc') || (ordenado === 'fecha_hora' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarGasto(1,buscar,criterio,paginado,'fecha_hora','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>
                                                <th scope="col" width="22%">PROVEEDOR
                                                    <template v-if="(ordenado !== 'idproveedor' && ascdesc === 'asc') || (ordenado === 'idproveedor' && ascdesc === 'desc')">
                                                        <a href="#" @click="listarGasto(1,buscar,criterio,paginado,'idproveedor','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'idproveedor' && ascdesc === 'desc') || (ordenado === 'idproveedor' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarGasto(1,buscar,criterio,paginado,'idproveedor','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>
                                                <th scope="col" width="13%">DOCUMENTO</th>                                         
                                                <th scope="col" width="7%">SUBTOTAL</th>
                                                <th scope="col" width="7%">IVA</th>
                                                <th scope="col" width="7%">TOTAL</th>
                                                <th scope="col" width="7%">ABONO
                                                    <template v-if="(ordenado !== 'abono' && ascdesc === 'asc') || (ordenado === 'abono' && ascdesc === 'desc')">
                                                        <a href="#" @click="listarVenta(1,buscar,criterio,paginado,'abono','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'abono' && ascdesc === 'desc') || (ordenado === 'abono' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarVenta(1,buscar,criterio,paginado,'abono','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>   
                                                <th scope="col" width="7%">SALDO</th>                                        
                                                <th scope="col" width="8%">ESTADO
                                                    <template v-if="(ordenado !== 'estado' && ascdesc === 'asc') || (ordenado === 'estado' && ascdesc === 'desc')">
                                                        <a href="#" @click="listarGasto(1,buscar,criterio,paginado,'estado','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'estado' && ascdesc === 'desc') || (ordenado === 'estado' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarGasto(1,buscar,criterio,paginado,'estado','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>                                                                                    
                                                <th scope="col" width="10%">ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayGasto.length">
                                            <tr v-for="gasto in arrayGasto" :key="gasto.id">
                                                <td scope="row" data-label="FECHA">{{ gasto.fecha_hora }}</td>
                                                <td data-label="PROVEEDOR">{{gasto.nombre}}</td>                        
                                                <td><span class="text-mini" data-label="DOCUMENTO">{{gasto.tipo_comprobante}}</span> :{{ gasto.serie_comprobante ? gasto.serie_comprobante+'-'+gasto.num_comprobante : '000-000' }} </td>
                                                <td align="right" data-label="SUBTOTAL">$ {{ (gasto.total-gasto.impuesto*gasto.total).toFixed(2) }}</td>
                                                <td align="right" data-label="IVA">$ {{ (gasto.impuesto*gasto.total).toFixed(2) }}</td>
                                                <td align="right" data-label="TOTAL">$ {{ gasto.total  }}</td>
                                                <td align="right" data-label="ABONO">$ {{ gasto.abono }}</td>
                                                <td align="right" data-label="SALDO">$ {{ (gasto.total-gasto.abono).toFixed(2) }}</td>
                                                <td align="center" data-label="ESTADO"> 
                                                    <div v-if="gasto.estado=='Cancelado'"><span class="badge badge-success">{{ gasto.estado }}</span></div>
                                                    <div v-if="gasto.estado=='Debe'"><span class="badge badge-warning">{{ gasto.estado }}</span></div>
                                                    <div v-if="gasto.estado=='Anulado'"><span class="badge badge-danger">{{ gasto.estado }}</span></div>                                    
                                                </td>
                                                <td align="center" data-label="ACCIONES">
                                                    <a class="btn btn-sm btn-default" @click="verGasto(gasto.id)"><i class="icon-eye"></i></a>                                   
                                                    <template v-if="gasto.estado=='Registrado'">
                                                        <a class="btn btn-sm btn-default" @click="desactivarGasto(gasto.id)"><i class="icon-ban" title="Desactivar"></i></a>  
                                                    </template> 
                                                </td>
                                            </tr>
                                        </tbody>
                                        <tbody v-else>
                                            <tr>
                                                <td colspan="10" class="text-center">
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
                                <div class="table-title">
                                    <div class="row">
                                        <div class="col-sm-6" ><h5>Nuevo <b>Gasto</b></h5></div>                                    
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-4">     
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h5 class="m-0">Datos</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-8">
                                                        <label for="">Proveedor<span class="text-error" v-show="idproveedor==''">(*)</span></label>
                                                        <v-select
                                                            @search="selectProveedor"
                                                            label="nombre"
                                                            :options="arrayProveedor"
                                                            placeholder="Buscar Proveedores..."
                                                            @input="getDatosProveedor" 
                                                            class="is-invalid"                                   
                                                        ></v-select>
                                                        <span class="text-error" v-show="e_idproveedor">Eligir proveedor</span>
                                                    </div> 
                                                    <div class="col-md-4">
                                                        <label>Comprobante<span class="text-error" v-show="tipo_comprobante==0">(*)</span></label>
                                                        <select class="form-control form-control-sm" v-model="tipo_comprobante" @change="cambioImpuesto()">
                                                            <option value="0" disabled>--Elegir tipo--</option>
                                                            <option value="NOTA">Nota</option>
                                                            <option value="FACTURA">Factura</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <template v-if="tipo_comprobante=='FACTURA'">
                                                    <div class="row">
                                                        <div class="col-md-4">
                                                            <label>Serie<span class="text-error" v-show="serie_comprobante==''">(*)</span></label>
                                                            <input type="number" class="form-control form-control-sm" v-bind:class="{ 'is-invalid': e_serie_comprobante }" v-model="serie_comprobante" placeholder="000x">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>Número<span class="text-error" v-show="num_comprobante==''">(*)</span></label>
                                                            <input type="number" class="form-control form-control-sm" v-bind:class="{ 'is-invalid': e_num_comprobante }" v-model="num_comprobante" placeholder="000xx">
                                                        </div>
                                                        <div class="col-md-4">
                                                            <label>IVA<span class="text-error" v-show="impuesto==''">(*)</span></label>
                                                            <input type="number" step="0.01" min="0" max="0.20" class="form-control form-control-sm" v-bind:class="{ 'is-invalid': e_impuesto }" v-model="impuesto">
                                                        </div>                                            
                                                    </div>
                                                </template>                                                                                   
                                            </div><!-- /.card -->
                                        </div>
                                    </div><!-- /.col-md-5 -->
                                    <div class="col-lg-8">           
                                        <div class="card card-primary card-outline">
                                            <div class="card-header">
                                                <h5 class="m-0">Detalle</h5>
                                            </div>
                                            <div class="card-body">
                                                <div class="row">
                                                    <div class="col-md-5">
                                                        <label>Servicio <span class="text-error" v-show="idservicio==0">(*)</span></label>
                                                        <div class="form-inline">
                                                            <input type="text" class="form-control form-control-sm" v-model="codigo" @keyup.enter="buscarServicio()" placeholder="Cód. servicio" size="10">
                                                            <button @click="abrirModal()" class="btn btn-primary btn-sm"><i class="icon-magnifier"></i></button>
                                                            <input type="text" readonly class="form-control form-control-sm" v-model="servicio" size="13">
                                                            <span class="text-info">{{descripcion}}</span>
                                                        </div>
                                                    </div>
                                                    
                                                    <div class="col-md-2 offset-md-2">
                                                        <label>Precio <span class="text-error" v-show="precio==0">(*)</span></label>
                                                        <input type="number" value="0" step="0.1" min="0" max="100" class="form-control form-control-sm" v-model="precio">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label>Cantidad <span class="text-error" v-show="cantidad==0">(*)</span></label>
                                                        <input type="number" value="0" step="1" min="0" max="100" class="form-control form-control-sm" v-model="cantidad">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button @click="agregarDetalle()" class="btn btn-primary btn-sm btnagregar"><i class="icon-plus"></i></button>
                                                    </div>
                                                </div>
                                                <hr>       
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-sm table-hover" id="dtTable">
                                                            <thead class="thead-light">
                                                                <tr align="center">                                            
                                                                    <th width="5%">Opc.</th>
                                                                    <th width="65%">Servicio</th>
                                                                    <th width="10%">Costo</th>
                                                                    <th width="10%">Cantidad</th>
                                                                    <th width="10%">Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody v-if="arrayDetalle.length">
                                                                <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                                                    <td><a href="#" @click="eliminarDetalle(index)"><i class="icon-trash"></i></a></td>                                                                 
                                                                    <td v-text="detalle.servicio"></td>
                                                                    <td><input v-model="detalle.precio" type="number" step="any" min="0.1" max="100" class="form-control form-control-sm"></td>
                                                                    <td><input v-model="detalle.cantidad" type="number" min="1" max="100" class="form-control form-control-sm"></td>
                                                                    <td align="right">$ {{(detalle.precio*detalle.cantidad).toFixed(2)}}</td>
                                                                </tr>                                                                
                                                            </tbody>
                                                            <tbody v-else>
                                                                <tr>
                                                                    <td colspan="5" class="text-center">
                                                                        <span class="badge badge-pill" v-bind:class="[ e_detalle ? 'badge-danger' : 'badge-secondary']">-- Sin registros --</span>                                       
                                                                    </td>
                                                                </tr>
                                                            </tbody>                                    
                                                        </table>
                                                        <table width="250" align="right" v-if="arrayDetalle.length">
                                                            <tr width="70%">
                                                                <td align="left"><strong>Abono:</strong></td>
                                                                <td align="right">                                                                        
                                                                    <input v-model="abono" type="number" step="0.1" min="0" :max="(total)" class="form-control form-control-sm"> 
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"><strong>Total Parcial:</strong></td>
                                                                <td align="right" class="w-25">$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                                                <td class="w-5"></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"><strong>Total Impuesto:</strong></td>
                                                                <td align="right">$ {{totalImpuesto=((total*impuesto)/(1+impuesto)).toFixed(2)}}</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"><strong>Total Neto:</strong></td>
                                                                <td align="right"><strong>$ {{total=(calcularTotal).toFixed(2)}} </strong> </td>
                                                                <td></td>
                                                            </tr>                                                       
                                                        </table>
                                                    </div>
                                                </div>                                                                                   
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary btn-sm">Cerrar</button>
                                                <button type="button" class="btn btn-primary btn-sm" @click="registrarGasto()">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                         
                        </template>
                        <!-- Fin Detalle -->

                        <!-- Ver gasto -->
                        <template v-else-if="listado==2">
                            <div class="card-body col-10 offset-md-1">   
                                <div class="invoice p-3 mb-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <i class="fas fa-shopping-basket"></i> Orden de compra
                                                <small class="float-right">Fecha: {{ hoyFecha() }} </small>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                    <h6>Proveedor</h6>                          
                                    <address>
                                        <strong>{{ proveedor }}</strong><br>
                                        Dirección: {{ direccion }}<br>
                                        Ciudad<br>
                                        Teléfono: {{ celular }}<br>
                                        Correo: {{ email }}
                                    </address>
                                    </div>
                                    <!-- /.col -->                                    
                                    <div class="col-sm-4 offset-sm-4 invoice-col">
                                    <b>{{ tipo_comprobante }}</b>  {{ serie_comprobante }} - {{ num_comprobante }}<br>
                                    <br>
                                    <b>ID:</b> {{ id }}<br>
                                    <b>Fecha: </b> {{ fecha_hora }}<br>
                                    <b>IVA:</b> {{ impuesto }}
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <div class="row">                                    
                                    <div class="col-12 table-responsive">         
                                        <div class="card card-primary card-outline">                                            
                                            <div class="card-body">                                                
                                                <div class="table-responsive col-md-12">
                                                    <table class="table table-bordered table-sm table-hover" id="dtTable">
                                                        <thead class="thead-light">
                                                            <tr align="center">                                            
                                                                <th style="width: 30%">Servicio</th>
                                                                <th style="width: 40%">Descripción</th>
                                                                <th width="4%">Cantidad</th>
                                                                <th>Precio</th>
                                                                <th>Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                                                <td v-text="detalle.servicio"></td>
                                                                <td v-text="detalle.servicio_descripcion"></td>
                                                                <td align="right" v-text="detalle.cantidad"></td>
                                                                <td align="right">$ {{ detalle.precio }}</td>                                                                
                                                                <td align="right">$ {{detalle.precio*detalle.cantidad}}</td>
                                                            </tr>                                                            
                                                            </tbody>                                                                                            
                                                        </table>
                                                        <table align="right" border="1" bordercolor="white" v-if="arrayDetalle.length">
                                                            <tr>
                                                                <td align="left"><strong>Total Parcial:</strong></td>
                                                                <td align="right">$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                                                <td class="w-5"></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"><strong>Total Impuesto:</strong></td>
                                                                <td align="right">$ {{totalImpuesto=((total*impuesto)).toFixed(2)}}</td>
                                                                <td></td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"><strong>Total Neto:</strong></td>
                                                                <td align="right">$ {{ total }}</td> 
                                                                <td></td>
                                                            </tr>                                                       
                                                        </table>
                                                    </div>
                                                </div>                                                                                  
                                            <div class="card-footer">
                                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary btn-sm float-right">Cerrar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>                                    
                            </div>
                        </template>
                        <!-- Fin Ver Gasto -->

                    </div>
                </div>
            </div>            
        </div>

        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <span class="modal-title text-title" v-text="tituloModal"></span>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group row">
                            <div class="col-md-8">
                                <div class="input-group">
                                    <select class="form-control form-control-sm col-md-6" v-model="criterioA">
                                        <option value="codigo">Código</option>
                                        <option value="nombre">Nombre</option>
                                        <option value="descripcion">Descripción</option>
                                        
                                    </select>
                                    <input type="text" v-model="buscarA" @keyup.enter="listarServicio(buscarA,criterioA)" class="form-control form-control-sm" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarServicio(buscarA,criterioA)" class="btn btn-primary btn-sm"><i class="icon-magnifier"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table-hover" id="dtTable">
                                <thead class="thead-table">
                                    <tr align="center">                                
                                        <th width="10%">COD</th>
                                        <th>NOMBRE</th>                             
                                        <th width="15%">ESTADO</th>                        
                                        <th width="10%">OPC.</th>
                                    </tr>
                                </thead>
                                <tbody v-if="arrayServicio.length">
                                    <tr v-for="servicio in arrayServicio" :key="servicio.id">                                                                
                                        <td v-text="servicio.codigo"></td>
                                        <td v-text="servicio.nombre"></td>
                                        <td align="center">
                                            <div v-if="servicio.condicion"><span class="badge badge-success">Activo</span></div>
                                            <div v-else><span class="badge badge-danger">Desactivo</span></div>                                    
                                        </td>
                                        <td align="center">
                                            <button type="button" @click="agregarDetalleModal(servicio)" class="btn btn-default btn-sm"><i class="far fa-check-circle"></i></button>
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
    import 'vue-select/dist/vue-select.css';
    import vSelect from 'vue-select';
    export default {
        data (){
            return {
                gasto_id: 0,
                idproveedor:0,
                id:'',
                proveedor:'',                
                direccion:'',
                celular:'',
                email:'',
                nombre : '',
                fecha_hora : '',
                tipo_comprobante : 'FACTURA',
                serie_comprobante : '',
                num_comprobante : '',
                impuesto: 0.12,
                total:0.0,
                abono:0.0,
                totalImpuesto: 0.0,
                totalParcial: 0.0,

                arrayGasto : [],
                arrayProveedor: [],
                arrayDetalle : [],

                listado:1,

                arrayServicio: [],
                idservicio: 0,
                codigo: '',
                servicio: '',
                descripcion: '',
                precio: 0,
                cantidad:0,          
                
                criterioA:'nombre',
                buscarA: '',

                modal : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorGasto : 0,
                errorMostrarMsjGasto : [],
                e_idproveedor : false,
                e_serie_comprobante : false,
                e_num_comprobante : false,
                e_impuesto : false,
                e_detalle : false,

                pagination : {
                    'total' : 0,
                    'current_page' : 0,
                    'per_page' : 0,
                    'last_page' : 0,
                    'from' : 0,
                    'to' : 0,
                },
                offset : 3,
                criterio : 'num_comprobante',
                buscar : '',
                paginado : 10,
                ordenado : 'id',
                ascdesc : 'desc'
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

            },
            calcularTotal: function(){
                let me=this;
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)
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
        
                return dd+'/'+mm+'/'+yyyy;      
            },            
            cambioImpuesto() { 
                let me = this;

                if(me.tipo_comprobante == 'NOTA'){ me.impuesto = 0.0
                }else{ me.impuesto = 0.12
                } 
            },
            listarGasto (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/gasto?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayGasto = respuesta.gastos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
                me.ordenado=ordenado;
                me.ascdesc=ascdesc;
            },
            selectProveedor(search,loading){
                let me=this;
                loading(true)

                var url= '/proveedor/selectProveedor?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayProveedor=respuesta.proveedores;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosProveedor(val1){
                let me = this;
                me.loading = true;
                me.idproveedor = val1.id;
            },
            getDatosProveedor2(val2){
                let me = this;
                me.loading = true;
                me.buscar = val2.id;
            },
            buscarServicio(){
                let me=this;
                var url= '/servicio/buscarServicio?filtro=' + me.codigo;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayServicio = respuesta.servicios;

                    if (me.arrayServicio.length>0){
                        me.servicio=me.arrayServicio[0]['nombre'];
                        me.idservicio=me.arrayServicio[0]['id'];
                        me.descripcion=me.arrayServicio[0]['descripcion'];
                        me.precio=1;
                        me.cantidad=1;
                    }
                    else{
                        me.servicio='No existe servicio';
                        me.idservicio=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            cambiarPagina(page,buscar,criterio,paginado,ordenado,ascdesc){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarGasto(page,buscar,criterio,paginado,ordenado,ascdesc);
            },
            existeServicio(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].idservicio==id){
                        sw=true;
                    }
                }
                return sw;
            },
            eliminarDetalle(index){
                let me = this;
                me.arrayDetalle.splice(index, 1);
            },
            agregarDetalle(){
                let me=this;
                if(me.idservicio==0 || me.cantidad==0 || me.precio==0){
                }
                else{
                    if(me.existeServicio(me.idservicio)){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'Ese servicio ya se encuentra agregado!',
                            })
                    }
                    else{
                       me.arrayDetalle.push({
                            idservicio: me.idservicio,
                            servicio: me.servicio,
                            cantidad: me.cantidad,
                            precio: me.precio
                        });
                        me.codigo="";
                        me.idservicio=0;
                        me.servicio="";
                        me.descripcion="";
                        me.cantidad=0;
                        me.precio=0; 
                    }                    
                }            
            },
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.existeServicio(data['id'])){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'Ese servicio ya se encuentra agregado!',
                            })
                    }
                    else{
                       me.arrayDetalle.push({
                            idservicio: data['id'],
                            servicio: data['nombre'],
                            cantidad: 1,
                            precio: 1
                        }); 
                    }
            },
            listarServicio (buscar,criterio){
                let me=this;
                var url= '/servicio/listarServicio?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayServicio = respuesta.servicios.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarGasto(){
                if (this.validarGasto()){
                    return;
                }
                
                let me = this;

                axios.post('/gasto/registrar',{
                    'idproveedor': this.idproveedor,
                    'tipo_comprobante': this.tipo_comprobante,
                    'serie_comprobante' : this.serie_comprobante,
                    'num_comprobante' : this.num_comprobante,
                    'impuesto' : this.impuesto,
                    'total' : this.total,
                    'abono' : this.abono,
                    'data': this.arrayDetalle

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
                    me.listarGasto(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc); 
                    me.idproveedor=0;
                    me.tipo_comprobante='FACTURA';
                    me.serie_comprobante='';
                    me.num_comprobante='';
                    me.impuesto=0.12;
                    me.total=0.0;
                    me.abono=0.0;
                    me.idservicio=0;
                    me.servicio='';
                    me.cantidad=0;
                    me.precio=0;
                    me.arrayDetalle=[];
                    

                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarGasto(){
                this.errorGasto=0;
                this.errorMostrarMsjGasto =[];

                if (this.idproveedor==0) {this.e_idproveedor = true; this.errorMostrarMsjGasto.push('idproveedor');}else{this.e_idproveedor = false}

                if(this.tipo_comprobante == 'FACTURA')
                {
                    if (this.serie_comprobante==0) {this.e_serie_comprobante = true; this.errorMostrarMsjGasto.push('serie_comprobante');}else{this.e_serie_comprobante = false}
                    if (this.num_comprobante==0) {this.e_num_comprobante = true; this.errorMostrarMsjGasto.push('num_comprobante');}else{this.e_num_comprobante = false}
                    if (!this.impuesto) {this.e_impuesto = true; this.errorMostrarMsjGasto.push('impuesto');}else{this.e_impuesto = false}
                }

                if (this.arrayDetalle.length<=0) {this.e_detalle = true; this.errorMostrarMsjGasto.push('detalle');}else{this.e_detalle = false}
                
                if (this.errorMostrarMsjGasto.length) this.errorGasto = 1;

                return this.errorGasto;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;

                this.e_idproveedor = false;
                this.e_serie_comprobante = false;
                this.e_num_comprobante = false;
                this.e_impuesto = false;
                this.e_detalle = false;

                me.idproveedor=0;
                me.tipo_comprobante='FACTURA';
                me.serie_comprobante='';
                me.num_comprobante='';
                me.impuesto=0.12;
                me.total=0.0;
                me.abono=0.0;
                me.idservicio=0;
                me.codigo='';
                me.descripcion='';
                me.servicio='';
                me.cantidad=0;
                me.precio=0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=1; 
            },
            verGasto(id){
                let me=this;
                me.listado=2;
                
                //Obtener los datos del gasto
                var arrayGastoT=[];
                var url= '/gasto/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayGastoT = respuesta.gasto;

                    me.id = arrayGastoT[0]['id'];
                    me.proveedor = arrayGastoT[0]['nombre'];
                    me.direccion = arrayGastoT[0]['direccion'];
                    me.celular = arrayGastoT[0]['celular'];
                    me.email = arrayGastoT[0]['email'];
                    me.tipo_comprobante=arrayGastoT[0]['tipo_comprobante'];
                    me.serie_comprobante=arrayGastoT[0]['serie_comprobante'];
                    me.num_comprobante=arrayGastoT[0]['num_comprobante'];
                    me.fecha_hora=arrayGastoT[0]['fecha_hora'];
                    me.impuesto=arrayGastoT[0]['impuesto'];
                    me.total=arrayGastoT[0]['total'];
                    me.abono=arrayGastoT[0]['abono'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= '/gasto/obtenerDetalles?id=' + id;
                
                axios.get(urld).then(function (response) {
                    console.log(response);
                    var respuesta= response.data;
                    me.arrayDetalle = respuesta.detalles;
                })
                .catch(function (error) {
                    console.log(error);
                });               
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';
            },
            abrirModal(){
                this.arrayServicio=[];
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios servicios';
            },
            desactivarGasto(id){
               Swal.fire({
                title: 'Anular el gasto?',
                icon: 'warning',
                width: 450,
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, desactivarla'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/gasto/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarGasto(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc);
                        Swal.fire(
                        'Desactivado!',
                        'El registro ha sido desactivado con éxito.',
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
                this.listarGasto(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
            }
        },
        mounted() {
            this.listarGasto(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>