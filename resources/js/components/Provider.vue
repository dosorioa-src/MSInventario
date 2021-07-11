<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header" style="padding: 20px 40px !important">

            <div class="row">
              <div class="col-md-4 col-sm-12">
                <label for="">Buscar por:</label>
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="17" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>                    
                  </span></div>
                  <input class="form-control" type="text" v-model="buscador" @keyup="buscarProveedor" placeholder="Nombre de proveedor...">
                </div>
              </div>

              <div class="col-md-8 col-sm-12 align-self-end text-end">
                <button
                  @click="btn_update_active=0, modal_title='Nuevo Proveedor'"
                  class="btn btn-primary"
                  type="button"
                  data-bs-toggle="modal"
                  data-original-title="test"
                  data-bs-target="#exampleModal"
                  data-bs-original-title=""
                  title=""
                >
                  Nuevo Proveedor
                </button>              
              </div>  
            </div> 

          </div>

          <!-- INICIO MODAL - REGISTRAR PROVEEDOR -->
          <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            style="display: none"
            aria-hidden="true"
          >
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                    {{ modal_title }}
                  </h5>
                  <button
                    class="btn-close"
                    type="button"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                    data-bs-original-title=""
                    title=""
                    @click="clearFields()"
                  ></button>
                </div>

                <div class="modal-body">
                  <form v-on:submit.prevent novalidate>
                    <div class="row">
                      <div class="col-md-12">
                        <p><i>Los campos con (*) son obligatorios...</i></p>
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault01"
                          >Nombre de Contacto(*)</label
                          >
                          <input
                            class="form-control"
                            type="text"
                            v-model="provider.name"
                            placeholder=""
                            @blur="$v.provider.name.$touch()"
                          />
                          <template v-if="$v.provider.name.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.provider.name.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template> 
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault01"
                          >Nombre de la Compañía(*)</label
                          >
                          <input
                            class="form-control"
                            type="text"
                            v-model="provider.company_name"
                            placeholder=""
                            @blur="$v.provider.company_name.$touch()"
                          />
                          <template v-if="$v.provider.company_name.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.provider.company_name.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                             
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault01"
                          >RUT(*)</label
                          >
                          <input
                            class="form-control"
                            type="number"
                            v-model="provider.rut_number"
                            placeholder=""
                            @blur="$v.provider.rut_number.$touch()"
                          />
                          <template v-if="$v.provider.rut_number.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.provider.rut_number.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                          
                          <template v-if="$v.provider.rut_number.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.provider.rut_number.minLength"
                            >
                              Min. 9 caracteres(*)
                            </p>
                          </template>                          
                        </div>
                      </div>
                    </div>  

                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault01"
                          >Email(*)</label
                          >
                          <input
                            class="form-control"
                            type="email"
                            v-model="provider.email"
                            placeholder=""
                            @blur="$v.provider.email.$touch()"
                          />
                          <template v-if="$v.provider.email.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.provider.email.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                              
                          <template v-if="$v.provider.email.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.provider.email.email"
                            >
                              Correo inválido(*)
                            </p>
                          </template>                              
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault01"
                          >Teléfono(*)</label
                          >
                          <input
                            class="form-control"
                            type="number"
                            v-model="provider.phone_number"
                            placeholder=""
                            @blur="$v.provider.phone_number.$touch()"
                          />
                          <template v-if="$v.provider.phone_number.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.provider.phone_number.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                           
                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault01"
                          >Dirección(*)</label
                          >
                          <input
                            class="form-control"
                            type="text"
                            v-model="provider.address"
                            placeholder=""
                            @blur="$v.provider.address.$touch()"
                          />
                          <template v-if="$v.provider.address.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.provider.address.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                          
                        </div>
                      </div>
                    </div>

                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="">Estado</label>
                          <select
                            class="form-select"
                            v-model="provider.is_active"
                            required=""
                          >
                            <option selected="" disabled="" value="">Seleccione estado</option>
                            <option value = "1">Activo</option>
                            <option value = "0">Inactivo</option>
                          </select>
                        </div>
                      </div>                     


                  </form>
                </div>

                <div class="modal-footer">
                  <button
                    @click="createProvider()"
                    v-if="btn_update_active == 0"
                    class="btn btn-primary"
                    type="submit"
                    :disabled="$v.$invalid"
                  >
                    Guardar
                  </button>
                  <button
                    @click="editProvider()"
                    v-if="btn_update_active == 1"
                    class="btn btn-primary"
                    type="submit"
                    :disabled="$v.$invalid"
                  >
                    Actualizar
                  </button>
                  <button
                    @click="clearFields()"
                    class="btn btn-light"
                    type="button"                    
                    data-bs-dismiss="modal"              
                  >
                    Cancelar
                  </button>
                </div>                
              </div>
            </div>
          </div>
          <!-- FIN MODAL - REGISTRAR PROVEEDOR -->            

          <div class="card-body">
            <div class="table-responsive style-1 table-hover non-hover">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">#</th>
                    <th scope="col">Contacto</th>
                    <th scope="col">Compañia</th>
                    <th scope="col">RUT</th>
                    <th scope="col">Email</th>
                    <th scope="col">Teléfono</th>
                    <th scope="col">Estado</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in providers.data" :key="item.id" >
                    <th>{{ item.id }}</th>
                    <td>{{ item.name }}</td>
                    <td>{{ item.company_name }}</td>
                    <td>{{ item.rut_number }}</td>
                    <td>{{ item.email }}</td>
                    <td>{{ item.phone_number }}</td>
                    <td v-if="item.is_active == 1"><span class="badge badge-primary">Activo</span></td>
                    <td v-if="item.is_active == 0"><span class="badge-light text-dark">Inactivo</span></td>
                    <td>
                      <div class="btn-group">
                        <button @click="editProviderData(item), btn_update_active=1, modal_title='Editar Proveedor'" class="btn btn-primary btn-xs" type="button" title=""  data-bs-toggle="modal"  data-bs-target="#exampleModal">
                            <svg class="align-middle" width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
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
                        <button  @click="deleteProvider(item)" class="btn btn-secondary btn-xs" type="button" title="">
                          <svg class="align-middle" width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                          <rect width="19.1667" height="20" fill="url(#pattern0)"/>
                          <defs>
                          <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                          <use xlink:href="#image0" transform="translate(-0.0217391) scale(0.0163043 0.015625)"/>
                          </pattern>
                          <image id="image0" width="64" height="64" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABAEAQAAABQ8GUWAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAAAGAAAABgAPBrQs8AAAAHdElNRQflBhMGEigOfYnbAAAEjklEQVR42u1bMWsUQRT+3kaTaBKNokYtxKTR1hAtFM0fsBBEwX8gGJBgZyWCaCEIVmktRFBBGwtBBE2hlaWEEJEIKuRiYuId8UxuPos1ubu9ncvuzM7sqfm6zb2dee+b9968eTsBHILs7CRv3aL68IGpUCqR4+NUJ0+61M85yCdP0hkexcoKeeJE3naYGa+OHbMzfhUvX7rUc5O7oY8cqWdkdhZYXEz0qhw4AGz6o9vgoEsCnIEcHa1bSDUykvzd6enqi79+udTToQdMToKPHq09ytRU8nefPQN37Qrfq1RcErCBDfznkCRCVENDkFOngM2b81Y4GQoF8OFDCYpF66HICxdIpbLZ033i/Xty61ZL40XSl7GthIsX17MxaM7A0BBkYCBj//SI8+ftCMC5c3mbYIfhYXLfPgsCzp7N2wQ7BAFw5owRAVR79vzd7r+Ko0eNCIAUCsDTp3mrb4diEXzwoJnEunUAVV8fpKsrb1OMwM+fJSiX81ZjAxv4l0Beu0aWy3nXeA1QU1PkoUNujVft7WGjskWhbt9Oa1OQSrrVuzMG+qUiQKRSAefn87ZTC87OOiUgZKFQ0P94/z4wMgK8erW+shMTwOgoeOcOsLzcXHhpCbx5E7hyBZie1uuWnoDUIF+/jg/AatVI1dFBfvyoD9blZXL//uqY1683D+7Ll6uyhw/rc8Dp02ntSe8B1HnAu3drCxGUy8Dbt/oxPn0S+fKl+oc3b5pPOj6+NrZMTIClUqyYgQcYhIBukmi53CRXiFL1hESeG1AdiwwCyJYt8XIzM+4JgM4Denvrjfr+Pf3YOiwsVMft6QmPuTFgs/zkmwCpUdoKJFj7SW379ni5clmCHz88EKALgQgByIqAUkmClZX1CUi/+mYE6NyMUcWyCoEokRoCDGoAMwJ0dYBEPcARAZK7ByQNAc8eIL4IkIRJ0BkB0XlW4SkERH7+BOI+OXV0kJ2desWzIkCXA3x5AIBkW6HvEPCVBAEk2QpFlpaADBqSTEiAtyTYdDIHtYD8TSHgohZI6gHedgFAz7aTWqDVCiFAn3DogIBEIaAUZG7OHwFoMQ/g3JwY9iuz3QWiOYAZJMGGY3UMAYbxb0GARw+oCQEyCIDu7kYh815gtkkwujqZ9AQSNEMMt0BzAsTXgYgEa5sc2W6B5gRgYQGIu8ObNQFumyHGBIiQwLdv7glwexI0JiBEHOvRxqhtDnB7DrAjIC7xZF4KJ+wGGVaBdgTEJULp6qJqb3dGQOskQUDvdrVKeiLA+zYIIFFPICgWgdos7ogAi4+ijj0gzogUSHQULhbDNp1vAujhE1mik6C5+9sRkLQaFJs8EP0vs23bGmXs7gQ48ICDB9dEKALs3Nkos3s32dZWJWnv3vixduyof+7vb5Sx8wBz+1VfX/wtha9fyePHqXp6whtlOty9S/b2koOD4Q2vOMzMkMPDVN3d5NWr8TL37uVDANvayMXFbK95meDGDRs7jEMg7MC8eJEL+3Ur8fx5fnNzYICcn89v9cfG8uYfZH8/+fixv3CoVMjJSfLSpbBDZIffopjI4lWS+PYAAAAldEVYdGRhdGU6Y3JlYXRlADIwMjEtMDYtMTlUMDY6MTg6NDArMDA6MDAqQ4KvAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDIxLTA2LTE5VDA2OjE4OjQwKzAwOjAwWx46EwAAAABJRU5ErkJggg=="/>
                          </defs>
                          </svg>
                        </button>
                      </div>
                    </td>
                  </tr>
                </tbody>
              </table>
            </div>

            <div class="row mt-4 align-items-center">
              <div class="col-md-6">
                  <p class="card-text">Mostrando de {{(providers.from)}} a {{(providers.to)}} de {{providers.total}} marcas.</p>
              </div>
              <div class="col-md-6">
                <nav>
                  <ul class="pagination justify-content-end pagination-primary">
                    <li :class="(providers.current_page==1)?'page-item disabled':'page-item'">
                      <a @click.prevent="loadProviders(providers.current_page-1)" class="page-link" href="#" tabindex="-1" data-bs-original-title="" title="">Anterior</a>
                    </li>
                    <li v-if="providers.current_page>1" class="page-item">
                      <a @click.prevent="loadProviders(providers.current_page-1)" class="page-link" href="#" data-bs-original-title="" title="">{{providers.current_page-1}}</a>
                    </li>
                    <li class="page-item active">
                      <a class="page-link" href="#" data-bs-original-title="" title="">{{providers.current_page}}<span class="sr-only">(current)</span></a>
                    </li>
                    <li v-if="providers.current_page!=providers.last_page" class="page-item">
                      <a @click.prevent="loadProviders(providers.current_page+1)" class="page-link" href="#" data-bs-original-title="" title="">{{providers.current_page+1}}</a>
                    </li>
                    <li :class="(providers.current_page==providers.last_page)?'page-item disabled':'page-item'">
                      <a @click.prevent="loadProviders(providers.current_page+1)" class="page-link" href="#" data-bs-original-title="" title="">Siguiente</a>
                    </li>
                  </ul>
                </nav>
              </div>
              </div>

          </div>

        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Swal from 'sweetalert2'
