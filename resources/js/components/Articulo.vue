<template>
  
    <main class="main">
        <div class="row mt-3">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Artículos</h3></div>
                            <div class="card-tools">
                                <button type="button" class="btn btn-sm btn-primary" @click="abrirModal('articulo','registrar')"><i class="fas fa-plus-circle">  Nuevo Artículo</i></button>
                                <button type="button" class="btn btn-sm btn-info" @click="cargarPdf()"><i class="fas fa-file-pdf"> Reporte</i></button>  
                            </div>
                        </div>                      

                        <div class="card-body">
                            <div class="form-group row justify-content-between">
                                <div class="input-group input-group-sm col-7">                                
                                    <select class="form-control col-2 " v-model="criterio" @change="ceroBusqueda();">
                                        <option value="codigo">Código</option>
                                        <option value="nombre">Nombre</option>
                                        <option value="descripcion">Descripción</option>
                                        <option value="idcategoria">Categoría</option>
                                    </select>
                                    <template v-if="criterio=='idcategoria'">
                                        <div class="col-md-4">                                                        
                                            <v-select
                                                id="buscar"
                                                @search="selectCategoriaB"
                                                label="nombre"
                                                :options="arrayCategoriaB"
                                                placeholder="Buscar Categorias..."
                                                @input="getDatosCategoriaB"                                    
                                            ></v-select>
                                            </div>
                                    </template>
                                    <template v-else>
                                        <input type="text" v-model="buscar" @keyup.enter="listarArticulo(1,buscar,criterio,paginado,ordenado,ascdesc)" class="form-control col-4" placeholder="Texto a buscar">
                                    </template>                                    
                                    <button type="submit" @click="listarArticulo(1,buscar,criterio,paginado,ordenado,ascdesc)" class="btn btn-primary btn-sm"><i class="fas fa-search"></i> Buscar</button> 
                                    <button type="button" @click="ceroBusqueda();" class="btn btn-info btn-sm ml-1"><i class="fas fa-redo"></i> </button>                                
                                </div>
                                <div class="col-4"></div>
                                <div class="input-group input-group-sm col-1">                                     
                                    <select class="form-control" v-model="paginado" @change="listarArticulo(1,buscar,criterio,paginado,ordenado,ascdesc)">
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
                                            <th width="6%">CÓD
                                                <template v-if="(ordenado !== 'codigo' && ascdesc === 'asc') || (ordenado === 'codigo' && ascdesc === 'desc') ">
                                                    <a href="#" @click="listarArticulo(1,buscar,criterio,paginado,'codigo','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'codigo' && ascdesc === 'desc') || (ordenado === 'codigo' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarArticulo(1,buscar,criterio,paginado,'codigo','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="20%">NOMBRE
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'asc') || (ordenado === 'nombre' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarArticulo(1,buscar,criterio,paginado,'nombre','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'nombre' && ascdesc === 'desc') || (ordenado === 'nombre' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarArticulo(1,buscar,criterio,paginado,'nombre','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th>DESCRIPCIÓN</th>
                                            <th width="12%">CATEGORÍA
                                                <template v-if="(ordenado !== 'idcategoria' && ascdesc === 'asc') || (ordenado === 'idcategoria' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarArticulo(1,buscar,criterio,paginado,'idcategoria','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'idcategoria' && ascdesc === 'desc') || (ordenado === 'idcategoria' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarArticulo(1,buscar,criterio,paginado,'idcategoria','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="5%">PVP</th>
                                            <th width="6%">STOCK
                                                <template v-if="(ordenado !== 'stock' && ascdesc === 'asc') || (ordenado === 'stock' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarArticulo(1,buscar,criterio,paginado,'stock','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'stock' && ascdesc === 'desc') || (ordenado === 'stock' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarArticulo(1,buscar,criterio,paginado,'stock','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="10%">ESTADO
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'asc') || (ordenado === 'condicion' && ascdesc === 'desc')">
                                                    <a href="#" @click="listarArticulo(1,buscar,criterio,paginado,'condicion','asc')"><span style="float:right"><i class="fas fa-arrow-down fa-xs"></i></span></a>
                                                </template>
                                                <template v-if="(ordenado !== 'condicion' && ascdesc === 'desc') || (ordenado === 'condicion' && ascdesc === 'asc')">
                                                    <a href="#" @click="listarArticulo(1,buscar,criterio,paginado,'condicion','desc')"><span style="float:right"><i class="fas fa-arrow-up fa-xs"></i></span></a>
                                                </template>
                                            </th>
                                            <th width="10%">ACCIONES</th>
                                        </tr> 
                                    </thead>
                                    <tbody v-if="arrayArticulo.length">
                                        <tr v-for="articulo in arrayArticulo" :key="articulo.id">
                                            <td v-text="articulo.codigo"></td>
                                            <td v-text="articulo.nombre"></td>
                                            <td v-text="articulo.descripcion"></td>
                                            <td v-text="articulo.nombre_categoria" align="center"></td> 
                                            <td align="right">$ {{ articulo.precio_venta }}</td>
                                            <td v-text="articulo.stock" align="right"></td>
                                            <td align="center">
                                                <div v-if="articulo.condicion"><span class="badge badge-success">Activo</span></div>
                                                <div v-else><span class="badge badge-secondary">Inactivo</span></div>                                    
                                            </td>
                                            <td align="center">
                                                <a class="btn btn-sm btn-default" @click="abrirModal('articulo','actualizar',articulo)"><i class="fas fa-edit" title="Editar"></i></a>
                                                <a class="btn btn-sm btn-default" @click="abrirModal('articulo','eliminar',articulo)"><i class="far fa-trash-alt" title="Eliminar"></i></a>                                    
                                                <template v-if="articulo.condicion">
                                                    <a class="btn btn-sm btn-default" @click="desactivarArticulo(articulo.id)"><i class="fas fa-ban" title="Desactivar"></i></a>
                                                </template>
                                                <template v-else>
                                                    <a class="btn btn-sm btn-default" @click="activarArticulo(articulo.id)"><i class="fas fa-sync" title="Actualizar"></i></a>
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
                    </div>
                </div>
            </div>
        </div>
    <!--Inicio del modal agregar/actualizar-->
        <div class="modal fade" tabindex="-1" :class="{'mostrar' : modal}" role="dialog" aria-labelledby="myModalLabel" style="display: none;" aria-hidden="true">
            <div class="modal-dialog modal-primary modal-md modal-dialog-centered" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" v-text="tituloModal"></h5>
                        <button type="button" class="close" @click="cerrarModal()" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-3 col-7">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="categoria">Categoría: </span>
                                    </div>
                                    <select v-model="idcategoria" class="form-control" v-bind:class="{ 'is-invalid': e_idcategoria }">
                                        <option value="0" disabled>--Seleccione--</option>
                                        <option v-for="categoria in arrayCategoria" :key="categoria.id" :value="categoria.id" v-text="categoria.nombre"></option>
                                    </select>
                                </div>
                                <div class="input-group input-group-sm mb-3 col-5">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="codigo">Cód.: </span>
                                    </div>
                                    <input type="text" v-model="codigo" class="form-control input-sm" v-bind:class="{ 'is-invalid': e_codigo }"> 
                                </div>
                                <!-- <barcode :value="codigo" :options="{ format: 'EAN-13' }">Generando código de barras.</barcode> -->
                            </div>
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-3 col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="precio">Nombre: </span>
                                    </div>
                                    <input type="text" v-model="nombre" class="form-control input-sm" v-bind:class="{ 'is-invalid': e_nombre }"> 
                                </div>
                            </div>                             
                            <div class="form-row">
                                <div class="input-group input-group-sm mb-3 col-12">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="descripcion">Descripción: </span>
                                    </div>                                    
                                    <textarea  v-model="descripcion" class="form-control" v-bind:class="{ 'is-invalid': e_descripcion }" rows="2"></textarea>
                                </div>                              
                            </div>
                            <div class="form-row">    
                                <div class="input-group input-group-sm mb-3 col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="precio_venta">PVP: </span>
                                    </div>
                                    <input type="number" v-model="precio_venta" class="form-control input-sm" v-bind:class="{ 'is-invalid': e_precio_venta }"> 
                                </div>
                                <div class="input-group input-group-sm mb-3 col-6">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="strock">Stock: </span>
                                    </div>
                                    <input type="number" v-model="stock" class="form-control input-sm" v-bind:class="{ 'is-invalid': e_stock }"> 
                                </div>
                                
                            </div>                     
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary btn-sm" @click="cerrarModal()">Cerrar</button>
                        <button type="button" v-if="tipoAccion==1" class="btn btn-info btn-sm" @click="registrarArticulo()">Guardar</button>                        
                        <button type="button" v-if="tipoAccion==2" class="btn btn-success btn-sm" @click="actualizarArticulo()">Actualizar</button>
                        <button type="button" v-if="tipoAccion==3" class="btn btn-danger btn-sm" @click="eliminarArticulo()">Eliminar</button>

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
import VueBarcode from 'vue-barcode';
    export default {
        data (){
            return {
                articulo_id: 0,
                idcategoria : 0,
                nombre_categoria : '',
                codigo : '',
                nombre : '',
                precio_venta : 0,
                stock : 0,
                descripcion : '',
                arrayArticulo : [],
                arrayCategoria :[],
                arrayCategoriaB :[],
                modal : 0,
                tituloModal : '',
                tipoAccion : 0,

                errorArticulo : 0,
                errorMostrarMsjArticulo : [],
                e_idcategoria : false,
                e_codigo : false,
                e_nombre : false,
                e_precio_venta : false,
                e_stock : false,
                e_descripcion : false,

                
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
                paginado : 10,
                ordenado : 'id',
                ascdesc : 'desc'
            }
        },
        components: {
            'barcode': VueBarcode,
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
            listarArticulo (page,buscar,criterio,paginado,ordenado,ascdesc){
                let me=this;
                var url= '/articulo?page='+page+'&buscar='+buscar+'&criterio='+criterio+'&paginado='+paginado+'&ordenado='+ordenado+'&ascdesc='+ascdesc;
                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    me.arrayArticulo = respuesta.articulos.data;
                    me.pagination= respuesta.pagination;
                })
                .catch(function (error) {
                    console.log(error);
                });
                me.ordenado=ordenado;
                me.ascdesc=ascdesc;
            },
            selectCategoriaB(search,loading){
                let me=this;
                loading(true)

                var url= '/categoria/selectCategoriaB?filtro='+search;
                axios.get(url).then(function (response) {
                    let respuesta = response.data;
                    q: search
                    me.arrayCategoriaB=respuesta.categorias;
                    loading(false)
                })
                .catch(function (error) {
                    console.log(error);
                });
            },
            getDatosCategoriaB(val1){
                let me = this;
                me.loading = true;
                me.buscar = val1.id;
            },
            cargarPdf(){
                window.open('articulo/listarPDF/'); 
                
                
            },
            selectCategoria(){
                let me=this;
                var url= '/categoria/selectCategoria';
                axios.get(url).then(function (response) {
                    //console.log(response);
                    var respuesta= response.data;
                    me.arrayCategoria = respuesta.categorias;
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
                me.listarArticulo(page,buscar,criterio,paginado,ordenado,ascdesc);
            },            
            registrarArticulo(){
               if (this.validarArticulo()){ return; }
                let me = this;

                axios.post('/articulo/registrar',{
                    'idcategoria': this.idcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'stock': this.stock,
                    'precio_venta': this.precio_venta,
                    'descripcion': this.descripcion
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarArticulo(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                });
            },
            actualizarArticulo(){
               if (this.validarArticulo()){ return; }
                let me = this;

                axios.put('/articulo/actualizar',{
                    'idcategoria': this.idcategoria,
                    'codigo': this.codigo,
                    'nombre': this.nombre,
                    'stock': this.stock,
                    'precio_venta': this.precio_venta,
                    'descripcion': this.descripcion,
                    'id': this.articulo_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarArticulo(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            eliminarArticulo(){
               if (this.validarArticulo()){ return; }
                let me = this;

                axios.put('/articulo/eliminar',{
                    'id': this.articulo_id
                }).then(function (response) {
                    me.cerrarModal();
                    me.listarArticulo(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                }).catch(function (error) {
                    console.log(error);
                }); 
            },
            desactivarArticulo(id){
               Swal.fire({
                title: 'Desactivar el artículo?',
                text: "Puede activarla nuevamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, desactivarlo'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/articulo/desactivar',{
                        'id': id
                    }).then(function (response) {
                        me.listarArticulo(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
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
            activarArticulo(id){
               Swal.fire({
                title: 'Activar la artículo?',
                text: "Puede desactivarla nuevamente.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Si, activarlo'
                }).then((result) => {
                if (result.value) {
                    let me = this;
                    axios.put('/articulo/activar',{
                        'id': id
                    }).then(function (response) {
                        me.listarArticulo(me.pagination.current_page,'','nombre',me.paginado,me.ordenado,me.ascdesc);
                        Swal.fire(
                        'Desactivado!',
                        'El registro ha sido activado con éxito.',
                        'success'
                        )
                    }).catch(function (error) {
                        console.log(error);
                    });
                } 
                }) 
            },
            validarArticulo(){
                this.errorArticulo=0;
                 this.errorMostrarMsjArticulo =[];

                if (this.idcategoria == 0) {this.e_idcategoria = true; this.errorMostrarMsjArticulo.push('idcategoria');}else{this.e_idcategoria = false}
                if (!this.codigo) {this.e_codigo = true; this.errorMostrarMsjArticulo.push('codigo');}else{this.e_codigo = false}
                if (!this.nombre) {this.e_nombre = true; this.errorMostrarMsjArticulo.push('nombre');}else{this.e_nombre = false}
                if (!this.descripcion) {this.e_descripcion = true; this.errorMostrarMsjArticulo.push('descripcion');}else{this.e_descripcion = false}
                if (!this.precio_venta) {this.e_precio_venta = true; this.errorMostrarMsjArticulo.push('precio_venta');}else{this.e_precio_venta = false}
                if (!this.stock) {this.e_stock = true; this.errorMostrarMsjArticulo.push('stock');}else{this.e_stock = false}
                

                 if (this.errorMostrarMsjArticulo.length) this.errorArticulo = 1;
                 return this.errorArticulo;
            },
            cerrarModal(){
                this.modal=0;
                this.tituloModal='';

                this.errorArticulo = 0;
                this.errorMostrarMsjArticulo = [];
                this.e_idcategoria = false;
                this.e_codigo = false;
                this.e_nombre = false;
                this.e_precio_venta = false;
                this.e_stock = false;
                this.e_descripcion = false;
                
                this.idcategoria= 0;
                this.nombre_categoria = '';
                this.codigo = '';
                this.nombre = '';
                this.precio_venta = 0;
                this.stock = 0;
                this.descripcion = '';
            },
            abrirModal(modelo, accion, data = []){
                switch(modelo){
                    case "articulo":
                    {
                        switch(accion){
                            case 'registrar':
                            {
                                this.modal = 1;
                                this.tituloModal = 'Registrar Artículo';
                                this.idcategoria=0;
                                this.nombre_categoria='';
                                this.codigo='';
                                this.nombre= '';
                                this.precio_venta=0;
                                this.stock=0;
                                this.descripcion = '';
                                this.tipoAccion = 1;
                                break;
                            }
                            case 'actualizar':
                            {
                                this.modal=1;
                                this.tituloModal='Actualizar Artículo';
                                this.tipoAccion=2;
                                this.articulo_id=data['id'];
                                this.idcategoria=data['idcategoria'];
                                this.codigo=data['codigo'];
                                this.nombre = data['nombre'];
                                this.stock=data['stock'];
                                this.precio_venta=data['precio_venta'];
                                this.descripcion= data['descripcion'];
                                break;
                            }
                            case 'eliminar':
                            {
                                this.modal=1;
                                this.tituloModal='Eliminar Artículo';
                                this.tipoAccion=3;
                                this.articulo_id=data['id'];
                                this.idcategoria=data['idcategoria'];
                                this.codigo=data['codigo'];
                                this.nombre = data['nombre'];
                                this.stock=data['stock'];
                                this.precio_venta=data['precio_venta'];
                                this.descripcion= data['descripcion'];
                                break;
                            }
                        }
                    }
                }
                this.selectCategoria();
            },
            ceroBusqueda(){
                this.buscar='';
                this.listarArticulo(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
            }
        },
        mounted() {
            this.listarArticulo(1,this.buscar,this.criterio,this.paginado,this.ordenado,this.ascdesc);
        }
    }
</script>