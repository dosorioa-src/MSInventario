<template>
    <div class="container-fluid">
            <div class="row">
              
              
              
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <!-- Modal formulario de registro de usuarios -->
                    <button class="btn btn-primary" type="button" data-bs-toggle="modal" data-original-title="test" data-bs-target="#exampleModal" data-bs-original-title="" title="">Registrar Usuarios</button>
                    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" style="display: none;" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel">Registrar Usuario</h5>
                                <button class="btn-close" type="button" data-bs-dismiss="modal" aria-label="Close" data-bs-original-title="" title=""></button>
                            </div>
                            <div class="modal-body">
                                <form v-on:submit.prevent>
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label" for="validationDefault01">Nombres y Apellido</label>
                          <input class="form-control" id="validationDefault01" type="text" v-model="user.name" placeholder="Nombres y Apellido" required="" data-bs-original-title="" title="" style="background-image: url(&quot;data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAABAAAAAQCAYAAAAf8/9hAAABHklEQVQ4EaVTO26DQBD1ohQWaS2lg9JybZ+AK7hNwx2oIoVf4UPQ0Lj1FdKktevIpel8AKNUkDcWMxpgSaIEaTVv3sx7uztiTdu2s/98DywOw3Dued4Who/M2aIx5lZV1aEsy0+qiwHELyi+Ytl0PQ69SxAxkWIA4RMRTdNsKE59juMcuZd6xIAFeZ6fGCdJ8kY4y7KAuTRNGd7jyEBXsdOPE3a0QGPsniOnnYMO67LgSQN9T41F2QGrQRRFCwyzoIF2qyBuKKbcOgPXdVeY9rMWgNsjf9ccYesJhk3f5dYT1HX9gR0LLQR30TnjkUEcx2uIuS4RnI+aj6sJR0AM8AaumPaM/rRehyWhXqbFAA9kh3/8/NvHxAYGAsZ/il8IalkCLBfNVAAAAABJRU5ErkJggg==&quot;); background-repeat: no-repeat; background-attachment: scroll; background-size: 16px 18px; background-position: 98% 50%;">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="validationDefault02">Email</label>
                          <input class="form-control" id="validationDefault02" type="text" v-model="user.email" placeholder="Email" required="" data-bs-original-title="" title="">
                        </div>
                      </div>
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label" for="validationDefault03">Contraseña</label>
                          <input v-if="btn_update_active==0" class="form-control" id="validationDefault03" type="password" required="required" v-model="user.password"  placeholder="*********" data-bs-original-title="" title="">
                          <input v-if="btn_update_active==1" class="form-control" id="validationDefault03" type="password" v-model="user.password"  placeholder="*********" data-bs-original-title="" title="">
                        </div>
                        <div class="col-md-6">
                          <label class="form-label" for="validationDefault04">Rol de Usuario</label>
                          <select class="form-select" id="validationDefault04" v-model="user.role_id" required="">
                            <option selected="" disabled="" value="" >Rol</option>
                            <option v-for="item in Role" :key="item.id" :value="item.id">{{item.name}}</option>
                          </select>
                        </div>
                      </div>
                      <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label" for="validationDefault04">Tipo de ID</label>
                          <select class="form-select" id="validationDefault04" v-model="user.type_indetification_id" required="">
                            <option selected="" disabled="" value="" >Tipo</option>
                            <option v-for="item in TypeID" :key="item.id" :value="item.id">{{item.name}}</option>
                          </select>
                        </div>
                        <div class="col-md-6 mb-6">
                          <label class="form-label" for="validationDefault05">Numero de ID</label>
                          <input class="form-control" id="validationDefault05" type="text" v-model="user.number_identification" placeholder="42455155" required="" data-bs-original-title="" title="">
                        </div>
                      </div>
                      <div class="row g-3">
                        <!-- <div class="col-md-6">
                          <label class="form-label" for="validationDefault01">Subir Fotografía</label>
                          <input type="file" />
                          <button class="btn btn-outline-success btn-sm" @click="uploadPhoto()">Importar</button>
                          <input class="form-control" type="file" id="file" ref="file" v-on:change="choosePhoto()" aria-label="file example"  data-bs-original-title="" title="">
                        </div> -->
                        <div class="col-md-6">
                          <label class="form-label" for="validationDefault03">Teléfono</label>
                          <input class="form-control" id="validationDefault03" type="text" v-model="user.phone"  placeholder="Teléfono" required="" data-bs-original-title="" title="">
                        </div>
                      </div>
                      <div class="col-md-6">
                          <label class="form-label" for="validationDefault04">Estado</label>
                          <select class="form-select" id="validationDefault04" v-model="user.is_active" required="">
                            <option selected="" disabled="" value="" >Estado</option>
                            <option value="1">Activo</option>
                            <option value="0">Inactivo</option>
                          </select>
                        </div>
                      <!-- <div class="row g-3">
                        <div class="col-md-6">
                          <label class="form-label" for="validationDefault02">Fotografía</label>
                          <img src="https://socialtools.me/wp-content/uploads/2016/04/foto-de-perfil.jpg" width="150" />
                        </div>
                      </div> -->
                      <br>
                      <div class="modal-footer">
                                <button v-if="btn_update_active==0" class="btn btn-primary" type="submit" data-bs-original-title="" title="" @click="createUser()">Guardar</button>
                                <button v-if="btn_update_active==1" class="btn btn-primary" type="submit" data-bs-original-title="" title="" @click="editUser()" >Actualizar</button>
                            </div>
                    </form>
                            </div>
                            
                            </div>
                        </div>
                        </div>
                   <!-- FIN Modal formulario de registro de usuarios -->

                  </div>
                  <div class="table-responsive">
                    <table class="table table-sm">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Nombres</th>
                          <th scope="col">Email</th>
                          <!-- <th scope="col">Teléfono</th> -->
                          <th scope="col">Estado</th>
                          <th scope="col">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr v-for="item in users" :key="item.id">
                          <th scope="row">{{item.id}}</th>
                          <td>{{item.name}}</td>
                          <td>{{item.email}}</td>
                          <!-- <td>{{95585456}}</td> -->
                          <td v-if="item.is_active==1"><span class="badge badge-success">Activo</span></td>
                          <td v-if="item.is_active==0"><span class="badge badge-light text-dark">Inactivo</span></td>
                          <td><!-- <button class="btn btn-light btn-xs" type="button" title="" data-bs-original-title="btn btn-light btn-sm" data-original-title="btn btn-primary btn-sm">
                              <svg width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.125 10C13.125 10.8288 12.7958 11.6237 12.2097 12.2097C11.6237 12.7958 10.8288 13.125 10 13.125C9.1712 13.125 8.37634 12.7958 7.79029 12.2097C7.20424 11.6237 6.875 10.8288 6.875 10C6.875 9.1712 7.20424 8.37634 7.79029 7.79029C8.37634 7.20424 9.1712 6.875 10 6.875C10.8288 6.875 11.6237 7.20424 12.2097 7.79029C12.7958 8.37634 13.125 9.1712 13.125 10Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 10C0 10 3.75 3.125 10 3.125C16.25 3.125 20 10 20 10C20 10 16.25 16.875 10 16.875C3.75 16.875 0 10 0 10ZM10 14.375C11.1603 14.375 12.2731 13.9141 13.0936 13.0936C13.9141 12.2731 14.375 11.1603 14.375 10C14.375 8.83968 13.9141 7.72688 13.0936 6.90641C12.2731 6.08594 11.1603 5.625 10 5.625C8.83968 5.625 7.72688 6.08594 6.90641 6.90641C6.08594 7.72688 5.625 8.83968 5.625 10C5.625 11.1603 6.08594 12.2731 6.90641 13.0936C7.72688 13.9141 8.83968 14.375 10 14.375Z" fill="white"/>
                                </svg>
                          </button> -->
                          <button @click="editUserData(item)" data-bs-toggle="modal"  data-bs-target="#exampleModal" data-bs-original-title="" class="btn btn-success btn-xs" type="button" title="" data-bs-original-title="btn btn-success btn-sm" data-original-title="btn btn-warning btn-sm">
                              <svg width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M16.0721 0.175179C15.9549 0.0580096 15.796 -0.0078125 15.6302 -0.0078125C15.4645 -0.0078125 15.3056 0.0580096 15.1884 0.175179L13.1296 2.23393L17.7634 6.86768L19.8221 4.81018C19.8803 4.75212 19.9265 4.68315 19.958 4.60722C19.9895 4.53129 20.0057 4.44989 20.0057 4.36768C20.0057 4.28547 19.9895 4.20407 19.958 4.12814C19.9265 4.05221 19.8803 3.98324 19.8221 3.92518L16.0721 0.175179ZM16.8796 7.75143L12.2459 3.11768L4.12086 11.2427H4.37961C4.54537 11.2427 4.70435 11.3085 4.82156 11.4257C4.93877 11.5429 5.00461 11.7019 5.00461 11.8677V12.4927H5.62961C5.79537 12.4927 5.95435 12.5585 6.07156 12.6757C6.18877 12.7929 6.25461 12.9519 6.25461 13.1177V13.7427H6.87962C7.04538 13.7427 7.20435 13.8085 7.32156 13.9257C7.43877 14.0429 7.50462 14.2019 7.50462 14.3677V14.9927H8.12962C8.29538 14.9927 8.45435 15.0585 8.57156 15.1757C8.68877 15.2929 8.75462 15.4519 8.75462 15.6177V15.8764L16.8796 7.75143ZM7.54462 17.0864C7.51831 17.0165 7.50477 16.9424 7.50462 16.8677V16.2427H6.87962C6.71386 16.2427 6.55488 16.1768 6.43767 16.0596C6.32046 15.9424 6.25461 15.7834 6.25461 15.6177V14.9927H5.62961C5.46385 14.9927 5.30488 14.9268 5.18767 14.8096C5.07046 14.6924 5.00461 14.5334 5.00461 14.3677V13.7427H4.37961C4.21385 13.7427 4.05488 13.6768 3.93767 13.5596C3.82046 13.4424 3.75461 13.2834 3.75461 13.1177V12.4927H3.12961C3.05489 12.4926 2.98079 12.479 2.91086 12.4527L2.68711 12.6752C2.62755 12.7352 2.58077 12.8066 2.54961 12.8852L0.0496099 19.1352C0.00414655 19.2488 -0.00698284 19.3732 0.0176015 19.493C0.0421858 19.6129 0.101403 19.7229 0.187911 19.8094C0.274419 19.8959 0.384414 19.9551 0.50426 19.9797C0.624105 20.0043 0.748531 19.9931 0.862111 19.9477L7.11212 17.4477C7.19069 17.4165 7.26213 17.3697 7.32212 17.3102L7.54462 17.0877V17.0864Z" fill="white"/>
                                </g>
                                <defs>
                                <clipPath id="clip0">
                                <rect width="20" height="20" fill="white"/>
                                </clipPath>
                                </defs>
                                </svg>

                          </button>
                          <button @click="deleteUser(item)"  class="btn btn-secondary btn-xs" type="button" title="" data-bs-original-title="btn btn-secondary btn-sm" data-original-title="btn btn-warning btn-sm">
                              <svg width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <g clip-path="url(#clip0)">
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M1.25 17.5C1.25 17.5 0 17.5 0 16.25C0 15 1.25 11.25 7.5 11.25C13.75 11.25 15 15 15 16.25C15 17.5 13.75 17.5 13.75 17.5H1.25ZM7.5 10C8.49456 10 9.44839 9.60491 10.1517 8.90165C10.8549 8.19839 11.25 7.24456 11.25 6.25C11.25 5.25544 10.8549 4.30161 10.1517 3.59835C9.44839 2.89509 8.49456 2.5 7.5 2.5C6.50544 2.5 5.55161 2.89509 4.84835 3.59835C4.14509 4.30161 3.75 5.25544 3.75 6.25C3.75 7.24456 4.14509 8.19839 4.84835 8.90165C5.55161 9.60491 6.50544 10 7.5 10ZM15.1825 6.4325C15.2406 6.3743 15.3095 6.32812 15.3855 6.29661C15.4614 6.2651 15.5428 6.24888 15.625 6.24888C15.7072 6.24888 15.7886 6.2651 15.8645 6.29661C15.9405 6.32812 16.0094 6.3743 16.0675 6.4325L17.5 7.86625L18.9325 6.4325C19.0499 6.31514 19.209 6.24921 19.375 6.24921C19.541 6.24921 19.7001 6.31514 19.8175 6.4325C19.9349 6.54986 20.0008 6.70903 20.0008 6.875C20.0008 7.04097 19.9349 7.20014 19.8175 7.3175L18.3837 8.75L19.8175 10.1825C19.9349 10.2999 20.0008 10.459 20.0008 10.625C20.0008 10.791 19.9349 10.9501 19.8175 11.0675C19.7001 11.1849 19.541 11.2508 19.375 11.2508C19.209 11.2508 19.0499 11.1849 18.9325 11.0675L17.5 9.63375L16.0675 11.0675C15.9501 11.1849 15.791 11.2508 15.625 11.2508C15.459 11.2508 15.2999 11.1849 15.1825 11.0675C15.0651 10.9501 14.9992 10.791 14.9992 10.625C14.9992 10.459 15.0651 10.2999 15.1825 10.1825L16.6163 8.75L15.1825 7.3175C15.1243 7.25944 15.0781 7.19047 15.0466 7.11454C15.0151 7.03861 14.9989 6.95721 14.9989 6.875C14.9989 6.79279 15.0151 6.71139 15.0466 6.63546C15.0781 6.55953 15.1243 6.49056 15.1825 6.4325Z" fill="white"/>
                                </g>
                                <defs>
                                <clipPath id="clip0">
                                <rect width="20" height="20" fill="white"/>
                                </clipPath>
                                </defs>
                                </svg>
                              </button></td>
                        </tr>
                        
                        
                      </tbody>
                    </table>
                  </div>
                </div>
              </div>
              
            </div>
          </div>