import { required, minLength, email } from 'vuelidate/lib/validators'
export default {
  data() {
    return {
      page:1,
      buscador: "",
      modal_title: "",
      btn_update_active: 0,
      providers: [],
      provider: {
        name: "",
        company_name: "",
        rut_number: "",
        email: "",
        phone_number: "",
        address: "",
        is_active: "1"
      },
    }
  },

  created(){
    this.loadProviders(this.page)
  },

  methods: {
    //Métodos de carga de data
    loadProviders:function(page) {
      this.page = page
      axios.get('/api/provider/load?page='+this.page,{
        params: {
          buscador: this.buscador
        }
      }).then(res=>{
      this.providers = res.data;
      console.log(this.providers)
      })      
    },

    //Métodos de mantenimiento
    createProvider:function(){
      axios.post('/api/provider/add',this.provider).then(res=>{
        Swal.fire({
          title: 'Registro Exitoso!',
          text: "Se registró proveedor correctamente.",
          icon: 'success',
          confirmButtonColor: '#98B631',
          confirmButtonText: 'De acuerdo'
        })
        this.clearFields()         
        $('#exampleModal').modal('hide')
        this.loadProviders(this.page)
      })
    },

    deleteProvider:function(item) {
      this.provider = item
      Swal.fire({
        title: '¿Estás seguro?',
        text: "‎¡No podrás revertir esto!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#98B631',
        cancelButtonColor: '#f73164',
        confirmButtonText: 'Sí, eliminar!',
        cancelButtonText: 'Cancelar'
      }).then((result) => {        
        if (result.isConfirmed) {        
          axios.post('/api/provider/delete',this.provider).then(res=>{
            Swal.fire({
              title: 'Eliminado!',
              text: "Se ha eliminado el provedor.",
              icon: 'success',
              confirmButtonColor: '#98B631',
              confirmButtonText: 'De acuerdo'
            })                 
            this.loadProviders(this.page)
          })
        }
      }) 
    },
    editProviderData:function(item) {
      this.provider = item
    },
    editProvider:function() {
      axios.put('/api/provider/edit',this.provider).then(res=>{
        Swal.fire({
          title: 'Actualización Exitosa!',
          text: "Se actualizó proveedor correctamente.",
          icon: 'success',
          confirmButtonColor: '#98B631',
          confirmButtonText: 'De acuerdo'
        })
        this.clearFields()       
        $('#exampleModal').modal('hide')
        this.loadProviders(this.page)
      })
    },

    clearFields() {
      this.provider= {
        name: "",
        company_name: "",
        rut_number: "",
        email: "",
        phone_number: "",
        address: "",
        is_active: 1        
      }
      this.$v.$reset()
    },

    buscarProveedor(){
      clearTimeout(this.setTimeoutBuscador)
      this.setTimeoutBuscador = setTimeout(this.loadProviders, 360)
    },      
  },

  validations: {
    provider: {
      name: {
        required
      },
      company_name: {
        required
      },
      rut_number: {
        required,
        minLength: minLength(9)
      },
      email: {
        required,
        email
      },
      phone_number: {
        required
      },
      address: {
        required
      }
    }
  }
};
</script>

<style scoped>
.error {
  text-align: left;
  color: #f73164;
  margin-top: 0%;
  margin-bottom: 0%;
  font-size: 0.75rem;
}
</style>