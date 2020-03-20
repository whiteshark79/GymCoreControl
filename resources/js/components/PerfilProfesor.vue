<template> 
    <main class="main">
      <div class="container-fluid p-0">

    <table class="table-hr data-table collapse-table responsive-table">
      <thead>
      <tr>
        <th></th>
        <th>IMAGE</th>
        <th>TYPE</th>
        <th>MAKE</th>
        <th>MODEL</th>
        <th>DESCRIPTION</th>
      </tr>  	
      </thead>
      <tbody>
      <tr class="collapse">
        <td data-label="Bipod"><i class="h3 fa fa-plus-square js-tdToggle"></i></td>
        <td data-label="IMAGE" class="collapse"><img src="https://brash-ui.firebaseapp.com/img/test-pic1.png" width="100px;" alt="testimg">
      </td>
        <td data-label="TYPE">Bipod</td>
        <td data-label="MAKE">Manufacturer</td>
        <td data-label="MODEL">Manufacturer</td>
        <td data-label="DESC">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</td>
      </tr>
      <tr class="collapse">
        <td data-label="Grip"><i class="h3 fa fa-plus-square js-tdToggle"></i></td>
        <td data-label="IMAGE" class="collapse">
          <img src="https://brash-ui.firebaseapp.com/img/test-pic1.png" width="100px;" alt="testimg">
      </td>
        <td data-label="TYPE">Grip</td>
        <td data-label="MAKE">Manufacturer</td>
        <td data-label="MODEL">Manufacturer</td>
        <td data-label="DESC">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</td>
      </tr>
      <tr class="collapse">
        <td data-label="Scope"><i class="h3 fa fa-plus-square js-tdToggle"></i></td>
        <td data-label="IMAGE" class="collapse">
          <img src="https://brash-ui.firebaseapp.com/img/test-pic1.png" width="100px;" alt="testimg">
      </td>
        <td data-label="TYPE">Scope</td>
        <td data-label="MAKE">Manufacturer</td>
        <td data-label="MODEL">Manufacturer</td>
        <td data-label="DESC">It is a long established fact that a reader will be distracted by the readable content of a page when looking at its layout.</td>
      </tr>
                  
      </tbody>
    </table>

        

        
      </div>

    </main>
</template>

