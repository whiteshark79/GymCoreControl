<template>

    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Ingresos</h3></div>
                            <div class="card-tools">
                                <template v-if="listado!=0">
                                    <button type="button" class="btn btn-sm btn-primary" @click="mostrarDetalle()"><i class="fas fa-plus-circle">  Nuevo Ingreso</i></button>
                                </template>
                            </div>
                        </div>                      

                        <!-- Listado -->
                        <template v-if="listado==1">
                            <div class="card-body">
                                <div class="form-group row justify-content-between">
                                    <div class="input-group input-group-sm col-7">                                
                                        <select class="form-control col-2 " v-model="criterio">
                                            <option value="idproveedor">Proveedor</option>
                                            <option value="fecha_hora">Fecha</option>
                                            <option value="tipo_comprobante">Tipo Doc.</option>
                                            <option value="num_comprobante">Núm. Doc.</option>                                           
                                        </select>
                                        <template v-if="criterio=='idproveedor'">
                                            <div class="col-md-4">                                                        
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
                                            <input type="date" v-model="buscar" class="form-control col-4">
                                        </template>
                                        <template v-else-if="criterio=='tipo_comprobante'">
                                            <select class="form-control form-control-sm col-4" v-model="buscar">
                                                <option value="FACTURA" selected>Factura</option>
                                                <option value="NOTA">Nota</option>                                                
                                            </select>
                                        </template>
                                        <template v-else>
                                            <input type="number" v-model="buscar" @keyup.enter="listarIngreso(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control col-4" placeholder="No del comprobante">
                                        </template>                                       
                                        <button type="submit" @click="listarIngreso(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button>                                 
                                    </div>
                                    <div class="col-4"></div>
                                    <div class="input-group input-group-sm col-1">                                     
                                        <select class="form-control" v-model="paginado" @change="listarIngreso(1,buscar,criterio,paginado,ordenado,ascdesc)">
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
                                                <th width="16%">FECHA
                                                    <template v-if="(ordenado !== 'fecha_hora' && ascdesc === 'asc') || (ordenado === 'fecha_hora' && ascdesc === 'desc') ">
                                                        <a href="#" @click="listarIngreso(1,buscar,criterio,paginado,'fecha_hora','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'fecha_hora' && ascdesc === 'desc') || (ordenado === 'fecha_hora' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarIngreso(1,buscar,criterio,paginado,'fecha_hora','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>
                                                <th width="25%">PROVEEDOR
                                                    <template v-if="(ordenado !== 'idproveedor' && ascdesc === 'asc') || (ordenado === 'idproveedor' && ascdesc === 'desc')">
                                                        <a href="#" @click="listarIngreso(1,buscar,criterio,paginado,'idproveedor','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'idproveedor' && ascdesc === 'desc') || (ordenado === 'idproveedor' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarIngreso(1,buscar,criterio,paginado,'idproveedor','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>
                                                <th width="20%">DOCUMENTO</th>                                         
                                                <th width="6%">SUBTOTAL</th>
                                                <th width="6%">IVA</th>
                                                <th width="6%">TOTAL</th>                                           
                                                <th width="9%">ESTADO
                                                    <template v-if="(ordenado !== 'estado' && ascdesc === 'asc') || (ordenado === 'estado' && ascdesc === 'desc')">
                                                        <a href="#" @click="listarIngreso(1,buscar,criterio,paginado,'estado','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                    </template>
                                                    <template v-if="(ordenado !== 'estado' && ascdesc === 'desc') || (ordenado === 'estado' && ascdesc === 'asc')">
                                                        <a href="#" @click="listarIngreso(1,buscar,criterio,paginado,'estado','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                    </template>
                                                </th>                                                                                    
                                                <th width="12%">ACCIONES</th>
                                            </tr>
                                        </thead>
                                        <tbody v-if="arrayIngreso.length">
                                            <tr v-for="ingreso in arrayIngreso" :key="ingreso.id">
                                                <td v-text="ingreso.fecha_hora"></td>
                                                <td>{{ingreso.nombre}}</td>                        
                                                <td>{{ingreso.tipo_comprobante}} : {{ingreso.serie_comprobante}}-{{ingreso.num_comprobante}}</td>
                                                <td align="right">$ {{ (ingreso.total-ingreso.impuesto*ingreso.total).toFixed(2) }}</td>
                                                <td align="right">$ {{ (ingreso.impuesto*ingreso.total).toFixed(2) }}</td>
                                                <td align="right">$ {{ ingreso.total  }}</td>
                                                <td align="center"> 
                                                    <div v-if="ingreso.estado=='Registrado'"><span class="badge badge-success">Registrado</span></div>
                                                    <div v-else><span class="badge badge-danger">Anulado</span></div>                                    
                                                </td>
                                                <td align="center">
                                                    <a class="btn btn-sm btn-default" @click="verIngreso(ingreso.id)"><i class="far fa-eye"></i></a>                                   
                                                    <template v-if="ingreso.estado=='Registrado'">
                                                        <a class="btn btn-sm btn-default" @click="desactivarIngreso(ingreso.id)"><i class="fas fa-ban" title="Desactivar"></i></a>  
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
                                        <div class="col-sm-6" ><h5>Nuevo <b>Ingreso</b></h5></div>                                    
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
                                                        ></v-select>
                                                    </div> 
                                                    <div class="col-md-4">
                                                        <label>Comprobante<span class="text-error" v-show="tipo_comprobante==0">(*)</span></label>
                                                        <select class="form-control form-control-sm" v-model="tipo_comprobante">
                                                            <option value="0" disabled>--Elegir tipo--</option>
                                                            <option value="NOTA">Nota</option>
                                                            <option value="FACTURA">Factura</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-4">
                                                        <label>Serie<span class="text-error" v-show="serie_comprobante==''">(*)</span></label>
                                                        <input type="number" class="form-control form-control-sm" v-model="serie_comprobante" placeholder="000x">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>Número<span class="text-error" v-show="num_comprobante==''">(*)</span></label>
                                                        <input type="number" class="form-control form-control-sm" v-model="num_comprobante" placeholder="000xx">
                                                    </div>
                                                    <div class="col-md-4">
                                                        <label>IVA<span class="text-error" v-show="impuesto==''">(*)</span></label>
                                                        <input type="number" step="0.01" min="0" max="0.20" class="form-control form-control-sm" v-model="impuesto">
                                                    </div>                                            
                                                </div>
                                                <div class="row">                                                
                                                    <div v-show="errorIngreso" class="col-md-12 form-group row div-error">                                                    
                                                        <div class="alert alert-danger" role="alert">
                                                            <div v-for="error in errorMostrarMsjIngreso" :key="error" v-text="error">                                                                
                                                            </div>
                                                            
                                                        </div>
                                                    </div>                                               
                                                </div>                                      
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
                                                    <div class="col-md-7">
                                                        <label>Artículo <span class="text-error" v-show="idarticulo==0">(*)</span></label>
                                                        <div class="form-inline">
                                                            <input type="text" class="form-control form-control-sm" v-model="codigo" @keyup.enter="buscarArticulo()" placeholder="Cód. artículo" size="10">
                                                            <button @click="abrirModal()" class="btn btn-primary btn-sm"><i class="fas fa-search"></i></button>
                                                            <input type="text" readonly class="form-control form-control-sm" v-model="articulo" size="13">
                                                        </div>
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label>Precio <span class="text-error" v-show="precio==0">(*)</span></label>
                                                        <input type="number" value="0" step="0.1" min="0" max="100" class="form-control form-control-sm" v-model="precio">
                                                    </div>
                                                    <div class="col-md-2">
                                                        <label>Cantidad <span class="text-error" v-show="cantidad==0">(*)</span></label>
                                                        <input type="number" value="0" step="1" min="0" max="100" class="form-control form-control-sm" v-model="cantidad">
                                                    </div>
                                                    <div class="col-md-1">
                                                        <button @click="agregarDetalle()" class="btn btn-primary btn-sm btnagregar"><i class="fas fa-plus-circle"></i></button>
                                                    </div>
                                                </div>
                                                <hr>       
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <table class="table table-bordered table-sm table-hover" id="dtTable">
                                                            <thead class="thead-light">
                                                                <tr align="center">                                            
                                                                    <th class="w-5">Opc.</th>
                                                                    <th class="w-50">Artículo</th>
                                                                    <th>Precio</th>
                                                                    <th>Cantidad</th>
                                                                    <th>Subtotal</th>
                                                                </tr>
                                                            </thead>
                                                            <tbody v-if="arrayDetalle.length">
                                                                <tr v-for="(detalle,index) in arrayDetalle" :key="detalle.id">
                                                                    <td><a href="#" @click="eliminarDetalle(index)"><i class="fas fa-trash-alt"></i></a></td>                                                                 
                                                                    <td v-text="detalle.articulo"></td>
                                                                    <td><input v-model="detalle.precio" type="number" step="any" min="0.1" max="100" class="form-control form-control-sm"></td>
                                                                    <td><input v-model="detalle.cantidad" type="number" min="1" max="100" class="form-control form-control-sm"></td>
                                                                    <td align="right">$ {{(detalle.precio*detalle.cantidad).toFixed(2)}}</td>
                                                                </tr>                                                                
                                                            </tbody>
                                                            <tbody v-else>
                                                                <tr>
                                                                    <td colspan="5" class="text-center">
                                                                        <span class="badge badge-pill badge-secondary">-- Sin registros --</span>                                       
                                                                    </td>
                                                                </tr>
                                                            </tbody>                                    
                                                        </table>
                                                        <table align="right" border="1" bordercolor="white" v-if="arrayDetalle.length">
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
                                                <button type="button" class="btn btn-primary btn-sm" @click="registrarIngreso()">Guardar</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>                         
                        </template>
                        <!-- Fin Detalle -->

                        <!-- Ver ingreso -->
                        <template v-else-if="listado==2">
                            <div class="card-body col-10 offset-md-1">   
                                <div class="invoice p-3 mb-3">
                                    <div class="row">
                                        <div class="col-12">
                                            <h4>
                                                <i class="fas fa-shopping-basket"></i> Orden de compra
                                                <small class="float-right">Fecha: {{  hoyFecha() }} </small>
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
                                                                <th style="width: 30%">Artículo</th>
                                                                <th style="width: 40%">Descripción</th>
                                                                <th width="4%">Cantidad</th>
                                                                <th>Precio</th>
                                                                <th>Subtotal</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr v-for="detalle in arrayDetalle" :key="detalle.id">
                                                                <td v-text="detalle.articulo"></td>
                                                                <td v-text="detalle.articulo_descripcion"></td>
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
                        <!-- Fin Ver Ingreso -->

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
                ingreso_id: 0,
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
                totalImpuesto: 0.0,
                totalParcial: 0.0,

                arrayIngreso : [],
                arrayProveedor: [],
                arrayDetalle : [],

                listado:1,

                arrayArticulo: [],
                idarticulo: 0,
                codigo: '',
                articulo: '',
                precio: 0,
                cantidad:0,          
                
                criterioA:'nombre',
                buscarA: '',

                modal : 0,
                tituloModal : '',
                tipoAccion : 0,
                errorIngreso : 0,
                errorMostrarMsjIngreso : [],
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
                var resultado=0.0;
                for(var i=0;i<this.arrayDetalle.length;i++){
                    resultado=resultado+(this.arrayDetalle[i].precio*this.arrayDetalle[i].cantidad)
                }
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
            listarIngreso (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/ingreso?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayIngreso = respuesta.ingresos.data;
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
            buscarArticulo(){
                let me=this;
                var url= '/articulo/buscarArticulo?filtro=' + me.codigo;

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos;

                    if (me.arrayArticulo.length>0){
                        me.articulo=me.arrayArticulo[0]['nombre'];
                        me.idarticulo=me.arrayArticulo[0]['id'];
                        me.precio=me.arrayArticulo[0]['precio_venta'];
                    }
                    else{
                        me.articulo='No existe artículo';
                        me.idarticulo=0;
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
                me.listarIngreso(page,buscar,criterio,paginado,ordenado,ascdesc);
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
                       me.arrayDetalle.push({
                            idarticulo: me.idarticulo,
                            articulo: me.articulo,
                            cantidad: me.cantidad,
                            precio: me.precio
                        });
                        me.codigo="";
                        me.idarticulo=0;
                        me.articulo="";
                        me.cantidad=0;
                        me.precio=0; 
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
                            precio: data['precio_venta']
                        }); 
                    }
            },
            listarArticulo (buscar,criterio){
                let me=this;
                var url= '/articulo/listarArticulo?buscar='+ buscar + '&criterio='+ criterio;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            registrarIngreso(){
                if (this.validarIngreso()){
                    return;
                }
                
                let me = this;

                axios.post('/ingreso/registrar',{
                    'idproveedor': this.idproveedor,
                    'tipo_comprobante': this.tipo_comprobante,
                    'serie_comprobante' : this.serie_comprobante,
                    'num_comprobante' : this.num_comprobante,
                    'impuesto' : this.impuesto,
                    'total' : this.total,
                    'data': this.arrayDetalle

                }).then(function (response) {
                    me.listado=1;
                    me.listarIngreso(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc); 
                    me.idproveedor=0;
                    me.tipo_comprobante='FACTURA';
                    me.serie_comprobante='';
                    me.num_comprobante='';
                    me.impuesto=0.12;
                    me.total=0.0;
                    me.idarticulo=0;
                    me.articulo='';
                    me.cantidad=0;
                    me.precio=0;
                    me.arrayDetalle=[];
                    

                }).catch(function (error) {
                    console.log(error);
                });
            },
            validarIngreso(){
                this.errorIngreso=0;
                this.errorMostrarMsjIngreso =[];

                if (this.idproveedor==0) this.errorMostrarMsjIngreso.push("Seleccione un Proveedor");
                if (this.tipo_comprobante==0) this.errorMostrarMsjIngreso.push("Seleccione el comprobante");
                if (!this.num_comprobante) this.errorMostrarMsjIngreso.push("Ingrese el número de comprobante");
                if (!this.impuesto) this.errorMostrarMsjIngreso.push("Ingrese el impuesto de compra");
                if (this.arrayDetalle.length<=0) this.errorMostrarMsjIngreso.push("Ingrese detalles");

                if (this.errorMostrarMsjIngreso.length) this.errorIngreso = 1;

                return this.errorIngreso;
            },
            mostrarDetalle(){
                let me=this;
                me.listado=0;

                me.idproveedor=0;
                me.tipo_comprobante='FACTURA';
                me.serie_comprobante='';
                me.num_comprobante='';
                me.impuesto=0.12;
                me.total=0.0;
                me.idarticulo=0;
                me.articulo='';
                me.cantidad=0;
                me.precio=0;
                me.arrayDetalle=[];
            },
            ocultarDetalle(){
                this.listado=1;
            },
            verIngreso(id){
                let me=this;
                me.listado=2;
                
                //Obtener los datos del ingreso
                var arrayIngresoT=[];
                var url= '/ingreso/obtenerCabecera?id=' + id;
                
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayIngresoT = respuesta.ingreso;

                    me.id = arrayIngresoT[0]['id'];
                    me.proveedor = arrayIngresoT[0]['nombre'];
                    me.direccion = arrayIngresoT[0]['direccion'];
                    me.celular = arrayIngresoT[0]['celular'];
                    me.email = arrayIngresoT[0]['email'];
                    me.tipo_comprobante=arrayIngresoT[0]['tipo_comprobante'];
                    me.serie_comprobante=arrayIngresoT[0]['serie_comprobante'];
                    me.num_comprobante=arrayIngresoT[0]['num_comprobante'];
                    me.fecha_hora=arrayIngresoT[0]['fecha_hora'];
                    me.impuesto=arrayIngresoT[0]['impuesto'];
                    me.total=arrayIngresoT[0]['total'];
                })
                .catch(function (error) {
                    console.log(error);
                });

                //Obtener los datos de los detalles 
                var urld= '/ingreso/obtenerDetalles?id=' + id;
                
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
            desactivarIngreso(id){
               Swal.fire({
                title: 'Anular el ingreso?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, desactivarla'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/ingreso/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarIngreso(me.pagination.current_page,'','id',me.paginado,me.ordenado,me.ascdesc);
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
        },
        mounted() {
            this.listarIngreso(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>
<style>    
  .div-error{
        display: flex;
        justify-content: center;
    }

</style>