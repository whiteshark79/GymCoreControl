<template>
    <main class="main">

        <li class="nav-item dropdown">
            <a class="nav-link dropdown-toggle nav-link" data-toggle="dropdown" href="#">
                <div class="user-block">  
                <img class="img-circle img-bordered-sm" src="/img/logo_empresa.png">          
                <span class="username">
                    <a>{{ nombre }} </a>                    
                </span>
                <span class="description">{{ slogan }}</span>
            </div>
            
            </a>
            <div class="dropdown-menu" aria-labelledby="navbarDropdown">
            <a class="dropdown-item"><i class="fas fa-cogs"></i> Datos Empresa</a>          
            </div>
        </li>    
    
    


    </main>
</template>

<script>
export default {
    data (){
        return {
            ArrayEmpresa:[],

            nombre :'',
            slogan :'',
            direccion :'',
            telefono :'',
            email :'',
            web :''            
        }   
    },
    methods : {
        datosEmpresa(){
            let me=this;
            var url= '/empresa';
            axios.get(url).then(function (response) {
                //console.log(response);
                var respuesta= response.data;
                me.ArrayEmpresa = respuesta.empresas;
                me.loadDatosEmpresa(); 
            })
            .catch(function (error) {
                console.log(error);
            });
        },
        loadDatosEmpresa(){
            let me=this;
            
            me.ArrayEmpresa.map(function(x){
                me.nombre = x.nombre;
                me.slogan = x.slogan;
                me.direccion = x.direccion;
                me.telefono = x.telefono;
                me.email = x.email;
                me.web = x.web;
            });
        }
    },
    mounted() {
        this.datosEmpresa();
    }
}

</script>