<script>
  export default {
    data (){
      return {  
        persona_id: 0,
        tipo_documento : 'C',
        num_documento : '',   
        num_documento_ : '',              
        nombre : '',
        local : '',
        fec_nacimiento : '',                
        direccion : '',
        celular : '',
        email : '',
        email_ : '',
        foto : '',
        miniatura : '',

        usuario : '',
        sexo : 0,
        estado_civil : 0,
        hijos : 0,
        sector : 0,
        idlocal : 1,
        idprofesion : 1,
        sit_laboral : 0,
        empresa : '',
        cargo : '',
        estudiante : 0,
        idprovincia : 1,
        iduniversidad : 1,
        edad : '',
        peso : '',
        estatura : '',
        nivel_actividad : 0,
        tipo_actividad : 0,
        objetivo : 0,
        
        arrayProfesion: [],
        arrayUniversidad: [],
        arrayProvincia: [],

        stsPersona : '',
        stsPersonaId : '',
        stsPersonaEmail : '',

        errorPersona : 0,
        errorMostrarMsjPersona : [],                
        e_num_documento : false,
        e_nombre : false,
        e_sexo : false,
        e_fec_nacimiento : false,
        e_celular : false,
        e_email : false,
        e_direccion : false,

        stsEditar : 0,
        stsEditar_ : 0     

      }
    },
    computed:{        
      
    },
    methods : {
      activarPerfil(){
        this.stsEditar = 1;
      }, 
      activarUniversidad(){
        this.stsEditar_ = 1;
      },        
      selectProfesion(){
        let me=this;
        var url= '/profesion/selectProfesion';
        axios.get(url).then(function (response) {
          //console.log(response);
          var respuesta= response.data;
          me.arrayProfesion = respuesta.profesiones;
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      selectProvincia(){
        let me=this;
        var url= '/provincia/selectProvincia';
        axios.get(url).then(function (response) {
          //console.log(response);
          var respuesta= response.data;
          me.arrayProvincia = respuesta.provincias;
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      selectUniversidad(){
        let me=this;      

        var url= '/universidad/selectUniversidad';
        axios.get(url).then(function (response) {
            //console.log(response);
            var respuesta= response.data;
            me.arrayUniversidad = respuesta.universidades;
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      selectUniversidadId(){
        let me=this;

        var url= '/universidad/selectUniversidadId?idprovincia=' + me.idprovincia;
        axios.get(url).then(function (response) {
            //console.log(response);
            var respuesta= response.data;
            me.arrayUniversidad = respuesta.universidadesId;
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      verProfesor(){
        let me=this;

        var arrayPersona=[];
        var url= '/profesor/selectProfesorId';

        axios.get(url).then(function (response) {
          var respuesta= response.data;
          arrayPersona = respuesta.personas;

          me.persona_id=arrayPersona[0]['id'];
          me.tipo_documento=arrayPersona[0]['tipo_documento'];
          me.num_documento=arrayPersona[0]['num_documento'];   
          me.num_documento_=arrayPersona[0]['num_documento'];                               
          me.nombre = arrayPersona[0]['nombre'];
          me.fec_nacimiento = arrayPersona[0]['fec_nacimiento'];                               
          me.direccion= arrayPersona[0]['direccion'];
          me.celular= arrayPersona[0]['celular'];
          me.email= arrayPersona[0]['email'];
          me.email_= arrayPersona[0]['email'];
          me.perfil= arrayPersona[0]['perfil'];
          me.foto= arrayPersona[0]['foto'];

          me.horario=arrayPersona[0]['horario'];
          me.idespecialidad= arrayPersona[0]['idespecialidad'];
          me.especialidad= arrayPersona[0]['especialidad'];
          me.sueldo_hora= arrayPersona[0]['sueldo_hora'];
        })
        .catch(function (error) {
            console.log(error);
        });
      },
      existePersonaId(){
        let me=this;    

        if(me.num_documento != me.num_documento_){
          var url= '/cliente/selectPersonaId?num_documento='+me.num_documento;
          axios.get(url).then(function (response) {
            //console.log(response);
            var respuesta= response.data;
            me.stsPersonaId = respuesta.stsPersonaId;      
            me.habilitarGuardar();               
          })                
          .catch(function (error) {
              console.log(error);
          });
        }else{
          me.stsPersona=''; 
          me.stsPersonaId='';
        }           
      },
      existePersonaEmail(){
        let me=this;

        if(me.email != me.email_){
          var url= '/cliente/selectPersonaEmail?email='+this.email;
          axios.get(url).then(function (response) {
            //console.log(response);
            var respuesta= response.data;
            me.stsPersonaEmail = respuesta.stsPersonaEmail;  
            me.habilitarGuardar();                   
          })                
          .catch(function (error) {
              console.log(error);
          });
        }else{
          me.stsPersona=''; 
          me.stsPersonaEmail='';
        }     
      },
      habilitarGuardar(){
        let me=this;
        if(me.stsPersonaId || me.stsPersonaEmail){ me.stsPersona=1;
        }else{ me.stsPersona=''; }
      },
      // obtenerImagen(e){
      //   let me=this;
      //   let file = e.target.files[0];
      //   me.foto = file;
      //   me.cargarImagen(file);
      // },
      // cargarImagen(file){
      //   let me = this;
      //   let reader = new FileReader();

      //   reader.onload = (e)=> { me.miniatura = e.target.result; }
      //   reader.readAsDataURL(file);
      // },
      actualizarPersona(){
        if (this.validarPersona()){ return; }
        let me = this;

        axios.put('/alumno/actualizar',{
          'tipo_documento' : this.tipo_documento,
          'num_documento' : this.num_documento,
          'nombre' : this.nombre,
          'fec_nacimiento' : this.fec_nacimiento,                    
          'direccion' : this.direccion,                  
          'celular' : this.celular,
          'email' : this.email,
          'foto' : this.foto,

          'usuario' : this.usuario,
          'sexo' : this.sexo,
          'estado_civil' : this.estado_civil,
          'hijos' : this.hijos,
          'sector' : this.sector,
          'idlocal' : this.idlocal,
          'idprofesion' : this.idprofesion,
          'sit_laboral' : this.sit_laboral,
          'empresa' : this.empresa,
          'cargo' : this.cargo,
          'estudiante' : this.estudiante,
          'iduniversidad' : this.iduniversidad,
          'edad' : this.edad,
          'peso' : this.peso,
          'estatura' : this.estatura,
          'nivel_actividad' : this.nivel_actividad,
          'tipo_actividad' : this.tipo_actividad,
          'objetivo' : this.objetivo,
          'id': this.persona_id
        }).then(function (response) {
            me.stsEditar = 0;
            // Swal.fire({
            //   position: 'top-end',
            //   icon: 'success',
            //   title: 'Datos actualizados',
            //   showConfirmButton: false,
            //   timer: 1500
            // })
          }).catch(function (error) {
              console.log(error);
        }); 
      },
      validarPersona(){
        this.errorPersona=0;
        this.errorMostrarMsjPersona =[];

        if (!this.num_documento) {this.e_num_documento = true; this.errorMostrarMsjPersona.push('num_documento');}else{this.e_num_documento = false}
        if (!this.nombre) {this.e_nombre = true; this.errorMostrarMsjPersona.push('nombre');}else{this.e_nombre = false}
        if (!this.sexo) {this.e_sexo = true; this.errorMostrarMsjPersona.push('sexo');}else{this.e_sexo = false}
        if (!this.fec_nacimiento) {this.e_fec_nacimiento = true; this.errorMostrarMsjPersona.push('fec_nacimiento');}else{this.e_fec_nacimiento = false}
        if (!this.celular) {this.e_celular = true; this.errorMostrarMsjPersona.push('celular');}else{this.e_celular = false}
        if (!this.email) {this.e_email = true; this.errorMostrarMsjPersona.push('email');}else{this.e_email = false}

        if (this.errorMostrarMsjPersona.length) this.errorPersona = 1;
        return this.errorPersona;
      },
    },
    mounted() {
      this.verProfesor();
      this.selectProfesion();
      this.selectProvincia();
      this.selectUniversidad();
      
    }
  }
</script>