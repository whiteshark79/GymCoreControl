@extends('principal')

@section('contenido')

@if(Auth::check())
        @if (Auth::user()->idrol == 1)
            <template v-if="menu==0"><dashboard></dashboard></template>
            <template v-if="menu==1"><alumno></alumno></template>
            <template v-if="menu==2"><cliente></cliente></template>
            <template v-if="menu==3"><profesor></profesor></template>
            <template v-if="menu==4"><proveedor></proveedor></template>
            <template v-if="menu==5"><articulo></articulo></template>
            <template v-if="menu==6"><categoria></categoria></template>
            <template v-if="menu==7"><servicio></servicio></template>
            <template v-if="menu==8"><clasificacion></clasificacion></template>            
            <template v-if="menu==9"><venta></venta></template>
            <template v-if="menu==10"><inscripcion></inscripcion></template>         
            <template v-if="menu==11"><ingreso></ingreso></template>
            <template v-if="menu==12"><gasto></gasto></template>                        
            <template v-if="menu==13"><user></user></template>
            <template v-if="menu==14"><rol></rol></template>
            <template v-if="menu==15"><consultaingreso></consultaingreso></template>
            <template v-if="menu==16"><consultaventa></consultaventa></template>            
            <template v-if="menu==17"><modalidad></modalidad></template>
            <template v-if="menu==18"><especialidad></especialidad></template>
            <template v-if="menu==19"><universidad></universidad></template>
            <template v-if="menu==20"><profesion></profesion></template>
            <template v-if="menu==21"><provincia></provincia></template>
            <template v-if="menu==22"><canton></canton></template>
            <template v-if="menu==23"><H1>ACERCA DE</H1></template>
        @elseif (Auth::user()->idrol == 2)
            <template v-if="menu==0"><dashboard></dashboard></template>
            <template v-if="menu==22"><H1>ACERCA DE</H1></template>
        @elseif (Auth::user()->idrol == 3)
            <template v-if="menu==0"><dashboard></dashboard></template>
            <template v-if="menu==22"><H1>ACERCA DE</H1></template>
        @elseif (Auth::user()->idrol == 4)
            <template v-if="menu==1"><alumno></alumno></template>
            <template v-if="menu==2"><cliente></cliente></template>
            <template v-if="menu==3"><profesor></profesor></template>
            <template v-if="menu==4"><proveedor></proveedor></template>
            <template v-if="menu==5"><articulo></articulo></template>
            <template v-if="menu==6"><categoria></categoria></template>
            <template v-if="menu==7"><servicio></servicio></template>
            <template v-if="menu==8"><clasificacion></clasificacion></template>            
            <template v-if="menu==9"><venta></venta></template>
            <template v-if="menu==10"><inscripcion></inscripcion></template>         
            <template v-if="menu==11"><ingreso></ingreso></template>
            <template v-if="menu==12"><gasto></gasto></template>
            <template v-if="menu==20"><H1>ACERCA DE</H1></template>
            @else
    
        @endif
    
    @endif

@endsection