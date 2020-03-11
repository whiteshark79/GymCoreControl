<template> 
    <main class="main">
      <div class="container-fluid">

        <div class="row mt-3">
          <div class="col-md-3">

            <form action="" method="post" enctype="multipart/form-data" class="form-horizontal">

              <div class="card card-primary card-outline">
                <div class="card-body box-profile">
                  <div class="text-center">
                    <img class="profile-user-img img-fluid img-circle" v-if="sexo == 'H'" src="/img/avatar5.png" alt="Foto">
                    <img class="profile-user-img img-fluid img-circle" v-else src="/img/avatar3.png" alt="Foto">
                  </div>

                  <h3 class="profile-username text-center">{{nombre}}</h3>                  
                    <ul class="list-group list-group-unbordered mb-3">
                      <li class="list-group-item">
                        <div class="form-row">
                          <div class="form-group col-md-5 text-label">C.I.</div>
                          <div class="form-group col-md-7">
                            <input type="number" v-model="num_documento" class="form-control form-control-sm" v-bind:class="{ 'is-invalid': e_num_documento }" placeholder="Número de documento" :disabled="stsEditar == 0">
                          </div>
                        </div>
                      </li>                    
                      <li class="list-group-item">
                        <div class="form-row">
                          <div class="form-group col-md-5 text-label">Cumpleaños</div>
                          <div class="form-group col-md-7">
                            <input type="date" v-model="fec_nacimiento" class="form-control form-control-sm" v-bind:class="{ 'is-invalid': e_fec_nacimiento }" :disabled="stsEditar == 0">
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="form-row">
                          <div class="form-group col-md-5 text-label">Correo</div>
                          <div class="form-group col-md-7">
                            <input type="email" v-model="email" class="form-control form-control-sm" v-bind:class="{ 'is-invalid': e_email }" placeholder="Email" :disabled="stsEditar == 0">  
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="form-row">
                          <div class="form-group col-md-5 text-label">Celular</div>
                          <div class="form-group col-md-7">
                            <input type="number" v-model="celular" class="form-control form-control-sm" v-bind:class="{ 'is-invalid': e_celular }" placeholder="Celular" :disabled="stsEditar == 0">
                          </div>
                        </div>
                      </li>
                      <li class="list-group-item">
                        <div class="form-row">
                          <div class="form-group col-md-5 text-label">Dirección</div>
                          <div class="form-group col-md-7">
                            <textarea  v-model="direccion" class="form-control form-control-sm" v-bind:class="{ 'is-invalid': e_direccion }" rows="2" maxlength="60" :disabled="stsEditar == 0"></textarea>
                          </div>
                        </div>
                      </li>
                    </ul>

                                
                </div>
                <!-- /.card-body -->                
              </div>

            </form>

          </div>

          <div class="col-md-7">
            <div class="card card-primary card-outline">
              <div class="card-header">
                <h3 class="card-title"><i class="far fa-clipboard mr-1"></i>DATOS</h3>                
                <div class="card-tools">
                  <button type="button" class="btn btn-primary btn-sm daterange" v-if="stsEditar==0" @click="activarPerfil()"><i class="fas fa-edit"></i></button>                                  
                </div>
              </div>
              
                <div class="card-body">                   

                  <div class="card">
                    <h5 class="text-muted">Laborales</h5>
                    <div class="form-row m-1">
                      <div class="form-group col-md-12">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Área de Profesión</span>
                          </div>
                          <select class="form-control col-8" v-model="idprofesion" :disabled="stsEditar == 0">                                                                
                            <option v-for="profesion in arrayProfesion" :key="profesion.id" :value="profesion.id" v-text="profesion.nombre" ></option>
                          </select>
                          <select v-model="sit_laboral" class="form-control col-4" :disabled="stsEditar == 0">
                            <option value="0" disabled>--Sit. Laboral--</option>
                            <option value="E">Empresario</option>
                            <option value="D">Dependiente</option>
                            <option value="I">Independiente</option>
                            <option value="P">Desempleado</option>                                           
                          </select>
                        </div>                      
                      </div>
                    </div>
                    <div class="form-row m-1">
                      <div class="form-group col-md-12">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Empresa</span>
                          </div>                      
                          <input type="text" maxlength="60" v-model="empresa" class="form-control" placeholder="Nombre Empresa" :disabled="stsEditar == 0">
                          <input type="text" maxlength="30" v-model="cargo" class="form-control" placeholder="Cargo" :disabled="stsEditar == 0">
                        </div>
                      </div>
                    </div>
                    <div class="form-row m-1">
                      <div class="form-group col-md-4">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Estudiante</span>
                          </div>
                          <select v-model="estudiante" class="form-control" :disabled="stsEditar == 0">
                            <option value="0" disabled>--Estudiante--</option>
                            <option value="S">Si</option>
                            <option value="N">No</option>                                       
                          </select>
                        </div>
                      </div>
                      <div class="form-group col-md-8">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend">
                            <span class="input-group-text">Universidad</span>
                          </div>
                          <select class="form-control" v-model="iduniversidad" :disabled="stsEditar == 0">
                              <option value="0" disabled>--Universidad--</option>
                              <option v-for="universidad in arrayUniversidad" :key="universidad.id" :value="universidad.id" v-text="universidad.nombre"></option>
                          </select>
                        </div>
                      </div>

                    </div>
                  </div>

                  <div class="card">
                    <h5 class="text-muted">Físicos</h5>
                    <div class="form-row m-1">
                      <div class="form-group col-md-4">
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Edad</span>
                            </div>
                            <input type="number" min="8" max="80" v-model="edad" class="form-control" placeholder="Edad" :disabled="stsEditar == 0">                                                        
                          </div>
                      </div>
                      <div class="form-group col-md-4">
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Peso <small>(lbs.)</small></span>
                            </div>
                            <input type="number" min="60" max="300" v-model="peso" class="form-control"  placeholder="Peso (lbs.)" :disabled="stsEditar == 0">
                          </div>                                        
                      </div>
                      <div class="form-group col-md-4">
                          <div class="input-group input-group-sm">
                            <div class="input-group-prepend">
                              <span class="input-group-text">Estatura <small>(cms.)</small></span>
                            </div>
                            <input type="number" min="100" max="200" v-model="estatura" class="form-control"  placeholder="Estatura (cms.)" :disabled="stsEditar == 0">                                                      
                          </div>
                      </div>
                    </div>
                    <div class="form-row m-1">
                      <div class="form-group col-md-4">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend">
                              <span class="input-group-text">Activo?</span>
                            </div>
                          <select v-model="nivel_actividad" class="form-control" :disabled="stsEditar == 0">
                            <option value="0" disabled>--Nivel de Actividad--</option>
                            <option value="S">Sedentarismo/a</option>
                            <option value="PA">Poco activo</option>
                            <option value="A">Activo</option>
                            <option value="MA">Muy activo</option>                                      
                          </select>                                                     
                        </div>
                      </div>
                      <div class="form-group col-md-4">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend">
                              <span class="input-group-text">Ejercicios?</span>
                            </div>
                          <select v-model="tipo_actividad" class="form-control" :disabled="stsEditar == 0">
                            <option value="0" disabled>--Tipo de Actividad--</option>
                            <option value="NA">No aplica</option>
                            <option value="C">Caminar</option>
                            <option value="G">Gimnasio</option>
                            <option value="CF">Crossfit</option>
                            <option value="AM">Artes Marciales</option>                                          
                          </select>
                        </div>
                      </div>
                      <div class="form-group col-md-4">
                        <div class="input-group input-group-sm">
                          <div class="input-group-prepend">
                              <span class="input-group-text">Objetivo?</span>
                            </div>
                          <select v-model="objetivo" class="form-control" :disabled="stsEditar == 0">
                            <option value="0" disabled>--Objetivo--</option>
                            <option value="BP">Bajar de peso</option>
                            <option value="FR">Fuerza-Resistencia</option>
                            <option value="DP">Defensa Personal</option>
                            <option value="C">Competir</option>
                            <option value="T">Terapia</option>
                            <option value="RL">Recuperación Lesión</option>                                         
                          </select>
                        </div>
                      </div>                                                                                             
                  </div>                 

                </div>     
                
              </div>
              <div class="card-footer">                       
                <button type="button" v-if="stsEditar==1" class="btn btn-success btn-sm float-right" @click="actualizarPersona()">Actualizar</button>
              </div>                     

            </div>
          </div>          
        </div>
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
          nombre : '',
          fec_nacimiento : '',                
          direccion : '',
          celular : '',
          email : '',

          usuario : '',
          sexo : 0,
          estado_civil : 0,
          hijos : 0,
          sector : 0,
          idprofesion : 1,
          sit_laboral : 0,
          empresa : '',
          cargo : '',
          estudiante : 0,
          iduniversidad : 0,
          edad : '',
          peso : '',
          estatura : '',
          nivel_actividad : 0,
          tipo_actividad : 0,
          objetivo : 0,
          
          arrayProfesion: [],
          arrayUniversidad: [],

          errorPersona : 0,
          errorMostrarMsjPersona : [],                
          e_num_documento : false,
          e_nombre : false,
          e_sexo : false,
          e_fec_nacimiento : false,
          e_celular : false,
          e_email : false,
          e_direccion : false,

          stsEditar : 0

        }
      },
      computed:{        
        
      },
      methods : {
        activarPerfil(){
          this.stsEditar = 1;
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
        verAlumno(){
          let me=this;

          var arrayPersona=[];
          var url= '/alumno/selectAlumnoId';

          axios.get(url).then(function (response) {
            var respuesta= response.data;
            arrayPersona = respuesta.personas;

            me.persona_id=arrayPersona[0]['id'];
            me.tipo_documento=arrayPersona[0]['tipo_documento'];
            me.num_documento=arrayPersona[0]['num_documento'];                                
            me.nombre = arrayPersona[0]['nombre'];
            me.fec_nacimiento = arrayPersona[0]['fec_nacimiento'];                               
            me.direccion= arrayPersona[0]['direccion'];
            me.celular= arrayPersona[0]['celular'];
            me.email= arrayPersona[0]['email'];

            me.usuario=arrayPersona[0]['usuario'];
            me.sexo= arrayPersona[0]['sexo'];
            me.sector= arrayPersona[0]['sector'];
            me.estado_civil= arrayPersona[0]['estado_civil'];
            me.hijos= arrayPersona[0]['hijos'];
            me.idprofesion= arrayPersona[0]['idprofesion'];
            me.sit_laboral= arrayPersona[0]['sit_laboral'];
            me.empresa= arrayPersona[0]['empresa'];
            me.cargo= arrayPersona[0]['cargo'];
            me.estudiante= arrayPersona[0]['estudiante'];
            me.iduniversidad= arrayPersona[0]['iduniversidad'];
            me.edad= arrayPersona[0]['edad'];
            me.peso= arrayPersona[0]['peso'];
            me.estatura= arrayPersona[0]['estatura'];
            me.nivel_actividad= arrayPersona[0]['nivel_actividad'];
            me.tipo_actividad= arrayPersona[0]['tipo_actividad'];
            me.objetivo= arrayPersona[0]['objetivo'];
          })
          .catch(function (error) {
              console.log(error);
          });
        },
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

            'usuario' : this.usuario,
            'sexo' : this.sexo,
            'estado_civil' : this.estado_civil,
            'hijos' : this.hijos,
            'sector' : this.sector,
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
              Swal.fire({
                position: 'top-end',
                icon: 'success',
                title: 'Datos actualizados',
                showConfirmButton: false,
                timer: 1500
              })
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
        this.verAlumno();
        this.selectProfesion();
        this.selectUniversidad();
      }
    }
</script>