</template>

<script>
    export default {
    data() {
        return {
        btn_update_active:0,
        users: [],
        user:{
            name: "",
            email: "",
            password: "",
            role_id: "",
            phone: "",
            type_indetification_id: "",
            number_identification: "",
            is_active: "",
        },
        TypeID:[],
        Role:[]   
        }
    },
    created(){
        this.loadUser()
        this.loadTypeID()
        this.loadRole()
    },
    methods:{

        loadUser:function() {
            axios.get('/api/user/load').then(res=>{
            this.users = res.data;
            console.log(this.users)
            })
        },
        loadTypeID:function() {
            axios.get('/api/typeid/load').then(res=>{
            this.TypeID = res.data;
            })
        },
        loadRole:function() {
            axios.get('/api/role/load').then(res=>{
                this.Role = res.data;
            })
        },
        createUser:function(){
            axios.post('/api/user/add',this.user).then(res=>{
                this.loadUser()
            })
        },
        deleteUser:function(item) {
            this.user = item
            axios.post('/api/user/delete',this.user).then(res=>{
                this.loadUser()
            })
        },
        editUserData:function(item) {
            this.user = item
            this.btn_update_active=1
        },
        editUser:function() {
            axios.put('/api/user/edit',this.user).then(res=>{
                this.loadUser()
                this.btn_update_active=0
                this.user=[]
            })
        },
        
        /* choosePhoto:function(){
            this.file = this.$refs.file.files[0];
        }, */
    }
    }
</script>
