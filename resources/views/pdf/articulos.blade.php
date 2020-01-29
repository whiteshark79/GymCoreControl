<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Reporte de artículos</title>
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
        padding-bottom: 1.5px;}  

    </style>
</head>
<body>
    <div>
        <h4>Lista de Artículos <span class="derecha">{{now()}}</span></h4>
    </div>
    <div>
        <table class="table table-bordered table-sm table-hover" id="dtTable">
            <thead  class="thead-table"> 
                <tr>
                    <th width="6%">COD</th>
                    <th width="22%">NOMBRE</th>
                    <th>DESCRIPCION</th>
                    <th width="11%">CATEGORÍA</th>
                    <th width="5%">PVP</th>
                    <th width="5%">STOCK</th>                    
                    <th width="10%">ESTADO</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($articulos as $a)
                <tr>
                    <td>{{$a->codigo}}</td>
                    <td>{{$a->nombre}}</td>
                    <td>{{$a->descripcion}}</td>
                    <td>{{$a->nombre_categoria}}</td>
                    <td>{{$a->precio_venta}}</td>
                    <td>{{$a->stock}}</td>                    
                    <td>{{$a->condicion?'Activo':'Desactivado'}}</td>
                </tr>
                @endforeach                               
            </tbody>
        </table>
    </div>
    <div class="izquierda">
        <p><strong>Total de registros: </strong>{{$cont}}</p>
    </div>    
</body>
</html>