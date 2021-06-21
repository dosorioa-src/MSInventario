<template>
    <div class="container-fluid">
   <div class="row">
      <div class="col-sm-12">
         <div class="card">
          <div class="card-header d-flex flex-row-reverse">
            <button
              @click="btn_update_active=0, modal_title='Nuevo Ajuste'"
              class="btn btn-primary"
              type="button"
              data-bs-toggle="modal"
              data-original-title="test"
              data-bs-target="#exampleModal"
              data-bs-original-title=""
              title=""
            >
              Nuevo Ajuste
            </button>

          <!-- INICIO MODAL - REGISTRAR AJUSTE -->
          <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            style="display: none"
            aria-hidden="true"
          >
            <div class="modal-dialog modal-lg" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">
                    {{modal_title}}
                  </h5>
                  <button
                    @click="clearFields()"
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
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="">Almacen</label>
                          <select
                            class="form-select"
                            v-model="tweak.warehouse_id"             
                            required = ""
                          >
                            <option selected="" disabled="" value="">Seleccione almacén</option>
                            <option v-for="item in warehouses" :key="item.id" :value="item.id" >{{ item.name }}</option>
                          </select>                          
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault03"
                            >Archivo</label
                          >
                          <input class="form-control" type="file" title="">
                        </div>                    
                      </div>                  
                    </div>
                    
                    <div class="row align-items-end">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault01"
                          >Producto</label
                          >
                          <Dropdown
                            :options="options"
                            v-on:selected="validateSelection"
                            v-on:filter="getDropdownValues"
                            :disabled="false"
                            placeholder="Please select an animal">
                          </Dropdown>
                        </div>
                      </div>

                      <div class="col-md-3">
                        <div class="mb-3">
                          <button  type='button' class="btn btn-light" @click="addNewRow">
                              Agregar
                          </button>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <div class="form-label">Lista</div>
                            <div class="table-responsive style-1 table-hover non-hover">
                              <table class="table table-bordered">
                                <thead>
                                  <tr>
                                      <th scope="col">#</th>
                                      <th scope="col">Producto</th>
                                      <th scope="col">Código</th>
                                      <th scope="col">Cantidad</th>
                                      <th scope="col">Ajuste</th>
                                      <th scope="col">Acción</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(item, index) in tweak.list">
                                      <td style="vertical-align: middle;" >1</td>
                                      <td style="vertical-align: middle;">
                                        {{item.product_id}}
                                      </td>
                                      <td style="vertical-align: middle;">
                                        {{item.product_id}}
                                      </td>
                                      <td>
                                        <vue-number-input v-model="item.qty" :min="1" inline center controls></vue-number-input>                                                                      
                                      </td>                                        
                                      <td>
                                        <select
                                          class="form-select"
                                          v-model="item.action"                    
                                          required = ""
                                        >
                                          <option value="1">Adición</option>
                                          <option value="2">Sustracción</option>
                                        </select>                                          
                                      </td>
                                      <td>
                                        <div class="btn-group">
                                          <button @click="deleteRow(index)" class="btn btn-secondary" style = "background-color: #898989; display: inline-block;" type="button">
                                            <!-- <svg class="align-middle" width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink">
                                            <rect width="19.1667" height="20" fill="url(#pattern0)"/>
                                            <defs>
                                            <pattern id="pattern0" patternContentUnits="objectBoundingBox" width="1" height="1">
                                            <use xlink:href="#image0" transform="translate(-0.0217391) scale(0.0163043 0.015625)"/>
                                            </pattern>
                                            <image id="image0" width="64" height="64" xlink:href="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABAEAQAAABQ8GUWAAAABGdBTUEAALGPC/xhBQAAACBjSFJNAAB6JgAAgIQAAPoAAACA6AAAdTAAAOpgAAA6mAAAF3CculE8AAAAAmJLR0QAAKqNIzIAAAAJcEhZcwAAAGAAAABgAPBrQs8AAAAHdElNRQflBhMGEigOfYnbAAAEjklEQVR42u1bMWsUQRT+3kaTaBKNokYtxKTR1hAtFM0fsBBEwX8gGJBgZyWCaCEIVmktRFBBGwtBBE2hlaWEEJEIKuRiYuId8UxuPos1ubu9ncvuzM7sqfm6zb2dee+b9968eTsBHILs7CRv3aL68IGpUCqR4+NUJ0+61M85yCdP0hkexcoKeeJE3naYGa+OHbMzfhUvX7rUc5O7oY8cqWdkdhZYXEz0qhw4AGz6o9vgoEsCnIEcHa1bSDUykvzd6enqi79+udTToQdMToKPHq09ytRU8nefPQN37Qrfq1RcErCBDfznkCRCVENDkFOngM2b81Y4GQoF8OFDCYpF66HICxdIpbLZ033i/Xty61ZL40XSl7GthIsX17MxaM7A0BBkYCBj//SI8+ftCMC5c3mbYIfhYXLfPgsCzp7N2wQ7BAFw5owRAVR79vzd7r+Ko0eNCIAUCsDTp3mrb4diEXzwoJnEunUAVV8fpKsrb1OMwM+fJSiX81ZjAxv4l0Beu0aWy3nXeA1QU1PkoUNujVft7WGjskWhbt9Oa1OQSrrVuzMG+qUiQKRSAefn87ZTC87OOiUgZKFQ0P94/z4wMgK8erW+shMTwOgoeOcOsLzcXHhpCbx5E7hyBZie1uuWnoDUIF+/jg/AatVI1dFBfvyoD9blZXL//uqY1683D+7Ll6uyhw/rc8Dp02ntSe8B1HnAu3drCxGUy8Dbt/oxPn0S+fKl+oc3b5pPOj6+NrZMTIClUqyYgQcYhIBukmi53CRXiFL1hESeG1AdiwwCyJYt8XIzM+4JgM4Denvrjfr+Pf3YOiwsVMft6QmPuTFgs/zkmwCpUdoKJFj7SW379ni5clmCHz88EKALgQgByIqAUkmClZX1CUi/+mYE6NyMUcWyCoEokRoCDGoAMwJ0dYBEPcARAZK7ByQNAc8eIL4IkIRJ0BkB0XlW4SkERH7+BOI+OXV0kJ2desWzIkCXA3x5AIBkW6HvEPCVBAEk2QpFlpaADBqSTEiAtyTYdDIHtYD8TSHgohZI6gHedgFAz7aTWqDVCiFAn3DogIBEIaAUZG7OHwFoMQ/g3JwY9iuz3QWiOYAZJMGGY3UMAYbxb0GARw+oCQEyCIDu7kYh815gtkkwujqZ9AQSNEMMt0BzAsTXgYgEa5sc2W6B5gRgYQGIu8ObNQFumyHGBIiQwLdv7glwexI0JiBEHOvRxqhtDnB7DrAjIC7xZF4KJ+wGGVaBdgTEJULp6qJqb3dGQOskQUDvdrVKeiLA+zYIIFFPICgWgdos7ogAi4+ijj0gzogUSHQULhbDNp1vAujhE1mik6C5+9sRkLQaFJs8EP0vs23bGmXs7gQ48ICDB9dEKALs3Nkos3s32dZWJWnv3vixduyof+7vb5Sx8wBz+1VfX/wtha9fyePHqXp6whtlOty9S/b2koOD4Q2vOMzMkMPDVN3d5NWr8TL37uVDANvayMXFbK95meDGDRs7jEMg7MC8eJEL+3Ur8fx5fnNzYICcn89v9cfG8uYfZH8/+fixv3CoVMjJSfLSpbBDZIffopjI4lWS+PYAAAAldEVYdGRhdGU6Y3JlYXRlADIwMjEtMDYtMTlUMDY6MTg6NDArMDA6MDAqQ4KvAAAAJXRFWHRkYXRlOm1vZGlmeQAyMDIxLTA2LTE5VDA2OjE4OjQwKzAwOjAwWx46EwAAAABJRU5ErkJggg=="/>
                                            </defs>
                                            </svg>                                       -->
                                            Borrar
                                          </button>
                                        </div>
                                      </td>
                                  </tr>
                                </tbody>
                            </table>
                          </div>                          

                        </div>
                      </div>
                    </div>
                    
                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label for="exampleFormControlTextarea4">Nota</label>
                          <textarea class="form-control" id="exampleFormControlTextarea4" v-model="tweak.note" rows="3"></textarea>
                        </div>
                      </div>
                    </div>                                         

                  </form>
                </div>

                <div class="modal-footer">
                  <button
          
                    v-if="btn_update_active == 0"
                    class="btn btn-primary"
                    type="submit"
                    data-bs-original-title=""
                    title=""
                  >
                    Guardar
                  </button>
                  <button
                   
                    v-if="btn_update_active == 1"
                    class="btn btn-primary"
                    type="submit"
                    data-bs-original-title=""
                    title=""
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
          <!-- FIN MODAL - REGISTRAR CATEGORIA -->   

          </div>
            <div class="table-responsive style-1 table-hover non-hover">
               <table class="table table-bordered">
                  <thead>
                     <tr>
                        <th scope="col">#</th>
                        <th scope="col">Almacen</th>
                        <th scope="col">T. Aumento</th>
                        <th scope="col">T. Descuento</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Acciones</th>
                     </tr>
                  </thead>
                  <tbody>
                     <tr>
                        <td>1</td>
                        <td>Almacen</td>
                        <td>10</td>
                        <td>5</td>
                        <td>15/06/2021</td>
                        <td>
                          <div class="btn-group">
                            <button  class="btn btn-ligth btn-xs" style = "background-color: #898989;" type="button" title="" data-bs-original-title tittle>
                              <svg class="align-middle" width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M13.125 10C13.125 10.8288 12.7958 11.6237 12.2097 12.2097C11.6237 12.7958 10.8288 13.125 10 13.125C9.1712 13.125 8.37634 12.7958 7.79029 12.2097C7.20424 11.6237 6.875 10.8288 6.875 10C6.875 9.1712 7.20424 8.37634 7.79029 7.79029C8.37634 7.20424 9.1712 6.875 10 6.875C10.8288 6.875 11.6237 7.20424 12.2097 7.79029C12.7958 8.37634 13.125 9.1712 13.125 10Z" fill="white"/>
                                <path fill-rule="evenodd" clip-rule="evenodd" d="M0 10C0 10 3.75 3.125 10 3.125C16.25 3.125 20 10 20 10C20 10 16.25 16.875 10 16.875C3.75 16.875 0 10 0 10ZM10 14.375C11.1603 14.375 12.2731 13.9141 13.0936 13.0936C13.9141 12.2731 14.375 11.1603 14.375 10C14.375 8.83968 13.9141 7.72688 13.0936 6.90641C12.2731 6.08594 11.1603 5.625 10 5.625C8.83968 5.625 7.72688 6.08594 6.90641 6.90641C6.08594 7.72688 5.625 8.83968 5.625 10C5.625 11.1603 6.08594 12.2731 6.90641 13.0936C7.72688 13.9141 8.83968 14.375 10 14.375Z" fill="white"/>
                              </svg>
                            </button>
                          </div>
                        </td>
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
    import VueNumberInput from '@chenfengyuan/vue-number-input';
    import Dropdown from 'vue-simple-search-dropdown';
    export default {
      components: {
        VueNumberInput,
        Dropdown
      },      
    data() {
        return {
            options: [
                { name: "Cat", id: "cat" },
                { name: "Dog", id: "dog" },
                { name: "Elephant", id: "elephant" },
                { name: "Girafe", id: "girafe" },
                { name: "Snake", id: "snake" },
                { name: "Spider", id: "spider" },
                { name: "Unicorn", id: "unicorn" }
            ],
            selected: { name: null, id: null },

            modal_title:'',
            btn_update_active:0,
            tweaks: [],
            tweak:{
                warehouse_id: '',
                document: '',
                note: '',
                list: [{
                  product_id: '',
                  qty: 1,
                  action: 1,
                }],
            },
            product: '',
            warehouses: [],
        }
    },

    created(){
        this.loadWarehouse()
        this.tweak.list = []
    },
    methods:{

        loadWarehouse:function() {
            axios.get('/api/warehouse/load').then(res=>{
            this.warehouses = res.data;
            console.log(this.warehouses)
            })
        },

        // Métodos de mantenimiento
        createcategorie:function(){
            axios.post('/api/categorie/add',this.categorie).then(res=>{
              $('#exampleModal').modal('hide')
              this.loadcategorie()
            })
        },
        
        editCategorieData:function(item) {
            this.categorie = item
        },
        editCategorie:function() {
            axios.put('/api/categorie/edit',this.categorie).then(res=>{
                $('#exampleModal').modal('hide')
                this.loadcategorie()
                this.categorie=[]
            })
        },
        deleteCategorie:function(item) {
            this.categorie = item
            axios.post('/api/categorie/delete',this.categorie).then(res=>{
                this.loadcategorie()
            })
        },
        clearFields() {
          this.tweak.warehouse = "",
          this.tweak.file = "",
          this.tweak.note = "",
          this.tweak.list=[]
        },

        // Métodos de tabla
        deleteRow(index) {
            this.tweak.list.splice(index, 1);
            //this.calculateTotal();
        },
        addNewRow() {
            this.tweak.list.push({ 
              product_id: this.product,
              qty: '',
              action: '' 
            });
            this.product = ""
        }                      
    }
    }
</script>
s
