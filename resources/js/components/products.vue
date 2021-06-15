<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header d-flex flex-row-reverse">
            <button
              class="btn btn-primary"
              type="button"
              data-bs-toggle="modal"
              data-original-title="test"
              data-bs-target="#exampleModal"
              data-bs-original-title=""
              title=""
            >
              Nuevo Producto
            </button>

          <!-- INICIO MODAL - REGISTRAR PRODUCTO -->
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
                  <h5 v-if="btn_update_active == 0" class="modal-title" id="exampleModalLabel">
                    Nuevo Producto
                  </h5>
                  <h5 v-if="btn_update_active == 1" class="modal-title" id="exampleModalLabel">
                    Editar Producto
                  </h5>
                  <button
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
                          <label class="form-label" for="validationDefault01"
                          >Nombre de Producto</label
                          >
                          <input
                            class="form-control"
                            id="validationDefault01"
                            type="text"
                            v-model="product.name"
                            placeholder="Nombre de Producto"
                          />
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault02"
                            >Código</label
                          >
                          <input
                            class="form-control"
                            id="validationDefault02"
                            type="text"
                            v-model="product.code"
                            placeholder=""
                            required=""
                          />
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Tipo</label>
                          <select
                            class="form-select"
                            
                            v-model="product.type"                    
                            required = ""
                          >
                            <option selected="" disabled="" value="">Seleccione tipo</option>
                            <option value = "Estándar">Estándar</option>
                            <option value = "Kit">Kit</option>
                          </select>                          
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for=""
                            >Categoría</label
                          >
                          <select
                            class="form-select"
                            
                            v-model="product.categorie_id"
                            required=""
                          >
                            <option selected="" disabled="" value="">
                              Seleccione categoría
                            </option>
                            <option v-for="item in categories" :key="item.id" :value="item.id">{{ item.name }}</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Marca</label>
                          <select
                            class="form-select"
                            
                            v-model="product.brand_id"
                            required=""
                          >
                            <option selected="" disabled="" value="">
                              Seleccione marca
                            </option>
                            <option v-for="item in brands" :key="item.id" :value="item.id">{{ item.title}}</option>
                          </select>                          
                        </div>                      
                      </div>                      
                    </div>

                    <div class="row">
                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Unidad de Medida</label>
                          <select
                            class="form-select"
                            
                            v-model="product.unit_id"
                            required=""
                          >
                            <option selected="" disabled="" value="">Seleccione unidad</option>
                            <option v-for="item in units" :key="item.id" :value="item.id">{{ item.unit_name }}</option>
                          </select>
                        </div>
                      </div> 

                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Unidad de Compra</label>
                          <select
                            class="form-select"
                            
                            v-model="product.purchase_unit_id"
                            required=""
                          >
                            <option selected="" disabled="" value="">
                              Seleccione unidad
                            </option>
                            <option v-for="item in units" :key="item.id" :value="item.id">{{ item.unit_name }}</option>
                          </select>
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Unidad de Venta</label>
                          <select
                            class="form-select"
                            
                            v-model="product.sale_unit_id"
                            required=""
                          >
                            <option selected="" disabled="" value="">
                              Seleccione unidad
                            </option>
                            <option v-for="item in units" :key="item.id" :value="item.id">{{ item.unit_name }}</option>
                          </select>                          
                        </div>
                      </div>                        
                    </div>   

                    <div class="row">
                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault03">Costo</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input class="form-control" type="number" v-model="product.cost" placeholder="00.00">
                          </div>
                        </div>
                      </div>  
                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault03">Precio</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input class="form-control" type="number" v-model="product.price" laceholder="00.00">
                          </div>
                        </div>
                      </div>  
                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault03"
                            >Stock Mínimo</label
                          >
                          <input
                            class="form-control"
                            id="validationDefault03"
                            type="number"
                            v-model="product.alert_quantity"
                            placeholder="Stock Mínimo"
                            required=""
                          />                          
                        </div>
                      </div>  
                    </div>               

                    <div class="row">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="">Método de Impuesto</label>
                          <select
                            class="form-select"
                            
                            v-model="product.tax_method"
                            required=""
                          >
                            <option selected="" disabled="" value="">Seleccione un método</option>
                            <option value = "1">Incluye</option>
                            <option value = "2">No incluye</option>
                          </select>                          
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                        <label class="form-label" for="">Tipo de Impuesto</label>
                        <select
                          class="form-select"
                          
                          v-model="product.tax_id"
                          required=""
                        >
                          <option selected="" disabled="" value="">
                            Seleccione impuesto
                          </option>
                          <option v-for="item in taxes" :key="item.id" :value="item.id" >{{ item.name }}</option>
                        </select>
                        </div>
                      </div>  
                    </div>
                    <!-- FALTA! -->
                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault03"
                            >Imagen</label
                          >
                          <input class="form-control" type="file" title=""> 
                        </div>                    
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label for="exampleFormControlTextarea4">Descripción</label>
                          <textarea class="form-control" id="exampleFormControlTextarea4" v-model="product.description" rows="3"></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <!-- <label class="form-label" for="validationDefault03">¿Establecer como producto destacado?</label> -->

                          <div class="form-check checkbox checkbox-primary mb-0">
                            <input class="form-check-input" id="feature" type="checkbox" v-model="product.feature" value="1">
                            <label class="form-check-label" for="feature"> Establecer como producto destacado </label>
                          </div>         

                          <!-- <div class="m-checkbox-inline custom-radio-ml">
                            <div class="form-check form-check-inline radio radio-primary">
                              <input class="form-check-input" id="radioinline1" type="radio" name="radio1" value="1" >
                              <label class="form-check-label mb-0" for="radioinline1">Sí</label>
                            </div>
                            <div class="form-check form-check-inline radio radio-primary">
                              <input class="form-check-input" id="radioinline2" type="radio" name="radio1" value="0" >
                              <label class="form-check-label mb-0" for="radioinline2">No</label>
                            </div>
                          </div> -->
                        </div>                    
                      </div>
                    </div>                    

                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          
                          <!-- <label class="form-label" for="validationDefault03">¿El producto tiene variante(s)?</label> -->

                          <div class="form-check checkbox checkbox-primary mb-0">
                            <input class="form-check-input" id="variant" type="checkbox" v-model="product.is_variant" value="1">
                            <label class="form-check-label" for="variant"> El producto tiene variante(s) </label>
                          </div>                             
                                                      
                          <!-- <div class="m-checkbox-inline custom-radio-ml">
                            <div class="form-check form-check-inline radio radio-primary">
                              <input class="form-check-input" id="radioinline3" type="radio" v-model="products.is_variant" :value="1" >
                              <label class="form-check-label mb-0" for="radioinline3">Sí</label>
                            </div>
                            <div class="form-check form-check-inline radio radio-primary">
                              <input class="form-check-input" id="radioinline4" type="radio" v-model="products.is_variant" :value="0" >
                              <label class="form-check-label mb-0" for="radioinline4">No</label>
                            </div>
                          </div> -->
                        </div>                    
                      </div>
                    </div>

                    <div v-if="product.is_variant == 1">
                      <div class="row align-items-end" v-for="(variant,k) in product.variant" :key="k"> 
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label" for="validationDefault01">Nombre</label>
                            <input
                              class="form-control"
                              id="validationDefault01"
                              type="text"
                              v-model="variant.name"
                              placeholder=""
                            />
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label" for="validationDefault01">Precio</label>
                            <div class="input-group">
                              <span class="input-group-text">$</span>
                              <input class="form-control" type="number" v-model="variant.additional_price" placeholder="00.00">
                            </div>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label" for="validationDefault01">Cantidad</label>
                            <input
                              class="form-control"
                              id="validationDefault01"
                              v-model="variant.qty"
                              type="number"
                              placeholder=""
                            />
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <span>
                                <button class="btn btn-primary" @click="remove(k)" v-show="k || ( !k && product.variant.length > 1)">-</button>
                                <button class="btn btn-primary" @click="add(k)" v-show="k == product.variant.length-1">+</button>
                            </span>                            
                          </div>
                        </div>

                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <div class="form-check checkbox checkbox-primary mb-0">
                            <input class="form-check-input" id="warehouse" type="checkbox" v-model="product.is_warehouse" value="1">
                            <label class="form-check-label" for="warehouse"> Agregar producto al almacen virtual </label>
                          </div>                                                           
                        </div>                    
                      </div>
                    </div>

                    <!-- <div v-if="product.is_warehouse == 1">
                      <div class="row align-items-end" v-for="(warehouse,k) in product.warehouse" :key="k"> 

                        <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label" for="validationDefault01">Precio</label>
                            <div class="input-group">
                              <span class="input-group-text">$</span>
                              <input class="form-control" type="number" v-model="warehouse.price" placeholder="00.00">
                            </div>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label" for="validationDefault01">Cantidad</label>
                            <input
                              class="form-control"
                              id="validationDefault01"
                              v-model="warehouse.qty"
                              type="number"
                              placeholder=""
                            />
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <span>
                                <button class="btn btn-primary" @click="remove2(k)" v-show="k || ( !k && product.warehouse.length > 1)">-</button>
                                <button class="btn btn-primary" @click="add2(k)" v-show="k == product.warehouse.length-1">+</button>
                            </span>                            
                          </div>
                        </div>

                      </div>
                    </div> -->
                    
                    <div v-if="product.is_warehouse == 1">
                      <div class="row"> 

                        <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label" for="validationDefault01">Precio</label>
                            <div class="input-group">
                              <span class="input-group-text">$</span>
                              <input class="form-control" type="number" v-model="product.warehouse.price" placeholder="00.00">
                            </div>
                          </div>
                        </div>

                        <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label" for="validationDefault01">Cantidad</label>
                            <input
                              class="form-control"
                              id="validationDefault01"
                              v-model="product.warehouse.qty"
                              type="number"
                              placeholder=""
                            />
                          </div>
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
          <!-- FIN MODAL - REGISTRAR PRODUCTO -->            
          </div>

          <div class="table-responsive">
            <table class="table table-sm">
              <thead>
                <tr>
                  <th scope="col">#</th>
                  <th scope="col">Nombre</th>
                  <th scope="col">Código</th>
                  <th scope="col">Tipo</th>
                  <th scope="col">Categoria</th>
                  <th scope="col">Estado</th>
                  <th scope="col">Acciones</th>
                </tr>
              </thead>
              <tbody>
                <tr>
                  <th scope="row">1</th>
                  <td>Nombre</td>
                  <td>Código</td>
                  <td>Tipo</td>
                  <td>Categoria</td>
                  <td>
                    <div class="form-check form-switch">
                    <input class="form-check-input" id="flexSwitchCheckChecked" type="checkbox" data-onstyle="secondary" checked="" data-bs-original-title="" title="">
                    </div>
                  </td>
                  <td>
                    <button class="btn btn-danger btn-xs" type="button">
                      <i data-feather="eye"></i>P
                    </button>
                    <button class="btn btn-success btn-xs" type="button">
                      Edit
                    </button>
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
export default {
  data() {
    return {
      btn_update_active: 0,
      products: [],
      product: {
        name: "",
        code: "",
        type: "",
        categorie_id: "",
        brand_id: "",
        unit_id: "",
        purchase_unit_id: "",
        sale_unit_id: "",
        cost: "",
        price: "",
        alert_quantity: "",
        tax_method: "",
        tax_id: "",
        description: "",
        feature: [],
        is_variant: [],
        variant: [{
          name: '',
          additional_price: '',
          qty: ''
        }],
        is_warehouse: [],
        warehouse: [{
          price: '',
          qty: '',
        }]
      },
      categories: [],
      brands: [],
      units: [],
      taxes: []
    }
  },

  created(){
    this.loadProducts()
    this.loadCategories()
    this.loadBrands()
    this.loadUnits()
    this.loadTaxes()
  },

  methods: {
    //Métodos de carga de data
    loadProducts:function() {
      axios.get('/api/product/load').then(res=>{
      this.products = res.data;
      console.log(this.products)
      })      
    },
    loadCategories:function() {
      axios.get('/api/categorie/load').then(res=>{
      this.categories = res.data;
      console.log(this.categories)
      })      
    },
    loadBrands:function() {
      axios.get('/api/brand/load').then(res=>{
      this.brands = res.data;
      console.log(this.brands)
      })      
    },
    loadUnits:function() {
      axios.get('/api/unit/load').then(res=>{
      this.units = res.data;
      console.log(this.units)
      })      
    },
    loadTaxes:function() {
      axios.get('/api/tax/load').then(res=>{
      this.taxes = res.data;
      console.log(this.taxes)
      })      
    },

    //Métodos de mantenimiento
    createProduct:function(){
        axios.post('/api/product/add',this.product).then(res=>{
            this.loadProducts()
        })
    },
    deleteProduct:function(item) {
        this.product = item
        axios.post('/api/product/delete',this.product).then(res=>{
            this.loadProducts()
        })
    },
    editProductData:function(item) {
        this.product = item
        this.btn_update_active=1
    },
    editProduct:function() {
        axios.put('/api/product/edit',this.product).then(res=>{
            this.loadProducts()
            this.btn_update_active=0
            this.product=[]
        })
    },    

    //Métodos de agregar y quitar variantes
    add(index) {
        this.product.variant.push({ addicional_price: '', qty: '' });
    },
    remove(index) {
        this.product.variant.splice(index, 1);
    },
    // add2(index) {
    //     this.product.warehouse.push({ price: '', qty: '' });
    // },
    // remove2(index) {
    //     this.product.warehouse.splice(index, 1);
    // }
  }
};
</script>
