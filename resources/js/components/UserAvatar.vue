<template> 

    <div v-if="this.idrol == 2 || this.idrol == 3" class="navbar-brand js-scroll-trigger"> 
        <span class="d-none d-lg-block container">  
            <img class="img-fluid img-profile rounded-circle mx-auto mb-2 image" :src="this.avatar" alt="">
            <div class="middle">
                <div class="icon_file ">
                    <div class="text-mini">{{this.nombre}} {{this.apellido}}</div>
                    <div class="text-light">{{this.perfil}}</div>
                </div>
            </div>
        </span>        
    </div>
    <div v-else class="user-panel mt-3 pb-3 mb-3 d-flex">
        <div class="profile_pic">
            <img :src="this.avatar" class="img-circle profile_img" :alt="this.usuario">
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
                idrol: '',
                nombre : '',
                apellido : '',
                perfil : '',
                avatar : ''                       
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
                    me.avatar=arrayPersona[0]['avatar']; 
                    me.avatar = 'avatars/'+ me.avatar;
                    me.idrol=arrayPersona[0]['idrol'];
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