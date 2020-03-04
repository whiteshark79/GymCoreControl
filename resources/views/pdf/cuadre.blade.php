<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Cuadre de Caja</title>
    <style>
        body {
            margin: 0;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            font-size: 0.6rem;
            font-weight: normal;
            line-height: 1.3;
            color: #151b1e;           
        }
        .table {
            display: table;
            width: 100%;
            max-width: 100%;
            margin-bottom: 1rem;
            background-color: transparent;
            border-collapse: collapse;
        }
        .table-bordered {
            border: 1px solid #c2cfd6;
        }
        thead {
            display: table-header-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table th, .table td {
            padding: 0.75rem;
            vertical-align: top;
            border-top: 1px solid #c2cfd6;
        }
        .table thead th {
            vertical-align: bottom;
            border-bottom: 2px solid #c2cfd6;
        }
        .table-bordered thead th, .table-bordered thead td {
            border-bottom-width: 2px;
        }
        .table-bordered th, .table-bordered td {
            border: 1px solid #c2cfd6;
        }
        th, td {
            display: table-cell;
            vertical-align: inherit;
        }
        th {
            font-weight: bold;
            text-align: -internal-center;
            text-align: left;
        }
        tbody {
            display: table-row-group;
            vertical-align: middle;
            border-color: inherit;
        }
        tr {
            display: table-row;
            vertical-align: inherit;
            border-color: inherit;
        }
        .table-striped tbody tr:nth-of-type(odd) {
            background-color: rgba(0, 0, 0, 0.05);
        }
        .izquierda{
            float:left;
        }
        .derecha{
            float:right;
        }
        .thead-table {
            border-bottom: 3px solid #B6B6B6; 
        }
        #dtTable {
            font-size: 14px;
            border-collapse: collapse;
            width: 100%;
        } 
        #dtTable td {
            padding-top: 1.5px;
            padding-bottom: 1.5px;
        } 
        .text-total{
            color: #3C8DBC !important;
            font-size: 15px;
            font-weight: bolder;
        } 

    </style>
</head>
<body>
    <div>
        <h4>Cuadre de Caja <span class="derecha">{{now()}}</span></h4>
    </div>
    <div>
        <h2>INSCRIPCIONES</h2>
        <table class="table table-bordered table-sm table-hover" id="dtTable">
            <thead  class="thead-table"> 
                <tr>
                    <th width="40%">ALUMNO</th> 
                    <th width="12%">TOTAL</th>
                    <th width="12%">ABONO</th>
                    <th width="12%">SALDO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($inscripcionesDia as $ins)
                <tr>
                    <td>{{$ins->insalumno}}</td>
                    <td align="right"><small>$</small>{{$ins->instotal}}</td>
                    <td align="right"><small>$</small>{{$ins->insabono}}</td>
                    <td align="right"><small>$</small>{{$ins->instotal-$ins->insabono}}</td>           
                </tr>
                @endforeach                               
            </tbody>
            <table width="253" align="right">                                                                
                <tr class="text-total">                    
                    <td width="33%" align="right"><small>$</small> {{ $inscripcionesValorMes }}</td>
                    <td width="33%" align="right"><small>$</small> {{ $inscripcionesDeudaMes }}</td>
                    <td width="33%" align="right"><small>$</small> {{ ($inscripcionesValorMes-$inscripcionesDeudaMes) }}</td>
                </tr>                                                                                                                                  
            </table>
        </table>
        
    </div>
    <div class="izquierda">
        <p><strong>Total de registros: </strong>{{$inscnt}}</p>
    </div> 
    <br><br><br>
    <div>
        <h2>VENTAS</h2>
        <table class="table table-bordered table-sm table-hover" id="dtTable">
            <thead  class="thead-table"> 
                <tr>
                    <th width="40%">CLIENTE</th> 
                    <th width="12%">TOTAL</th>
                    <th width="12%">ABONO</th>
                    <th width="12%">SALDO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ventasDia as $ven)
                <tr>
                    <td>{{$ven->vencliente}}</td>
                    <td align="right"><small>$</small>{{$ven->ventotal}}</td>
                    <td align="right"><small>$</small>{{$ven->venabono}}</td>
                    <td align="right"><small>$</small>{{$ven->ventotal-$ven->venabono}}</td>           
                </tr>
                @endforeach                               
            </tbody>
            <table width="253" align="right">                                                                
                <tr class="text-total">                    
                    <td width="33%" align="right"><small>$</small> {{ $ventasValorMes }}</td>
                    <td width="33%" align="right"><small>$</small> {{ $ventasDeudaMes }}</td>
                    <td width="33%" align="right"><small>$</small> {{ ($ventasValorMes-$ventasDeudaMes) }}</td>
                </tr>                                                                                                                                  
            </table>
        </table>
    </div>
    <div class="izquierda">
        <p><strong>Total de registros: </strong>{{$vencnt}}</p>
    </div> 
    <br><br><br>
    <div>
        <h2>GASTOS</h2>
        <table class="table table-bordered table-sm table-hover" id="dtTable">
            <thead  class="thead-table"> 
                <tr>
                    <th width="40%">PROVEEDOR</th> 
                    <th width="12%">TOTAL</th>
                    <th width="12%">ABONO</th>
                    <th width="12%">SALDO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($gastosDia as $gas)
                <tr>
                    <td>{{$gas->gasproveedor}}</td>
                    <td align="right"><small>$</small>{{$gas->gastotal}}</td>
                    <td align="right"><small>$</small>{{$gas->gasabono}}</td>
                    <td align="right"><small>$</small>{{$gas->gastotal-$gas->gasabono}}</td>           
                </tr>
                @endforeach                               
            </tbody>
            <table width="253" align="right">                                                                
                <tr class="text-total">                    
                    <td width="33%" align="right"><small>$</small> {{ $gastosValorMes }}</td>
                    <td width="33%" align="right"><small>$</small> {{ $gastosDeudaMes }}</td>
                    <td width="33%" align="right"><small>$</small> {{ ($gastosValorMes-$gastosDeudaMes) }}</td>
                </tr>                                                                                                                                  
            </table>
        </table>
    </div>
    <div class="izquierda">
        <p><strong>Total de registros: </strong>{{$gascnt}}</p>
    </div>   
    <br><br><br> 
    <div>
        <h2>COMPRAS</h2>
        <table class="table table-bordered table-sm table-hover" id="dtTable">
            <thead  class="thead-table"> 
                <tr>
                    <th width="40%">PROVEEDOR</th> 
                    <th width="12%">TOTAL</th>
                    <th width="12%">ABONO</th>
                    <th width="12%">SALDO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($ingresosDia as $ing)
                <tr>
                    <td>{{$ing->ingproveedor}}</td>
                    <td align="right"><small>$</small>{{$ing->ingtotal}}</td>
                    <td align="right"><small>$</small>{{$ing->ingabono}}</td>
                    <td align="right"><small>$</small>{{$ing->ingtotal-$ing->ingabono}}</td>           
                </tr>
                @endforeach                               
            </tbody>
            <table width="253" align="right">                                                                
                <tr class="text-total">                    
                    <td width="33%" align="right"><small>$</small> {{ $ingresosValorMes }}</td>
                    <td width="33%" align="right"><small>$</small> {{ $ingresosDeudaMes }}</td>
                    <td width="33%" align="right"><small>$</small> {{ ($ingresosValorMes-$ingresosDeudaMes) }}</td>
                </tr>                                                                                                                                  
            </table>
        </table>
    </div>
    <div class="izquierda">
        <p><strong>Total de registros: </strong>{{$ingcnt}}</p>
    </div> 
</body>
</html>