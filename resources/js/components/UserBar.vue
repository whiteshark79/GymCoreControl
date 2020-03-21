<template>      


    <div class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="profile_pic">
            <img src="/img/user.jpg" class="img-circle profile_img" alt="User Image">
        </div>
        <div class="info menu_title">
            <span>Bienvenid@,</span>
            <h6>{{nombre}} <span class="text-bold">{{apellido}}</span></h6>
            <span class="user-status">
                <i class="fa fa-circle"></i>
                <span>{{perfil}}</span>
            </span>
          
        </div>
    </div>
   

</template>

<script>
    export default {
        data (){
            return {
                usuario: '',
                nombre : '',
                apellido : '',
                perfil : ''                             
            }
        },        
        methods : {
            selectPersonaLogin(){
                let me=this;

                var arrayPersona=[];
                var url= '/cliente/selectPersonaLogin';

                axios.get(url).then(function (response) {
                    var respuesta= response.data;
                    arrayPersona = respuesta.personas;

                    me.usuario=arrayPersona[0]['usuario'];
                    me.nombre=arrayPersona[0]['nombre'];
                    me.apellido=arrayPersona[0]['apellido'];
                    me.perfil=arrayPersona[0]['perfil']; 
                })
                .catch(function (error) {
                    console.log(error);
                });
            }
        },
        mounted() {
            this.selectPersonaLogin();
        }
    }
</script>