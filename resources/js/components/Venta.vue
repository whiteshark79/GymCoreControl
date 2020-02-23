<template>

    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Ventas</h3></div>
                            <div class="card-tools">
                                <template v-if="listado!=0">
                                    <button type="button" class="btn btn-sm btn-primary" @click="mostrarDetalle()"><i class="fas fa-plus-circle">  Nueva Venta</i></button>
                                </template>
                            </div>
                        </div>                      
 
                        <!-- Listado -->
                        <template v-if="listado==1">
                            <div class="card-body">
                                <div class="form-group row justify-content-between">
                                    <div class="input-group input-group-sm col-7">                                
                                        <select class="form-control col-2 " v-model="criterio" @change="ceroBusqueda();">>
                                            <option value="idcliente">Cliente</option>
                                            <option value="fecha_hora">Fecha</option>
                                            <option value="tipo_comprobante">Tipo Doc.</option>
                                            <option value="num_comprobante">Núm. Doc.</option>                                           
                                        </select>
                                        <template v-if="criterio=='idcliente'">
                                            <div class="col-md-4">                                                        
                                                <v-select
                                                    id="buscar"
                                                    @search="selectCliente"
                                                    label="nombre"
                                                    :options="arrayCliente"
                                                    placeholder="Buscar Cliente..."
                                                    @input="getDatosCliente2"                                    
                                                ></v-select>
                                            </div>
                                        </template>
                                        <template v-else-if="criterio=='fecha_hora'">
                                            <input type="date" v-model="buscar" class="form-control col-4">
                                        </template>
                                        <template v-else-if="criterio=='tipo_comprobante'">
                                            <select class="form-control form-control-sm col-4" v-model="buscar">
                                                <option value="FACTURA" selected>Factura</option>
                                                <option value="NOTA">Nota</option>                                                
                                            </select>
                                        </template>
                                        <template v-else>
                                            <input type="number" v-model="buscar" @keyup.enter="listarVenta(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control col-4" placeholder="No del comprobante">
                                        </template>                                       
                                        <button type="submit" @click="listarVenta(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>                                 
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="input-group input-group-sm col-1">                                     
                                        <select class="form-control" v-model="paginado" @change="listarVenta(1,buscar,criterio,paginado,ordenado,ascdesc)">
                                        <option value="10">10</option>
                                        <option value="25">25</option>
                                        <option value="50">50</option>
                                        </select>
                                    </div>
                                </div>

                                <div class="table-responsive-sm table-wrapper-scroll-y my-custom-scrollbar">
                                    <table class="table table-bordered table-sm table-hover" id="dtTable">
                                        <thead  class="thead-table">
                                            <tr align="center">
                                                <th width="14%">FECHA
                                                    <template v-if="(ordenado !== 'fecha_hora' && ascdesc === 'asc') || (ordenado === 'fecha_hora' && ascdesc === 'desc') ">
                                                        <a href="#" @click="listarVenta(1,buscar,criterio,paginado,'fecha_hora','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'fecha_hora' && ascdesc === 'desc') || (ordenado === 'fecha_hora' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarVenta(1,buscar,criterio,paginado,'fecha_hora','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>
                                                <th width="25%">CLIENTE
                                                    <template v-if="(ordenado !== 'idcliente' && ascdesc === 'asc') || (ordenado === 'idcliente' && ascdesc === 'desc')">
                                                        <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'idcliente','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'idcliente' && ascdesc === 'desc') || (ordenado === 'idcliente' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarPersona(1,buscar,criterio,paginado,'idcliente','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>                                                                                                                                        
                                                <th width="16%">DOCUMENTO</th>
                                                <th width="6%">SUBTOTAL</th>
                                                <th width="6%">IVA</th>
                                                <th width="6%">TOTAL</th>
                                                <th width="6%">ABONO
                                                    <template v-if="(ordenado !== 'abono' && ascdesc === 'asc') || (ordenado === 'abono' && ascdesc === 'desc')">
                                                        <a href="#" @click="listarVenta(1,buscar,criterio,paginado,'abono','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'abono' && ascdesc === 'desc') || (ordenado === 'abono' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarVenta(1,buscar,criterio,paginado,'abono','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>                                            
                                                <th width="9%">ESTADO
                                                    <template v-if="(ordenado !== 'estado' && ascdesc === 'asc') || (ordenado === 'estado' && ascdesc === 'desc')">
                                                        <a href="#" @click="listarVenta(1,buscar,criterio,paginado,'estado','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'estado' && ascdesc === 'desc') || (ordenado === 'estado' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarVenta(1,buscar,criterio,paginado,'estado','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>                                                                                    
                                                <th width="12%">ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayVenta.length">
                                            <tr v-for="venta in arrayVenta" :key="venta.id">
                                                <td v-text="venta.fecha_hora"></td>
                                                <td>{{venta.nombre}}</td> 
                                                <td><span class="text-mini">{{venta.tipo_comprobante}}</span> : {{ venta.serie_comprobante ? venta.serie_comprobante+'-'+venta.num_comprobante : '000-000' }} </td>
                                                <td align="right">$ {{ (venta.total-venta.impuesto*venta.total).toFixed(2) }}</td>
                                                <td align="right">$ {{ (venta.impuesto*venta.total).toFixed(2) }}</td>
                                                <td align="right">$ {{ venta.total  }}</td>
                                                <td align="right">$ {{ venta.abono  }}<template v-if="venta.abono < venta.total"><span class="badge badge-warning">D</span></template></td>
                                                <td align="center"> 
                                                    <div v-if="venta.estado=='Cancelado'"><span class="badge badge-success">{{venta.estado}}</span></div>
                                                    <div v-else-if="venta.estado=='Debe'"><span class="badge badge-warning">{{venta.estado}}</span></div>  
                                                    <div v-else><span class="badge badge-danger">{{venta.estado}}</span></div>      
                                                </td>
                                                <td align="center">
                                                    <a class="btn btn-sm btn-default" @click="verVenta(venta.id)"><i class="far fa-eye"></i></a>
                                                    <a class="btn btn-sm btn-default" @click="pdfVenta(venta.id)"><i class="fas fa-print"></i></a>                                   
                                                    <template v-if="venta.estado=='Cancelado'">
                                                        <a class="btn btn-sm btn-default" @click="desactivarVenta(venta.id)"><i class="fas fa-ban" title="Desactivar"></i></a>  
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
                                        <div class="col-sm-6" ><h5>Nueva <b>Venta</b></h5></div>                                    
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
                                                        <label for="">Cliente<span class="text-error" v-show="idcliente==''">(*)</span></label>
                                                        <v-select
                                                            @search="selectCliente"
                                                            label="nombre"
                                                            :options="arrayCliente"
                                                            placeholder="Buscar Clientes..."
                                                            @input="getDatosCliente"
                                                        ></v-select>
                                                        <span class="text-error" v-show="e_idcliente">Elegir cliente</span>
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
                                                        <label>Artículo <span class="text-error" v-show="idarticulo==0">(*)</span></label>
                                                        <div class="form-inline">
                                                            <input type="text" class="form-control form-control-sm" v-model="codigo" @keyup.enter="buscarArticulo()" placeholder="Cód. artículo" size="10">
                                                            <button @click="abrirModal()" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                                                            <input type="text" readonly class="form-control form-control-sm" v-model="articulo" size="13">
                                                            <span class="text-info">{{descripcion}}</span>
                                                        </div>
                                                    </div>
                                                    <template v-if="articulo">
                                                        <div class="col-md-2 offset-2">
                                                            <label>Precio <span class="text-error" v-show="precio==0">(*)</span></label>
                                                            <input type="number" value="0" step="0.1" min="0.1" max="100" class="form-control form-control-sm" v-model="precio">                                                        
                                                            <span class="text-info" v-show="precio<=precioB">Precio: ${{precioB}}</span>
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label>Cantidad <span class="text-error" v-show="cantidad==0">(*)</span></label>                                                        
                                                            <input type="number" value="0" step="1" min="0" :max="stock" class="form-control form-control-sm" v-model="cantidad">
                                                            <span class="text-error" v-show="cantidad>=stock">Stock: {{stock}}</span>
                                                        </div>                                                    
                                                        <div class="col-md-1">
                                                            <button @click="agregarDetalle()" class="btn btn-primary btn-sm btnagregar"><i class="fas fa-plus-circle"></i></button>
                                                        </div>
                                                    </template>
                                                </div>
                                                <hr>       
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-sm table-hover" id="dtTable">
                                                            <thead class="thead-light">
                                                                <tr align="center">                                            
                                                                    <th width="5%">Opc.</th>
                                                                    <th width="45%">Artículo</th>
                                                                    <th width="10%">Precio</th>
                                                                    <th width="10%">Cantidad</th>
                                                                    <th width="10%">Descuento</th>
                                                                    <th width="10%">Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody v-if="arrayDetalle.length">
                                                                <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                                                    <td><a href="#" @click="eliminarDetalle(index)"><i class="fas fa-trash-alt"></i></a></td>                                                                 
                                                                    <td v-text="detalle.articulo"></td>
                                                                    <td><input v-model="detalle.precio" type="number" step="0.1" min="0.1" max="100" class="form-control form-control-sm"></td>
                                                                    <td>                                                                        
                                                                        <input v-model="detalle.cantidad" type="number" min="1" :max="detalle.stock" class="form-control form-control-sm">
                                                                        <span class="text-error" v-show="detalle.cantidad>=detalle.stock">Stock: {{detalle.stock}}</span>
                                                                    </td>
                                                                    <td align="right">                                                                        
                                                                        <input v-model="detalle.descuento" type="number" step="0.1" min="0" :max="detalle.precio*detalle.cantidad" class="form-control form-control-sm">
                                                                        <span class="text-error" v-show="detalle.descuento>=(detalle.precio*detalle.cantidad)">Desc. máx.</span>
                                                                    </td>
                                                                    <td align="right">$ {{ (detalle.precio*detalle.cantidad-detalle.descuento).toFixed(2) }}</td>                                                                    
                                                                </tr>                                                                
                                                            </tbody>
                                                            <tbody v-else>
                                                                <tr>
                                                                    <td colspan="7" class="text-center">
                                                                        <span class="badge badge-pill" v-bind:class="[ e_detalle ? 'badge-danger' : 'badge-secondary']">-- Sin registros --</span>                                       
                                                                    </td>
                                                                </tr>
                                                            </tbody>                                    
                                                        </table>                                                       

                                                        <table width="250" align="right" v-if="arrayDetalle.length">
                                                            <tr width="65%">
                                                                <td align="left"><strong>Abono:</strong></td>
                                                                <td align="right">                                                                        
                                                                    <input v-model="abono" type="number" step="0.1" min="0" :max="(total)" class="form-control form-control-sm"> 
                                                                </td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"><strong>Total Parcial:</strong></td>
                                                                <td align="right" class="w-25">$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"><strong>Total Impuesto:</strong></td>
                                                                <td align="right">$ {{ totalImpuesto=(total*impuesto).toFixed(2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"><strong>Total Neto:</strong></td>
                                                                <td align="right"><strong>$ {{total=(calcularTotal).toFixed(2)}} </strong> </td>
                                                            </tr>                                                       
                                                        </table>
                                                    </div>
                                                </div>                                                                                   
                                            </div>
                                            <div class="card-footer">
                                                <button type="button" @click="ocultarDetalle()" class="btn btn-secondary btn-sm">Cerrar</button>
                                                <button type="button" class="btn btn-primary btn-sm" @click="registrarVenta()">Guardar</button>
                                                <div class="custom-control custom-checkbox float-right">
                                                    <input class="custom-control-input" type="checkbox" id="cbPdf" value="1" v-model="cbPdf">
                                                    <label for="cbPdf" class="custom-control-label">Generar PDF</label>
                                                </div>
                                                
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                         
                        </template>
                        <!-- Fin Detalle -->

                        <!-- Ver venta -->
                        <template v-else-if="listado==2">
                            <div class="card-body col-10 offset-md-1">                            
                                <div class="invoice p-3 mb-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <i class="fas fa-cash-register"></i> Factura de venta
                                                <small class="float-right">Fecha: {{ hoyFecha() }} </small>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="row invoice-info">
                                    <div class="col-sm-4 invoice-col">
                                    <h6>Proveedor</h6>                          
                                    <address>
                                        <strong>Empresa, Inc.</strong><br>
                                        Dirección:<br>
                                        Ciudad<br>
                                        Teléfono:<br>
                                        Correo:
                                    </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                    <h6>Cliente</h6> 
                                    <address>
                                        <strong>{{ cliente }}</strong><br>
                                        Dirección: {{ direccion }}<br>
                                        Ciudad<br>
                                        Teléfono: {{ celular }}<br>
                                        Correo: {{ email }}
                                    </address>
                                    </div>
                                    <!-- /.col -->
                                    <div class="col-sm-4 invoice-col">
                                    <b>{{ tipo_comprobante }}</b>  {{ serie_comprobante }} - {{ num_comprobante }}<br>
                                    <br>
                                    <b>ID:</b> {{ id }}<br>
                                    <b>Fecha: </b> {{ fecha_hora }}<br>
                                    <b>IVA:</b> {{ impuesto }}
                                    </div>
                                    <!-- /.col -->
                                </div>
                                <!-- /.row -->
                                <div class="row">                                    
                                    <div class="col-12 table-responsive">         
                                        <div class="card card-primary card-outline">                                            
                                            <div class="card-body">                                                
                                                <div class="table-responsive col-md-12">
                                                    <table class="table table-bordered table-sm table-hover" id="dtTable">
                                                        <thead class="thead-light">
                                                            <tr align="center">                                                                                                         
                                                                <th style="width: 30%">Artículo</th>
                                                                <th style="width: 40%">Descripción</th>
                                                                <th width="4%">Cantidad</th>
                                                                <th>Precio</th>                                                                
                                                                <th>Descuento</th>
                                                                <th>Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="detalle in arrayDetalle" :key="detalle.id">                                                                
                                                                <td v-text="detalle.articulo"></td>
                                                                <td v-text="detalle.articulo_descripcion"></td>
                                                                <td align="right" v-text="detalle.cantidad"></td>
                                                                <td align="right">$ {{ detalle.precio }}</td>                                                                
                                                                <td align="right">$ {{ detalle.descuento }}</td>
                                                                <td align="right">$ {{detalle.precio*detalle.cantidad-detalle.descuento}}</td>
                                                            </tr>                                                            
                                                        </tbody>                                                                                            
                                                    </table>                                                    
                                                    <table width="250" align="right" v-if="arrayDetalle.length">
                                                            <tr>
                                                                <td align="left"><strong>Abono:</strong></td>
                                                                <td align="right" class="w-25">$ {{abono}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"><strong>Total Parcial:</strong></td>
                                                                <td align="right" class="w-25">$ {{totalParcial=(total-totalImpuesto).toFixed(2)}}</td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"><strong>Total Impuesto:</strong></td>
                                                                <td align="right">$ {{totalImpuesto=(total*impuesto).toFixed(2) }}</td>
                                                            </tr>
                                                            <tr>
                                                                <td align="left"><strong>Total Neto:</strong></td>
                                                                <td align="right"><strong>$ {{total}} </strong> </td>
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
                        <!-- Fin Ver Venta -->

                    </div>
                </div>
            </div>            
        </div>

        <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title" v-text="tituloModal"></h4>
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
                                    <input type="text" v-model="buscarA" @keyup.enter="listarArticulo(buscarA,criterioA)" class="form-control form-control-sm" placeholder="Texto a buscar">
                                    <button type="submit" @click="listarArticulo(buscarA,criterioA)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>
                                </div>
                            </div>
                        </div>
                        
                        <div class="table-responsive">
                            <table class="table table-bordered table-sm table-hover" id="dtTable">
                                <thead class="thead-table">
                                    <tr align="center">                                
                                        <th width="8%">COD</th>
                                        <th>NOMBRE</th>                             
                                        <th width="12%">PVP</th>
                                        <th width="10%">STOCK</th>
                                        <th width="15%">ESTADO</th>                        
                                        <th width="12%">ACCIONES</th>
                                    </tr>
                                </thead>
                                <tbody v-if="arrayArticulo.length">
                                    <tr v-for="articulo in arrayArticulo" :key="articulo.id">                                                                
                                        <td v-text="articulo.codigo"></td>
                                        <td v-text="articulo.nombre"></td>
                                        <td align="right">$ {{ articulo.precio_venta }}</td>
                                        <td align="right" v-text="articulo.stock"></td>
                                        <td align="center">
                                            <div v-if="articulo.condicion"><span class="badge badge-success">Activo</span></div>
                                            <div v-else><span class="badge badge-danger">Desactivo</span></div>                                    
                                        </td>
                                        <td align="center">
                                            <button type="button" @click="agregarDetalleModal(articulo)" class="btn btn-default btn-sm"><i class="far fa-check-circle"></i></button>
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
                venta_id: 0,
                idcliente:0,
                id:'',
                cliente:'',
                direccion:'',
                celular:'',
                email:'',
                nombre : '',
                fecha_hora : '',
                tipo_comprobante : 'NOTA',
                serie_comprobante : '',
                num_comprobante : '',
                impuesto: 0.12,
                total:0.0,
                abono:0.0,
                totalSaldo: 0.0,
                totalParcial: 0.0,
                totalImpuesto: 0.0,
                

                arrayVenta : [],
                arrayCliente: [],
                arrayDetalle : [],

                listado:1,

                arrayArticulo: [],
                idarticulo: 0,
                codigo: '',
                articulo: '',
                descripcion: '',
                precio: 0,
                precioB: 0,
                cantidad:0,
                descuento:0,
                stock:0,          
                
                criterioA:'nombre',
                buscarA: '',

                modal : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorVenta : 0,
                errorMostrarMsjVenta : [],
                errorStock : [],
                e_idcliente : false,
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
                cbPdf : 0,
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
        
                return dd+'/'+mm+'/'+yyyy;      
            },            
            cambioImpuesto() { 
                let me = this;

                if(me.tipo_comprobante == 'NOTA'){ me.impuesto = 0.0
                }else{ me.impuesto = 0.12
                } 
            },
            listarVenta (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/venta?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayVenta = respuesta.ventas.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
                me.ordenado=ordenado;
                me.ascdesc=ascdesc;
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
                me.idcliente = val1.id;
            },
            getDatosCliente2(val2){
                let me = this;
                me.loading = true;
                me.buscar = val2.id;
            },
            buscarArticulo(){
                let me=this;
                var url= '/articulo/buscarArticuloVenta?filtro=' + me.codigo;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos;

                    if (me.arrayArticulo.length>0){
                        me.articulo=me.arrayArticulo[0]['nombre'];
                        me.idarticulo=me.arrayArticulo[0]['id'];
                        me.precio=me.arrayArticulo[0]['precio_venta'];
                        me.precioB=me.arrayArticulo[0]['precio_venta']; 
                        me.cantidad=1;                       
                        me.stock=me.arrayArticulo[0]['stock'];
                        me.descripcion=me.arrayArticulo[0]['descripcion'];
                    }
                    else{
                        me.articulo='No existe artículo/stock';
                        me.idarticulo=0;
                    }
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            pdfVenta(id){
                window.open('http://localhost:8000/venta/pdf/' + id + ',' + '_blank');
            },
            cambiarPagina(page,buscar,criterio,paginado,ordenado,ascdesc){
                let me = this;
                //Actualiza la página actual
                me.pagination.current_page = page;
                //Envia la petición para visualizar la data de esa página
                me.listarVenta(page,buscar,criterio,paginado,ordenado,ascdesc);
            },
            existeArticulo(id){
                var sw=0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    if(this.arrayDetalle[i].idarticulo==id){
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
                if(me.idarticulo==0 || me.cantidad==0 || me.precio==0){
                }
                else{
                    if(me.existeArticulo(me.idarticulo)){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!',
                        })
                    }
                    else{
                       if(me.cantidad>me.stock){
                            Swal.fire({
                                icon: 'error',
                                title: 'Error...',
                                text: 'NO hay stock disponible!',
                            })
                            me.cantidad= me.stock
                       } 
                       else{
                           me.arrayDetalle.push({
                                idarticulo: me.idarticulo,
                                articulo: me.articulo,
                                descripcion: me.descripcion,
                                cantidad: me.cantidad,
                                precio: me.precio,
                                descuento: 0,
                                stock: me.stock
                            });
                        me.codigo="";
                        me.idarticulo=0;
                        me.articulo="";
                        me.descripcion="";
                        me.cantidad=0;
                        me.precio=0;
                        me.descuento=0;
                        me.precioB=0;
                        me.stock=0
                        }                    
                    }
                }
                           
            },
            agregarDetalleModal(data =[]){
                let me=this;
                if(me.existeArticulo(data['id'])){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error...',
                            text: 'Ese artículo ya se encuentra agregado!',
                            })
                    }
                    else{
                       me.arrayDetalle.push({
                            idarticulo: data['id'],
                            articulo: data['nombre'],
                            cantidad: 1,
                            precio: data['precio_venta'],
                            descuento:0,
                            stock:data['stock']
                        }); 
                    }
            },
            listarArticulo (buscar,criterio){
                let me=this;
                var url= '/articulo/listarArticuloVenta?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarVenta(){
                if (this.validarVenta()){
                    return;
                }
                
                let me = this;

                axios.post('/venta/registrar',{
                    'idcliente': this.idcliente,
                    'tipo_comprobante': this.tipo_comprobante,
                    'serie_comprobante' : this.serie_comprobante,
                    'num_comprobante' : this.num_comprobante,
                    'impuesto' : this.impuesto,
                    'total' : this.total,
                    'abono' : this.abono,
                    'data': this.arrayDetalle

                }).then(function (response) {
                    me.listado=1;
                    me.listarVenta(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc); 
                    me.idcliente=0;
                    me.tipo_comprobante='NOTA';
                    me.serie_comprobante='';
                    me.num_comprobante='';
                    me.impuesto=0.12;
                    me.total=0.0;
                    me.abono=0.0;
                    me.idarticulo=0;
                    me.articulo='';
                    me.cantidad=0;
                    me.precio=0;
                    me.stock=0;
                    me.codigo='';
                    me.descuento=0;
                    me.arrayDetalle=[];

                    if(me.cbPdf) { 
                        window.open('venta/pdf/'+response.data.id);
                        }  

                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarVenta(){
                let me=this;
                me.errorVenta=0;
                me.errorMostrarMsjVenta =[];
                var art;
                
                // me.arrayDetalle.map(function(x){
                //     if (x.cantidad>x.stock){
                //         art=x.articulo + " sin stock";
                //         me.errorStock.push(art);
                //     }
                // });

                if (this.idcliente==0) {this.e_idcliente = true; this.errorMostrarMsjVenta.push('idcliente');}else{this.e_idcliente = false}

                if(this.tipo_comprobante == 'FACTURA')
                {
                    if (this.serie_comprobante==0) {this.e_serie_comprobante = true; this.errorMostrarMsjVenta.push('serie_comprobante');}else{this.e_serie_comprobante = false}
                    if (this.num_comprobante==0) {this.e_num_comprobante = true; this.errorMostrarMsjVenta.push('num_comprobante');}else{this.e_num_comprobante = false}
                    if (!this.impuesto) {this.e_impuesto = true; this.errorMostrarMsjVenta.push('impuesto');}else{this.e_impuesto = false}
                }

                if (this.arrayDetalle.length<=0) {this.e_detalle = true; this.errorMostrarMsjVenta.push('detalle');}else{this.e_detalle = false}              

                if (this.errorMostrarMsjVenta.length) this.errorVenta = 1;

                return this.errorVenta;
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
                me.tipo_comprobante='NOTA';
                me.serie_comprobante='';
                me.num_comprobante='';               
                me.impuesto=0.12;
                me.total=0.0;
                me.abono=0.0;
                me.idarticulo=0;
                me.codigo='';
                me.articulo='';
                me.descripcion='';
                me.cantidad=0;
                me.precio=0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=1;
            },
            verVenta(id){
                let me=this;
                me.listado=2;
                
                //Obtener los datos del venta
                var arrayVentaT=[];
                var url= '/venta/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayVentaT = respuesta.venta;

                    me.id = arrayVentaT[0]['id'];
                    me.cliente = arrayVentaT[0]['nombre'];
                    me.direccion = arrayVentaT[0]['direccion'];
                    me.celular = arrayVentaT[0]['celular'];
                    me.email = arrayVentaT[0]['email'];
                    me.tipo_comprobante=arrayVentaT[0]['tipo_comprobante'];
                    me.serie_comprobante=arrayVentaT[0]['serie_comprobante'];
                    me.num_comprobante=arrayVentaT[0]['num_comprobante'];
                    me.fecha_hora=arrayVentaT[0]['fecha_hora'];
                    me.impuesto=arrayVentaT[0]['impuesto'];
                    me.total=arrayVentaT[0]['total'];
                    me.abono=arrayVentaT[0]['abono'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= '/venta/obtenerDetalles?id=' + id;
                
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
                this.arrayArticulo=[];
                this.modal = 1;
                this.tituloModal = 'Seleccione uno o varios artículos';
            },
            desactivarVenta(id){
               Swal.fire({
                title: 'Anular la venta?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, anular'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/venta/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarVenta(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc);
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
            }
        },
        mounted() {
            this.listarVenta(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>