<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header" style="padding: 20px 40px !important;">

            <div class="row">
              <div class="col-md-4 col-sm-12">
                <label for="">Buscar por:</label>
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="17" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>                    
                  </span></div>
                  <input class="form-control" type="text" v-model="buscador" @keyup="buscarProducto" placeholder="Nombre o código...">
                </div>
              </div>

              <div class="col-md-3 col-sm-6">
                <label for="">Categoría:</label>
                <select
                  class="form-control form-control-sm"
                  v-model="buscadorC"
                  @change="buscarProducto"
                >
                  <option selected="" disabled="" value="">
                    Seleccionar
                  </option>
                  <option :value="todos">Todos</option>
                  <option v-for="item in categories" :key="item.id" :value="item.id">{{ item.name }}</option>
                </select>
              </div>

              <div class="col-md-2 col-sm-6">
                <label for="">Marca:</label>
                <select
                  class="form-control form-control-sm"
                  v-model="buscadorB"
                  @change="buscarProducto"
                >
                  <option selected="" disabled="" value="">
                    Seleccionar
                  </option>
                  <option :value="todos">Todos</option>
                  <option v-for="item in brands" :key="item.id" :value="item.id">{{ item.title}}</option>
                </select> 
              </div>
              
              <div class="col-md-3 col-sm-12 align-self-end text-end">
                <button
                  @click="btn_update_active=0, loadWarehouse(), clearFields()"
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
              </div>
            </div>

          </div>

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
                  <form v-on:submit.prevent>
                    <div class="row">
                      <p><i>Los campos con (*) son obligatorios...</i></p>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault01"
                          >Nombre de Producto(*)</label
                          >
                          <input
                            class="form-control"
                            id="validationDefault01"
                            type="text"
                            required
                            v-model="product.name"
                            placeholder="Nombre de Producto"
                            @blur="$v.product.name.$touch()"
                          />
                          <template v-if="$v.product.name.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.product.name.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                            
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
                          <label class="form-label" for="">Tipo(*)</label>
                          <select
                            class="form-select"
                            v-model="product.type"
                            @blur="$v.product.type.$touch()"                    
                          >
                            <option selected="" disabled="" value="">Seleccione tipo</option>
                            <option value = "Estándar">Estándar</option>
                            <option value = "Kit">Kit</option>
                          </select>
                          <template v-if="$v.product.type.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.product.type.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                                                        
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for=""
                            >Categoría(*)</label
                          >
                          <select
                            class="form-select"
                            v-model="product.categorie_id"
                            @blur="$v.product.categorie_id.$touch()"
                          >
                            <option selected="" disabled="" value="">
                              Seleccione categoría
                            </option>
                            <option v-for="item in categories" :key="item.id" :value="item.id">{{ item.name }}</option>
                          </select>
                          <template v-if="$v.product.categorie_id.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.product.categorie_id.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                           
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Marca(*)</label>
                          <select
                            class="form-select"
                            v-model="product.brand_id"
                            @blur="$v.product.brand_id.$touch()"
                          >
                            <option selected="" disabled="" value="">
                              Seleccione marca
                            </option>
                            <option v-for="item in brands" :key="item.id" :value="item.id">{{ item.title}}</option>
                          </select> 
                          <template v-if="$v.product.brand_id.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.product.brand_id.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                                                     
                        </div>                      
                      </div>                      
                    </div>

                    <div class="row">
                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Unidad de Medida(*)</label>
                          <select
                            class="form-select"
                            v-model="product.unit_id"
                            @blur="$v.product.unit_id.$touch()"
                          >
                            <option selected="" disabled="" value="">Seleccione unidad</option>
                            <option v-for="item in units" :key="item.id" :value="item.id">{{ item.unit_name }}</option>
                          </select>
                          <template v-if="$v.product.unit_id.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.product.unit_id.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                           
                        </div>
                      </div> 

                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Unidad de Compra(*)</label>
                          <select
                            class="form-select"
                            v-model="product.purchase_unit_id"
                            @blur="$v.product.purchase_unit_id.$touch()"
                          >
                            <option selected="" disabled="" value="">
                              Seleccione unidad
                            </option>
                            <option v-for="item in units" :key="item.id" :value="item.id">{{ item.unit_name }}</option>
                          </select>
                          <template v-if="$v.product.purchase_unit_id.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.product.purchase_unit_id.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                           
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Unidad de Venta(*)</label>
                          <select
                            class="form-select"
                            v-model="product.sale_unit_id"
                            @blur="$v.product.sale_unit_id.$touch()"
                          >
                            <option selected="" disabled="" value="">
                              Seleccione unidad
                            </option>
                            <option v-for="item in units" :key="item.id" :value="item.id">{{ item.unit_name }}</option>
                          </select>                          
                          <template v-if="$v.product.sale_unit_id.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.product.sale_unit_id.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                          
                        </div>
                      </div>                        
                    </div>   

                    <div class="row">
                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault03">Costo(*)</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input class="form-control" type="number" v-model="product.cost" @blur="$v.product.cost.$touch()" placeholder="00.00" min="0">
                          </div>
                          <template v-if="$v.product.cost.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.product.cost.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                             
                        </div>
                      </div>  
                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault03">Precio(*)</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input class="form-control" type="number" v-model="product.price" @blur="$v.product.price.$touch()" placeholder="00.00" min="0">
                          </div>
                          <template v-if="$v.product.price.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.product.price.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                             
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
                          <label class="form-label" for="">Método de Impuesto(*)</label>
                          <select
                            class="form-select"
                            
                            v-model="product.tax_method"
                            required=""
                          >
                            <option selected="" disabled="" value="">Seleccione un método</option>
                            <!-- <option value = "1">No aplica</option> -->
                            <option value = "2">Incluye</option>
                            <option value = "3">No incluye</option>
                          </select>                          
                        </div>
                      </div>
                      <div class="col-md-6">
                        <div class="mb-3">
                        <label class="form-label" for="">Tipo de Impuesto(*)</label>
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
                          <!-- <input class="form-control" type="file" title="">  -->
                          <UploadImages @change="handleImages" clearAll="Limpiar todo" uploadMsg="Haga clic para subir o soltar sus imágenes aquí"/>
                          <div class="table-responsive" v-if="product.image">
                    <table class="table">
                      <thead>
                        <tr>
                                      <th>Imagen</th>
                                      <th>Eliminar</th>
                                  </tr>
                      </thead>
                      <tbody>
                        
                        <tr v-for="(item, index) in imagesUrl" :key="item.id">
                            <td>
                              <img :src="'images/product/'+item" height="60" width="60">
                              <!-- <input type="hidden" v-model="imagesUrl" :value="index"> -->
                            </td>
                            <td><a><button type="button" title="" @click="removeImage(index)" class="btn btn-secondary btn-xs"><svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2"><polyline points="3 6 5 6 21 6"></polyline><path d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path><line x1="10" y1="11" x2="10" y2="17"></line><line x1="14" y1="11" x2="14" y2="17"></line></svg></button></a></td>
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
                          <label for="exampleFormControlTextarea4">Descripción</label>
                          <textarea class="form-control" id="exampleFormControlTextarea4" v-model="product.product_details" rows="3"></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <!-- <label class="form-label" for="validationDefault03">¿Establecer como producto destacado?</label> -->

                          <!-- <div class="form-check checkbox checkbox-primary mb-0">
                            <input class="form-check-input" id="featured" type="checkbox" v-model="product.featured" value="1">
                            <label class="form-check-label" for="featured"> Establecer como producto destacado </label>
                          </div>   -->       

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
                      <div class="row align-items-end" v-for="(product_variant,k) in product.product_variant" :key="k"> 
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label" for="validationDefault01">Nombre</label>
                            <input
                              class="form-control"
                              id="validationDefault01"
                              type="text"
                              v-model="product_variant.name"
                              placeholder=""
                            />
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label" for="validationDefault01">Costo adicional</label>
                            <div class="input-group">
                              <span class="input-group-text">$</span>
                              <input class="form-control" type="number" v-model="product_variant.additional_cost" placeholder="00.00">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <label class="form-label" for="validationDefault01">Precio adicional</label>
                            <div class="input-group">
                              <span class="input-group-text">$</span>
                              <input class="form-control" type="number" v-model="product_variant.additional_price" placeholder="00.00">
                            </div>
                          </div>
                        </div>
                        <div class="col-md-3">
                          <div class="mb-3">
                            <span>
                                <button class="btn btn-primary" @click="remove(k)" v-show="k || ( !k && product.product_variant.length > 1)">-</button>
                                <button class="btn btn-primary" @click="add(k)" v-show="k == product.product_variant.length-1">+</button>
                            </span>                            
                          </div>
                        </div>

                      </div>
                    </div>

                    <!-- <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <div class="form-check checkbox checkbox-primary mb-0">
                            <input class="form-check-input" id="warehouse" type="checkbox" v-model="product.is_diffPrice" value="1">
                            <label class="form-check-label" for="warehouse"> Este producto tiene un precio diferente para diferentes almacenes. </label>
                          </div>                                                           
                        </div>                    
                      </div>
                    </div> -->

                    <!-- <div v-if="product.is_diffPrice == 1">
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
                    <!-- <div v-if="btn_update_active == 0 && product.is_diffPrice==1">
                      <div class="row"> 
                        
                        <div class="col-md-6">
                          <div class="mb-6" v-for="item in product.warehouse" :key="item.id">
                            <div class="input-group">
                              <span class="input-group-text">{{item.name}}</span>
                              <input class="form-control" v-model="item.price" type="number"  placeholder="00.00">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> -->
                    <div v-if="btn_update_active == 1 && product.is_diffPrice==1">
                      <div class="row"> 
                        
                        <div class="col-md-6">
                          <div class="mb-6" v-for="item in product.warehouse" :key="item.id">
                            <div class="input-group">
                              <span class="input-group-text">{{item.name}}</span>
                              <input class="form-control" v-model="item.pivot.price" type="number"  placeholder="00.00">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div>
                    <!-- <div v-if="btn_update_active == 1">
                      <div class="row"> 
                        
                        <div class="col-md-6">
                          <div class="mb-6" v-for="item in product.product_warehouse" :key="item.id">
                            <div class="input-group">
                              <span class="input-group-text">{{item.name}}</span>
                              <input class="form-control" v-model="item.pivot" type="number"  placeholder="00.00">
                            </div>
                          </div>
                        </div>
                      </div>
                    </div> -->

                  </form>
                </div>

                <div class="modal-footer">
                  <button
                    v-if="btn_update_active == 0"
                    @click="createProduct()"
                    class="btn btn-primary"
                    type="submit"
                    data-bs-original-title=""
                    title=""
                    :disabled="$v.$invalid"
                  >
                    Guardar
                  </button>
                  <button
                    @click="editProduct()"
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

          <div class="card-body" style="padding: 20px 40px !important">
            <div class="table-responsive style-1 table-hover non-hover">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col"></th>
                    <th scope="col">Nombre</th>
                    <th scope="col">Código</th>
                    <th scope="col">Categoría</th>
                    <th scope="col">Marca</th>
                    <th scope="col">Cantidad</th>
                    <th scope="col">Unidad</th>
                    <th scope="col">Costo</th>
                    <th scope="col">Precio</th>
                    <!-- <th scope="col"></th> -->
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>

                  <tr style="vertical-align: middle;" v-for="item in products.data" :key="item.id">
                    <th scope="row" ><img :src="'images/product/'+item.image.split(',')[0]" width="50"></th>
                    <td>{{item.name}}</td>
                    <td>{{item.code}}</td>
                    <td>{{item.categorie.name}}</td>
                    <td>{{item.brand.title}}</td>
                    <td>{{item.qty}}</td>
                    <td>{{item.unit.unit_name}}</td>
                    <td>{{item.cost}}</td>
                    <td>{{item.price}}</td>
                    <!-- <td>
                      <div class="form-check form-switch">
                      <input class="form-check-input" id="flexSwitchCheckChecked" type="checkbox" data-onstyle="secondary" checked="" data-bs-original-title="" title="">
                      </div>
                    </td> -->
                    <td>
                      <div class="btn-group">
                        <button @click="editProductData(item)" data-bs-toggle="modal" data-bs-target="#exampleModal" data-bs-original-title="" type="button" title="" class="btn btn-primary btn-xs">
                            <svg class="align-middle" width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                              <g clip-path="url(#clip0)">
                                  <path fill-rule="evenodd" clip-rule="evenodd" d="M16.0721 0.175179C15.9549 0.0580096 15.796 -0.0078125 15.6302 -0.0078125C15.4645 -0.0078125 15.3056 0.0580096 15.1884 0.175179L13.1296 2.23393L17.7634 6.86768L19.8221 4.81018C19.8803 4.75212 19.9265 4.68315 19.958 4.60722C19.9895 4.53129 20.0057 4.44989 20.0057 4.36768C20.0057 4.28547 19.9895 4.20407 19.958 4.12814C19.9265 4.05221 19.8803 3.98324 19.8221 3.92518L16.0721 0.175179ZM16.8796 7.75143L12.2459 3.11768L4.12086 11.2427H4.37961C4.54537 11.2427 4.70435 11.3085 4.82156 11.4257C4.93877 11.5429 5.00461 11.7019 5.00461 11.8677V12.4927H5.62961C5.79537 12.4927 5.95435 12.5585 6.07156 12.6757C6.18877 12.7929 6.25461 12.9519 6.25461 13.1177V13.7427H6.87962C7.04538 13.7427 7.20435 13.8085 7.32156 13.9257C7.43877 14.0429 7.50462 14.2019 7.50462 14.3677V14.9927H8.12962C8.29538 14.9927 8.45435 15.0585 8.57156 15.1757C8.68877 15.2929 8.75462 15.4519 8.75462 15.6177V15.8764L16.8796 7.75143ZM7.54462 17.0864C7.51831 17.0165 7.50477 16.9424 7.50462 16.8677V16.2427H6.87962C6.71386 16.2427 6.55488 16.1768 6.43767 16.0596C6.32046 15.9424 6.25461 15.7834 6.25461 15.6177V14.9927H5.62961C5.46385 14.9927 5.30488 14.9268 5.18767 14.8096C5.07046 14.6924 5.00461 14.5334 5.00461 14.3677V13.7427H4.37961C4.21385 13.7427 4.05488 13.6768 3.93767 13.5596C3.82046 13.4424 3.75461 13.2834 3.75461 13.1177V12.4927H3.12961C3.05489 12.4926 2.98079 12.479 2.91086 12.4527L2.68711 12.6752C2.62755 12.7352 2.58077 12.8066 2.54961 12.8852L0.0496099 19.1352C0.00414655 19.2488 -0.00698284 19.3732 0.0176015 19.493C0.0421858 19.6129 0.101403 19.7229 0.187911 19.8094C0.274419 19.8959 0.384414 19.9551 0.50426 19.9797C0.624105 20.0043 0.748531 19.9931 0.862111 19.9477L7.11212 17.4477C7.19069 17.4165 7.26213 17.3697 7.32212 17.3102L7.54462 17.0877V17.0864Z" fill="white"></path>
                              </g>
                              <defs>
                                  <clipPath id="clip0">
                                    <rect width="20" height="20" fill="white"></rect>
                                  </clipPath>
                              </defs>
                            </svg>
                        </button>
                        <button type="button" @click="deleteProduct(item)" title="" class="btn btn-secondary btn-xs">
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
            <br>

            <div class="row mt-4 align-items-center">
              <div class="col-md-6">
                  <p class="card-text">Mostrando de {{(products.from)}} a {{(products.to)}} de {{products.total}} categorías.</p>
              </div>             
              <div class="col-md-6">
                <nav>
                  <ul class="pagination justify-content-end pagination-primary">
                      <li   :class="(products.current_page==1)?'page-item disabled':'page-item'" ><a @click.prevent="loadProducts(products.current_page-1)" href="" tabindex="-1" data-bs-original-title="" title="" class="page-link">Anterior</a></li>
                      <li v-if="products.current_page>1" class="page-item"><a @click.prevent="loadProducts(products.current_page-1)" href="" data-bs-original-title="" title="" class="page-link">{{products.current_page-1}}</a></li>
                      <li class="page-item active">
                          <a href="#" data-bs-original-title="" title="" class="page-link">{{products.current_page}}<span class="sr-only">(current)</span></a>
                      </li>
                      <li v-if="products.current_page!=products.last_page" class="page-item"><a @click.prevent="loadProducts(products.current_page+1)" href="" data-bs-original-title="" title="" class="page-link">{{products.current_page+1}}</a></li>
                      <li :class="(products.current_page==products.last_page)?'page-item disabled':'page-item'"><a @click.prevent="loadProducts(products.current_page+1)"  href="" data-bs-original-title="" title="" class="page-link">Siguiente</a></li>
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
import UploadImages from "vue-upload-drop-images"
import { required } from 'vuelidate/lib/validators'
export default {
  components: {
      UploadImages,
  },
                 
  data() {
    return {
      page:1,
      buscador: "",
      buscadorC: "",
      buscadorB: "",
      setTimeoutBuscador: '',
      btn_update_active: 0,
      products: [],
      product: {
        name: null,
        code: null,
        type: null,
        categorie_id: null,
        brand_id: null,
        unit_id: null,
        purchase_unit_id: null,
        sale_unit_id: null,
        cost: null,
        price: null,
        alert_quantity: null,
        tax_method: null,
        tax_id: null,
        product_details: null,
        featured: false,
        is_variant: false,
        product_variant: [{
          name: null,
          additional_cost: 0,
          additional_price: 0,
        }],
        is_diffPrice: false,
        warehouse: []
      },
      categories: [],
      brands: [],
      units: [],
      taxes: [],
      imagesUrl:[]
    }
    
  },

  created(){
    this.loadProducts(this.page)
    this.loadCategories()
    this.loadBrands()
    this.loadUnits()
    this.loadTaxes()
  },

  methods: {
    //Métodos de carga de data
    loadProducts:function(page) {
      this.page = page
      axios.get('/api/product/load?page='+this.page,{
        params:{
          buscador: this.buscador,
          buscadorC: this.buscadorC,
          buscadorB: this.buscadorB,
        }
      }).then(res=>{
      this.products = res.data;
      })      
    },
    loadCategories:function() {
      axios.get('/api/categorie/index').then(res=>{
      this.categories = res.data;
      })      
    },
    loadBrands:function() {
      axios.get('/api/brand/index').then(res=>{
      this.brands = res.data;
      })      
    },
    loadUnits:function() {
      axios.get('/api/unit/load').then(res=>{
      this.units = res.data;
      })      
    },
    loadTaxes:function() {
      axios.get('/api/taxe/load').then(res=>{
      this.taxes = res.data;
      })      
    },
    loadWarehouse:function() {
      axios.get('/api/warehouse/load').then(res=>{
        this.product.warehouse = res.data;
        this.product.warehouse.pivot=10
        console.log(this.product.warehouse)
      })
    },

    //Métodos de mantenimiento
    createProduct:function(){
      const blob = JSON.stringify(this.product);
      let formData = new FormData();
      if (this.file) {
          this.file.forEach(function (img, i) {
          formData.append('file['+i+']', img);
        });
      }
      formData.append("document", blob);

      axios.post( '/api/product/add',formData).then(res=>{
        Swal.fire({
          title: 'Registro Exitoso!',
          text: "Se registró producto correctamente.",
          icon: 'success',
          confirmButtonColor: '#98B631',
          confirmButtonText: 'De acuerdo'
        })
        this.file=[]
        this.clearFields()
        $('#exampleModal').modal('hide')         
        this.loadProducts(this.page)                   
      })
    },

    deleteProduct:function(item) {
      this.product = item
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
          axios.post('/api/product/delete',this.product).then(res=>{
            Swal.fire({
              title: 'Eliminado!',
              text: "Se ha eliminado el producto.",
              icon: 'success',
              confirmButtonColor: '#98B631',
              confirmButtonText: 'De acuerdo'
            })
            this.loadProducts(this.page)
          })
        }
      })
    },

    editProductData:function(item) {
        this.product = item
        this.imagesUrl=item.image.split(',')
        this.btn_update_active=1
        if (this.product.is_variant==false) {
          this.product.product_variant= [{
          name: null,
          additional_price: 0,
          additional_cost: 0,
          }];
        }
        if (this.product.is_diffPrice==false) {
          this.product.product_warehouse= [{
          price: 0,
          }]
        }
        
    },

    editProduct:function() {
      const blob = JSON.stringify(this.product);
      let formData = new FormData();
      if (this.file) {
          this.file.forEach(function (img, i) {
          formData.append('file['+i+']', img);
        });
      }
      formData.append("document", blob);

      axios.post( '/api/product/edit',formData).then(res=>{
        Swal.fire({
          title: 'Actualización Exitosa!',
          text: "Se actualizó producto correctamente.",
          icon: 'success',
          confirmButtonColor: '#98B631',
          confirmButtonText: 'De acuerdo'
        })
        $('#exampleModal').modal('hide')
        this.clearFields()
        this.loadProducts(this.page)                
      })   
    },

    //Métodos de agregar y quitar variantes
    add(index) {
        this.product.product_variant.push({ additional_price: '' });
    },
    remove(index) {
        this.product.product_variant.splice(index, 1);
    },

    //metodos para subir imagenes
    handleImages(files){
        /* console.log(files) */
        this.file = files;
    },
    //metodos para editar imagenes
    removeImage:function(index){
      this.imagesUrl.splice(index,1);
      this.product.image = this.imagesUrl.join()
    },

    clearFields:function(){
      this.product= {
        name: null,
        code: null,
        type: null,
        categorie_id: null,
        brand_id: null,
        unit_id: null,
        purchase_unit_id: null,
        sale_unit_id: null,
        cost: null,
        price: null,
        alert_quantity: null,
        tax_method: null,
        tax_id: null,
        product_details: null,
        featured: false,
        is_variant: false,
        product_variant: [{
          name: null,
          additional_price: 0,
        }],
        is_diffPrice: false,
        warehouse: [],
        imagesUrl:[]
      }
      this.$v.$reset()
    },

    buscarProducto(){
      clearTimeout(this.setTimeoutBuscador)
      this.setTimeoutBuscador = setTimeout(this.loadProducts, 360)
    },    

  },

  validations: {
    product: {
      name: {
        required
      },
      type: {
        required
      },
      categorie_id: {
        required
      },
      brand_id: {
        required
      },
      unit_id: {
        required
      },
      purchase_unit_id: {
        required
      },
      sale_unit_id: {
        required
      },
      cost: {
        required
      },
      price: {
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