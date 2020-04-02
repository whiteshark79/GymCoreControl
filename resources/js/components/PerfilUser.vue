<template>
 
    <main class="main">
             
        <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">             
            <label class="text-label">Usuario</label> 
            <input type="text" class="form-control form-control-sm" placeholder="Usuario" name="usuario" :value="usuario" readonly> 
              
            <label class="text-label">Contraseña</label> 
            <input type="password" v-model="password" id="password" class="form-control form-control-sm"  v-bind:class="{ 'is-invalid': e_password }">
            <span class="text-error" v-show="a_pass==1">{{msg_pass}}</span>   

            <label class="text-label">Confirmación</label>   
            <input type="password" v-model="repassword" id="repassword" class="form-control form-control-sm"  v-bind:class="{ 'is-invalid': e_repassword }" >                            
            <span class="text-error" v-show="a_repass==1">{{msg_repass}}</span>   
            
            <label class="text-label pic-label">Avatar</label> 
            <div class="custom-file file-input">                                        
                <input type="file" class="custom-file-input" id="avatarFile" @change="subirImagen" accept=".png, .jpg, .jpeg" v-bind:class="{ 'is-invalid': e_avatarFile }" >
                <label class="custom-file-label" for="avatarFile">Elegir imagen</label>
            </div>            
            <figure v-show="stsImagen==1">
                <div class="row file-img">
                    <div class="col-md-4">
                        <img :src="avatar" alt="Avatar" class="avatar-mini">
                    </div> 
                    <div class="col-md-8 file-data">
                        <p class="text-muted">Nombre: <span class="text-primary">{{picName}} </span></p>
                        <p class="text-muted">Tamaño: <span class="text-primary">{{picSize}} </span> bytes</p>
                        <p class="text-muted">Ancho x Alto: <span class="text-primary">{{picWidth}} X  {{picHeigth}}</span> </p>
                    </div>
                </div>
            </figure>
            
        </form>	  
                 
       
        <div class="modal-footer">
            <button type="button" class="btnClose" data-dismiss="modal">Cerrar</button> 
            <button type="button" class="btnSave" @click="actualizarUsuario()">Actualizar</button> 
        </div>
        <span class="text-error" v-show="a_avatar==1">{{msg_avatar}}</span>
    </main>
</template>

<script>
import Inputmask from 'inputmask';
export default {
    props: ['usuario'],
    data (){
        return {
            password : '',
            repassword : '',
            avatar: '',
            picSize: 0,
            picName: '',
            picWidth: 0,
            picHeigth: 0,

            stsImagen: 0,
            stsBtn: 0,
            a_pass: 0,
            a_repass: 0,
            a_avatar: 0,
            msg_pass: '',
            msg_repass: '',
            msg_avatar: '',

            errorUsuario : 0,
            errorMostrarMsjUsuario : [],
            e_password : false,
            e_repassword : false,
            e_avatarFile : false
        }
    },
    computed:{       
                      
    },
    methods : {
        validarInput(){             
            Inputmask("*{6,15}").mask(password);
            Inputmask("*{6,15}").mask(repassword);
        },        
        validarUsuario(){
            this.errorUsuario=0;
            this.errorMostrarMsjUsuario =[];

            if (!this.password && !this.repassword && !this.avatarFile) 
            {
                this.e_password = true;
                this.e_repassword = true;
                this.e_avatarFile = true;    
                this.a_avatar = 1;
                this.msg_avatar = 'No existen cambios para guardar';             
                this.errorMostrarMsjUsuario.push('all');

            }else if(this.password && !this.repassword){
                this.e_password = false;
                this.e_repassword = false;
                this.e_avatarFile = false;
                this.a_avatar = 0;
                this.msg_avatar = ''; 

                this.e_repassword = true;
                this.a_repass = 1;
                this.msg_repass = 'Digite la confirmación'; 
                this.errorMostrarMsjUsuario.push('repassword');
                          
            }else if(!this.password && this.repassword){
                this.e_repassword = false;
                this.a_repass = 0;
                this.msg_repass = ''; 

                this.e_password = true;
                this.a_pass = 1;
                this.msg_pass = 'Digite la contraseña'; 
                this.errorMostrarMsjUsuario.push('password');

            }else if(this.password != this.repassword){
                this.e_password = false;
                this.a_pass = 0;
                this.msg_pass = ''; 

                this.e_password = true;
                this.e_repassword = true;
                this.a_repass = 1;
                this.msg_repass = 'Las contraseñas no coinciden'; 
                this.errorMostrarMsjUsuario.push('password');
                this.errorMostrarMsjUsuario.push('repassword');
            }else{
                this.e_password = false;
                this.e_repassword = false;
                this.a_repass = 0;
                this.msg_repass = ''; 
            }


            // if(this.password.length < 6){
            //     this.e_password = true;
            //     this.a_pass = 1;
            //     this.msg_pass = 'La contraseña debe tener mínimo 6 caracteres'; 
            //     this.errorMostrarMsjUsuario.push('password');
            // }else{
            //     this.e_password = false;
            //     this.a_pass = 0;
            // }     

             

            if (this.errorMostrarMsjUsuario.length) this.errorUsuario = 1;

            return this.errorUsuario;
        },
        activarBtn(){
            if(this.password != '' && this.repassword == ''){
                this.stsBtn = 1;
            }else{
                this.stsBtn = 0;
            }            
        },        
        subirImagen(e){
          let me = this;
          me.stsImagen = 1;
          me.stsBtn = 1;

          var fileReader =  new FileReader();
          fileReader.readAsDataURL(e.target.files[0]);          

          me.picSize = e.target.files[0].size;
          me.picName = e.target.files[0].name;

          fileReader.onload = (e)=> {
            me.avatar = e.target.result;

            var image = new Image();
            image.src = e.target.result;

            image.onload = function () {
                me.picWidth = this.width;
                me.picHeigth = this.height;
            }
          } 
        }, 
        actualizarUsuario(){ 
            if (this.validarUsuario()){ return; }
            let me = this;         

            axios.put('/user/actualizarUsuario',{
            'password' : this.password,            
            'avatar' : this.avatar
            }).then(function (response) { 
                //location.reload();  
                Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: '<h5>Registro actualizado</h5>',
                width: 250,
                showConfirmButton: false,
                timer: 1500
                })
            }).catch(function (error) {
                console.log(error);
            });       

        }

    },
    mounted() {
        this.validarInput();
        $(".custom-file-input").on("change", function() {
            var fileName = $(this).val().split("\\").pop();
        $(this).siblings(".custom-file-label").addClass("selected").html(fileName);
        });
    }
    
};
</script>