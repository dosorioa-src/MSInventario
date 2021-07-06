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
                  <input class="form-control" type="text" v-model="buscador" @keyup="buscarCategoria" placeholder="Nombre de categría...">
                </div>
              </div>

              <div class="col-md-8 col-sm-12 align-self-end text-end">
                <button
                  @click="btn_update_active=0, modal_title='Nueva Categoría'"
                  class="btn btn-primary"
                  type="button"
                  data-bs-toggle="modal"
                  data-original-title="test"
                  data-bs-target="#exampleModal"
                  data-bs-original-title=""
                  title=""
                >
                  Nueva Categoria
                </button>                
              </div>  
            </div>       

          </div>

          <!-- INICIO MODAL - REGISTRAR CATEGORIA -->
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
                    {{modal_title}}
                  </h5>
                  <button
                    @click="clearFields(), loadCategorie()"
                    class="btn-close"
                    type="button"
                    data-bs-dismiss="modal"
                    aria-label="Close"
                    data-bs-original-title=""
                    title=""
                  ></button>
                </div>

                <div class="modal-body">
                  <form v-on:submit.prevent novalidate>
                    <div class="row">
                      <div class="col-md-12">
                        <p><i>Los campos con (*) son obligatorios...</i></p>
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault01"
                          >Nombre de Categoría(*)</label
                          >
                          <input
                            class="form-control"
                            id="validationDefault01"
                            type="text"
                            v-model="categorie.name"
                            placeholder="Nombre de Categoría"
                            @blur="$v.categorie.name.$touch()"
                          />
                          <template v-if="$v.categorie.name.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.categorie.name.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                          
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="">Categoria Principal</label>
                          <select
                            class="form-select"
                            v-model="categorie.parent_id"                    
                            required = ""
                          >
                            <option selected="" disabled="" value="">Seleccione tipo</option>
                            <option v-for="item in listCategories" :key="item.id" :value="item.id">{{ item.name }}</option>
                          </select>                          
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="">Estado</label>
                          <select
                            class="form-select"
                            v-model="categorie.is_active"
                            required=""
                          >
                            <option selected="" disabled="" value="">Seleccione estado</option>
                            <option value = "1">Activo</option>
                            <option value = "0">Inactivo</option>
                          </select>
                        </div>
                      </div>                   
                    </div> 

                  </form>
                </div>

                <div class="modal-footer">
                  <button
                    @click="createcategorie()"
                    v-if="btn_update_active == 0"
                    class="btn btn-primary"
                    type="submit"
                    data-bs-original-title=""
                    title=""
                    :disabled="$v.$invalid"
                  >
                    Guardar
                  </button>
                  <button
                    @click="editCategorie()"
                    v-if="btn_update_active == 1"
                    class="btn btn-primary"
                    type="submit"
                    data-bs-original-title=""
                    title=""
                    :disabled="$v.$invalid"
                  >
                    Actualizar
                  </button>
                  <button
                    @click="clearFields(), loadCategorie()"
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
          <!-- FIN MODAL - REGISTRAR CATEGORIA -->   

            <div class="card-body" style="padding: 20px 40px !important">
              <div class="table-responsive style-1 table-hover non-hover">
                 <table class="table table-bordered">
                    <thead>
                       <tr>
                          <th scope="col">#</th>
                          <th scope="col">Categoría</th>
                          <th scope="col">Categoría Principal</th>
                          <th scope="col">N° productos</th>
                          <th scope="col">Stock</th>
                          <th scope="col">Valorado Precio</th>
                          <th scope="col">Valorado Costo</th>
                          <th scope="col">Estado</th>
                          <th scope="col">Acciones</th>
                       </tr>
                    </thead>
                    <tbody>
                       <tr style="vertical-align:middle" v-for="item in categories" v-bind:key="item.id">
                          <td>{{item.id}}</td>
                          <td>{{item.name}}</td>
                          <td>{{item.parent}}</td>
                          <td>{{item.total_products}}</td>
                          <td>{{item.stock}}</td>
                          <td>{{item.sum_price}}</td>
                          <td>{{item.sum_cost}}</td>
                          <td v-if="item.is_active == 1"><span class="badge badge-primary">Activo</span></td>
                          <td v-if="item.is_active == 0"><span class="badge-light text-dark">Inactivo</span></td>
                          <td>
                            <div class="btn-group">
                              <button @click="editCategorieData(item), btn_update_active=1, modal_title='Editar Categoría'" class="btn btn-primary btn-xs" type="button" title=""  data-bs-toggle="modal"  data-bs-target="#exampleModal" data-bs-original-title tittle>
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
                              <button  @click="deleteCategorie(item)" class="btn btn-secondary btn-xs" type="button" title="" data-bs-original-title tittle>
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
                   <p class="card-text">Mostrando de {{(pagination.from)}} a {{(pagination.to)}} de {{pagination.total}} categorías.</p>
                </div>
                <div class="col-md-6">
                  <nav>
                    <ul class="pagination justify-content-end pagination-primary">
                      <li :class="(pagination.current_page==1)?'page-item disabled':'page-item'">
                        <a @click.prevent="loadCategorie(pagination.current_page-1)" class="page-link" href="#" tabindex="-1" data-bs-original-title="" title="">Anterior</a>
                      </li>
                      <li v-if="pagination.current_page>1" class="page-item">
                        <a @click.prevent="loadCategorie(pagination.current_page-1)" class="page-link" href="#" data-bs-original-title="" title="">{{pagination.current_page-1}}</a>
                      </li>
                      <li class="page-item active">
                        <a class="page-link" href="#" data-bs-original-title="" title="">{{pagination.current_page}}<span class="sr-only">(current)</span></a>
                      </li>
                      <li v-if="pagination.current_page!=pagination.last_page" class="page-item">
                        <a @click.prevent="loadCategorie(pagination.current_page+1)" class="page-link" href="#" data-bs-original-title="" title="">{{pagination.current_page+1}}</a>
                      </li>
                      <li :class="(pagination.current_page==pagination.last_page)?'page-item disabled':'page-item'">
                        <a @click.prevent="loadCategorie(pagination.current_page+1)" class="page-link" href="#" data-bs-original-title="" title="">Siguiente</a>
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
  import { required } from 'vuelidate/lib/validators'
  export default {
    data() {
        return {
            page:1,
            pagination: [],
            buscador: '',
            setTimeoutBuscador: '',            
            modal_title:'',
            btn_update_active:0,
            listCategories: [],
            categories: [],
            categorie:{
                  name: "",
                  parent_id: "",
                  is_active: "1",
            },
        }
    },
    created(){
        this.loadCategorie(this.page)
        this.loadListCategories()
    },
    methods:{
        //Métodos de Carga
        loadCategorie:function(page) {
            this.page = page
            axios.get('/api/categorie/load?page='+this.page,{
              params:{
                buscador: this.buscador
              }
            })
            .then(res=>{
              this.pagination = res.data;
              this.categories = res.data.data;
            })
            .catch(error => {
              console.log(error.response)
            });
        },

        loadListCategories: function(){
            axios.get('/api/categorie/index')
            .then(res=>{
              this.listCategories = res.data;
            })          
        },

        //Métodos de Mantenimiento
        createcategorie:function(){
            axios.post('/api/categorie/add',this.categorie).then(res=>{
              Swal.fire({
                title: 'Registro Exitoso!',
                text: "Se registró categoría correctamente.",
                icon: 'success',
                confirmButtonColor: '#98B631',
                confirmButtonText: 'De acuerdo'
              })              
              this.clearFields()              
              $('#exampleModal').modal('hide')
              this.loadCategorie(this.page)
            })
        },
        
        editCategorieData:function(item) {
            this.categorie = item
        },
        editCategorie:function() {
            axios.put('/api/categorie/edit',{
              id: this.categorie.id,
              name: this.categorie.name,
              parent_id: this.categorie.parent_id,
              is_active: this.categorie.is_active
            }).then(res=>{
              Swal.fire({
                title: 'Actualización Exitosa!',
                text: "Se actualizó categoría correctamente.",
                icon: 'success',
                confirmButtonColor: '#98B631',
                confirmButtonText: 'De acuerdo'
              })                 
              this.clearFields()
              $('#exampleModal').modal('hide')
              this.loadCategorie(this.page)
              this.loadListCategories()
            })
        },
        deleteCategorie:function(item) {
            this.categorie = item
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
                axios.post('/api/categorie/delete',this.categorie).then(res=>{
                  Swal.fire({
                    title: 'Eliminado!',
                    text: "Se ha eliminado la categoría.",
                    icon: 'success',
                    confirmButtonColor: '#98B631',
                    confirmButtonText: 'De acuerdo'
                  })                                     
                  this.loadCategorie(this.page)
                })                
              }
            })            
            
        },

        //Métodos adicionales
        buscarCategoria(){
          clearTimeout(this.setTimeoutBuscador)
          this.setTimeoutBuscador = setTimeout(this.loadCategorie, 360)
        },

        clearFields() {
          this.categorie.name = "",
          this.categorie.parent = "",
          this.categorie.parent_id = "",
          this.categorie.is_active = "1",
          this.$v.$reset()
        }        
        /* choosePhoto:function(){
            this.file = this.$refs.file.files[0];
        }, */
    },

    validations: {
      categorie: {
        name: {
          required
        }
      }
    }

    // computed: {
    //   items() {
    //     return this.categories.filter(item => {
    //       return item.name.toLowerCase().includes(this.buscar.toLowerCase());
    //     });
    //   }
    // },    
  }
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
