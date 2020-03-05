<template>
 
    <main class="main"> 
        <div class="row mt-1">
            <div class="container-fluid">
                <div class="col-md-12">
                    <div class="card card-outline card-primary">
                        <div class="card-header">
                            <div class="card-title"><h3>Dashboard</h3></div>                                                      
                        </div>                     

                        <div class="card-body">
                            <ul class="nav nav-tabs" id="myTab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="inscripcion-tab" data-toggle="tab" href="#inscripcion" role="tab" aria-controls="inscripcion" aria-selected="true"><h6>Inscripciones</h6></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="venta-tab" data-toggle="tab" href="#venta" role="tab" aria-controls="venta" aria-selected="false"><h6>Ventas</h6></a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="inventario-tab" data-toggle="tab" href="#inventario" role="tab" aria-controls="inventario" aria-selected="false"><h6>Inventario</h6></a>
                                </li>
                            </ul>
                            <div class="tab-content" id="myTabContent">
                                <div class="tab-pane fade show active" id="inscripcion" role="tabpanel" aria-labelledby="inscripcion-tab"><dbinscripciones></dbinscripciones></div>
                                <div class="tab-pane fade" id="venta" role="tabpanel" aria-labelledby="venta-tab"><dbventas></dbventas></div>
                                <div class="tab-pane fade" id="inventario" role="tabpanel" aria-labelledby="inventario-tab"><dbinventario></dbinventario></div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>    
    </main>
</template> 

