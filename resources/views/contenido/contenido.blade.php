@extends('principal')

@section('contenido')

@if(Auth::check())
        @if (Auth::user()->idrol == 1)
            <template v-if="menu==0"><dashboardadmin></dashboardadmin></template>
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
            <template v-if="menu==17"><empresa></empresa></template>
            <template v-if="menu==18"><local></local></template>
            <template v-if="menu==19"><horario></horario></template>
            <template v-if="menu==20"><modalidad></modalidad></template>
            <template v-if="menu==21"><rutina></rutina></template>
            <template v-if="menu==22"><calendario></calendario></template>
            <template v-if="menu==23"><especialidad></especialidad></template>
            <template v-if="menu==24"><universidad></universidad></template>
            <template v-if="menu==25"><profesion></profesion></template>
            <template v-if="menu==26"><frase></frase></template>
        @elseif (Auth::user()->idrol == 2)
            <template v-if="menu==0"><perfilalumno></perfilalumno></template> 
        @elseif (Auth::user()->idrol == 3)
            <template v-if="menu==0"><perfilprofesor></perfilprofesor></template>
        @elseif (Auth::user()->idrol == 4)
            <template v-if="menu==0"><dashboardoper></dashboardoper></template>
            <template v-if="menu==1"><caja></caja></template>
            <template v-if="menu==2"><alumno></alumno></template>
            <template v-if="menu==3"><cliente></cliente></template>
            <template v-if="menu==4"><proveedor></proveedor></template>
            <template v-if="menu==5"><articulo></articulo></template>
            <template v-if="menu==6"><categoria></categoria></template>
            <template v-if="menu==7"><servicio></servicio></template>
            <template v-if="menu==8"><clasificacion></clasificacion></template>            
            <template v-if="menu==9"><venta></venta></template>
            <template v-if="menu==10"><inscripcion></inscripcion></template>         
            <template v-if="menu==11"><ingreso></ingreso></template>
            <template v-if="menu==12"><gasto></gasto></template>
            @else
    
        @endif
    
    @endif

@endsection