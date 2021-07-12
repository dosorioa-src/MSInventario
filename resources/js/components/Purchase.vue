<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header" style="padding: 20px 40px !important">

            <div class="row mb-1">
              <div class="col-md-3 col-sm-6">
                <label for="">Buscar por:</label>
                <div class="input-group input-group-sm">
                  <div class="input-group-prepend"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="17" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>                    
                  </span></div>
                  <input class="form-control" type="text" v-model="filtroA" @keyup="buscarCompra" placeholder="N° de referencia...">
                </div>
              </div>

              <div class="col-md-3 col-sm-6">
                <label for="">Desde:</label>
                <input class="form-control digits form-control-sm" type="date" v-model="from" @change="buscarCompra" data-bs-original-title="" title="">
              </div>

              <div class="col-md-3 col-sm-6">
                <label for="">Hasta:</label>
                <input class="form-control digits form-control-sm" type="date" v-model="to" @change="buscarCompra" data-bs-original-title="" title="">
              </div>

              <div class="col-md-3 col-sm-12 align-self-end text-end">
                <button
                  @click="clearFilters(), buscarCompra()"
                  class="btn btn-light"
                  type="button"
                >
                  Limpiar
                </button>		  
              </div>              

            </div> 
            <div class="row">
              <div class="col-md-3 col-sm-6">
                <label for="">Proveedor:</label>
                <select
                  class="form-control form-control-sm"
                  v-model="filtroB"
                  @change="buscarCompra"
                >
                  <option selected="" disabled="" value="">
                    Seleccionar
                  </option>
                  <option value="Todos">Todos</option>
                  <option v-for="item in suppliers" :value="item.id" :key="item.id">{{item.company_name}}</option>
                </select>
              </div> 

              <div class="col-md-3 col-sm-6">
                <label for="">Estado de Pago:</label>
                <select
                  class="form-control form-control-sm"
                  v-model="filtroC"
                  @change="buscarCompra"
                >
                  <option selected="" disabled="" value="">
                    Seleccionar
                  </option>
                  <option value="Todos">Todos</option>
                  <option value = "1">Pendiente</option>
                  <option value = "2">Pagado</option>
                </select>
              </div>  

              <div class="col-md-6 col-sm-12 align-self-end text-end">
                <button
                  @click="modal_title='Nueva Compra'"
                  class="btn btn-primary"
                  type="button"
                  data-bs-toggle="modal"
                  data-original-title="test"
                  data-bs-target="#exampleModal"
                  data-bs-original-title=""
                  title=""
                >
                  Nueva Compra
                </button>			  
              </div>  
            </div> 

          </div>

          <!-- INICIO MODAL - REGISTRAR VENTA -->
          <div
            class="modal fade"
            id="exampleModal"
            tabindex="-1"
            aria-labelledby="exampleModalLabel"
            style="display: none"
            aria-hidden="true"
          >
            <div class="modal-dialog modal-xl" role="document">
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
                          <label class="form-label" for="">Proveedor</label>
                          <select
                            class="form-select"
                            v-model="purchase.supplier_id"
                          >	
                            <option selected="" disabled="" value="">Seleccione un proveedor</option>
                            <option v-for="item in suppliers" :value="item.id" :key="item.id">{{item.name}}</option>
                          </select>                          
                        </div>
                      </div>
                      <div class="col-md-6">
                      <div class="mb-3">
                          <label class="form-label" for="">Estado de compra</label>
                            <select
                              class="form-select"
                              v-model="purchase.status"
                              >	
                              <option value="1">Recibido</option>
                              <option value="2">Parcial</option>
                              <option value="3">Pendiente</option>
                              <option value="4">Ordenado</option>
                            </select>														
                        </div>
                        </div>
                    </div>
                    
                    <div class="row align-items-end">
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault01"
                          >Producto</label
                          >
                          <div class="dropdown">
                            <input class="form-control" type="text" id="dropdownMenuButton" v-model="searchValue" @keyup="searchProduct(searchValue)" placeholder="Escriba el titulo o código del producto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <div class="form-control dropdown-menu" aria-labelledby="dropdownMenuButton">
                              <a class="dropdown-item"  href="#" v-for="item in searchResult" :key="item.id"  data-bs-original-title="" title="" @click="addNewRow(item), searchValue='', searchResult=[]">{{item.code}} | {{item.name}}</a>
                            </div>
                          </div>
                            <!-- <input
                              class="form-control"
                              type="text"
                              v-model="product"
                              placeholder="Escriba el título o código de producto"
                            />	 -->
                        </div>
                      </div>
                      <div class="col-md-6">
                        

                        <div class="mb-3">
                          <label class="form-label" for="">Documento adjunto</label>
                          <input class="form-control" @change="handleFile" ref="file" type="file" title="">												
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
                                    <th scope="col">Producto</th>
                                    <th scope="col">Variante</th>
                                    <th scope="col">Cantidad</th>
                                    <th scope="col">Costo Unitario Neto</th>
                                    <!-- <th scope="col">Descuento</th> -->
                                    <th scope="col">Total</th>
                                    <th scope="col">Acción</th>
                                  </tr>
                                </thead>
                                <tbody v-if="btn_update_active == 1">
                                  <tr v-for="(item, index) in purchase.product_purchase" :key="item.id">
                                      <td v-if="!Array.isArray(item.product_variant)">
                                        {{item.product.name}}
                                      </td>
                                      <td v-if="Array.isArray(item.product_variant)">
                                      {{item.name}}
                                      </td>
                                      <td >
                                        <div v-if="!Array.isArray(item.product_variant) && item.product_variant!=null">
                                          {{item.product_variant.name}}
                                        </div>
                                        <select v-if="Array.isArray(item.product_variant)" v-model="item.product_variant_selected" name="" class="form-select" id="">
                                          <option v-for="item in item.product_variant" :key="item.id" :value="item">{{item.name}}</option>
                                        </select>
                                      </td>

                                      <td>
                                        <vue-number-input v-model="item.qty" :min="1" inline center controls @change="calculateLineTotal(item)"></vue-number-input>
                                      </td>
                                      
                                      <td>
                                        <div v-if="!item.product_variant_selected" >{{parseFloat(item.cost)}}</div>

                                        <div v-if="item.product_variant_selected" >{{ parseFloat(item.cost)+parseFloat(item.product_variant_selected.additional_cost)}}</div>
                                      
                                        </td>
                                      <!-- <td>
                                        <input @change="calculateLineTotal(item)" class="form-control" type="number" v-model="item.discount" placeholder="0">
                                      </td> -->
                                      <td style="vertical-align: middle;">
                                        {{ item.subtotal }}
                                      </td>
                                      <td>
                                        <div class="btn-group">
                                          <button @click="deleteRow(index)" class="btn btn-secondary" type="button">
                                            Borrar
                                          </button>
                                        </div>
                                      </td>
                                  </tr>
                                </tbody>
                                <tbody v-if="btn_update_active == 0">
                                  <tr v-for="(item, index) in purchase.product_purchase" :key="item.id">
                                      <td style="vertical-align: middle;">{{item.name}}</td>
                                      <td style="vertical-align: middle;">
                                        <select
                                        @change="calculateLineTotal(item)"
                                          class="form-select"
                                          v-model="item.product_variant_selected"
                                        >
                                        <option  v-for="variant in item.product_variant" :key="variant.id" :value="variant" >{{ variant.name }}</option> 
                                        </select>
                                      </td>

                                      <td>
                                        <vue-number-input v-model="item.qty" :min="1" inline center controls @change="calculateLineTotal(item)"></vue-number-input>
                                      </td>
                                      
                                      <td>
                                        <div v-if="item.product_variant_selected" >{{parseFloat(item.cost)+parseFloat(item.product_variant_selected.additional_cost)}}</div>
                                        <div v-if="!item.product_variant_selected" >{{item.cost}}</div>
                                        <!-- <input class="form-control" type="number" v-model="item.unit_price" @change="calculateLineTotal(item)"> -->
                                      </td>

                                      <!-- <td>
                                        <input @change="calculateLineTotal(item)" class="form-control" type="number" v-model="item.discount" placeholder="0">
                                      </td> -->
                                      <td style="vertical-align: middle;">
                                        {{ item.subtotal }}
                                      </td>
                                      <td>
                                        <div class="btn-group">
                                          <button @click="deleteRow(index)" class="btn btn-secondary" type="button">
                                            Borrar
                                          </button>
                                        </div>
                                      </td>
                                  </tr>
                                </tbody>
                                <tfoot>
                                  <tr>
                                    <th scope="col">Total</th>
                                    <th scope="col"></th>
                                    <th scope="col">{{purchase.total_qty}}</th>
                                    <th scope="col"></th>
                                    <!-- <th scope="col">{{purchase.total_discount}}</th> -->
                                    <th scope="col">{{purchase.total_cost}}</th>
                                    <th scope="col"></th>
                                  </tr>																		
                                </tfoot>															
                            </table>
                          </div>                          

                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Impuesto de pedidos</label>
                          <select
                            v-model="purchase.taxe"
                            class="form-select"
                            @change="calculateTotal()"
                          >
                          <option selected="" disabled="" value="">
                            Seleccione impuesto
                          </option>
                          <option v-for="item in taxes" :value="item" :key="item.id">{{item.name}}</option> 
                          </select>													
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Descuento</label>
                            <div class="input-group">
                              <span class="input-group-text">$</span>
                              <input v-model="purchase.order_discount" @change=" calculateTotal()" class="form-control" type="number"  placeholder="00.00">
                            </div>	                          
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Costo de envío</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input v-model="purchase.shipping_cost" @change=" calculateTotal()" class="form-control" type="number" placeholder="00.00">
                          </div>	                          
                        </div>
                      </div>      
                    </div>

                    <div class="row">
                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Estado de Pago</label>
                          <select
                            v-model="purchase.payment_status"
                            class="form-select"
                            required=""
                          >
                            <option selected="" disabled="" value="">Seleccione estado</option>
                            <option value = "1">Pendiente</option>
                            <option value = "2">Pagado</option>
                          </select>	 	                          
                        </div>
                      </div>      
                    </div>										
                    
                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label class="form-label" for="">Nota</label>
                          <textarea v-model="purchase.note" class="form-control" rows="3"></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="row shadow shadow-showcase p-25" style="background-color: #e9ecef; ">
                      <div class="col-md-2">
                        <div class="mb-2">
                          <label class="form-label" for="">Artículos</label>
                          <div class="input-group">
                            <span class="input-group-text">#</span>
                            <input disabled class="form-control" type="text" v-model="purchase.total_qty" placeholder="0">
                          </div>                          
                        </div>
                      </div>  
                      <div class="col-md-2">
                        <div class="mb-2">
                          <label class="form-label" for="">Total</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input disabled class="form-control" type="number" v-model="purchase.total_cost" placeholder="0.00">
                          </div>                          
                        </div>
                      </div>  
                      <div class="col-md-2">
                        <div class="mb-2">
                          <label class="form-label" for="">Impuesto de Compra</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input disabled class="form-control" type="number" v-model="purchase.order_tax" placeholder="0.00" value="0">
                          </div>                          
                        </div>
                      </div>  
                      <div class="col-md-2">
                        <div class="mb-2">
                          <label class="form-label" for="">Descuento de Compra</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input disabled class="form-control" type="number" v-model="purchase.order_discount" placeholder="0.00">
                          </div>                          
                        </div>
                      </div>  
                      <div class="col-md-2">
                        <div class="mb-2">
                          <label class="form-label" for="">Costo de Envío</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input disabled class="form-control" type="number" v-model="purchase.shipping_cost" placeholder="0.00" value= "0">
                          </div>                          
                        </div>
                      </div>  
                      <div class="col-md-2">
                        <div class="mb-2">
                          <label class="form-label" for="">Gran total</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input disabled class="form-control" type="number" v-model="purchase.grand_total" placeholder="0.00">
                          </div>                          
                        </div>
                      </div>  
                    </div> 
                                                        
                  </form>
                </div>

                <div class="modal-footer">
                  <button
                    @click="createPurchase()"
                    v-if="btn_update_active == 0"
                    class="btn btn-primary"
                    type="submit"
                    data-bs-original-title=""
                    title=""
                  >
                    Guardar
                  </button>
                  <button
                    @click="editPurchase()"
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
          <!-- FIN MODAL - REGISTRAR COMPRA -->  

          <div class="card-body" style="padding: 20px 40px !important">
            <div class="table-responsive style-1 table-hover non-hover m-b-30">
              <table class="table table-bordered">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Fecha</th>
                        <th scope="col">Referencia</th>
                        <th scope="col">Proveedor</th>
                        <th scope="col">Total</th>
                        <th scope="col">Estado de pago</th>
                        <th scope="col">Acciones</th>
                    </tr>
                </thead>
                <tbody>
                  <tr v-for="item in purchases.data" :key="item.id">
                    <td>{{item.id}}</td>
                    <td>{{ item.created_at | timeformat }}</td>
                    <td>{{item.reference_no}}</td>
                    <td>{{ item.supplier.company_name}}</td>
                    <td>{{ item.grand_total }}</td>
                    <td v-if="item.purchase_status == 1"><span class="badge badge-warning">Pendiente</span></td>
                    <td v-if="item.purchase_status == 2"><span class="badge badge-primary">Finalizado</span></td>
                    <td v-if="item.purchase_status == 3"><span class="badge badge-secondary">Cancelado</span></td>
                    <td v-if="item.payment_status == 1"><span class="badge badge-warning">Pendiente</span></td>
                    <td v-if="item.payment_status == 2" ><span class="badge badge-primary">Pagado</span></td>
                    <td>
                      <div class="btn-group">
                        <button @click="editPurchaseData(item), btn_update_active=1, modal_title='Editar Venta'" class="btn btn-primary btn-xs" type="button" title=""  data-bs-toggle="modal"  data-bs-target="#exampleModal">
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
                        <button  @click="deletePurchase(item)" class="btn btn-secondary btn-xs" type="button" title="">
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
                  <p class="card-text">Mostrando de {{(purchases.from)}} a {{(purchases.to)}} de {{purchases.total}} compras.</p>
              </div>
              <div class="col-md-6">
                <nav>
                  <ul class="pagination justify-content-end pagination-primary">
                      <li   :class="(purchases.current_page==1)?'page-item disabled':'page-item'" ><a @click.prevent="loadpurchases(purchases.current_page-1)" href="" tabindex="-1" data-bs-original-title="" title="" class="page-link">Anterior</a></li>
                      <li v-if="purchases.current_page>1" class="page-item"><a @click.prevent="loadpurchases(purchases.current_page-1)" href="" data-bs-original-title="" title="" class="page-link">{{purchases.current_page-1}}</a></li>
                      <li class="page-item active">
                          <a href="#" data-bs-original-title="" title="" class="page-link">{{purchases.current_page}}<span class="sr-only">(current)</span></a>
                      </li>
                      <li v-if="purchases.current_page!=purchases.last_page" class="page-item"><a @click.prevent="loadpurchases(purchases.current_page+1)" href="" data-bs-original-title="" title="" class="page-link">{{purchases.current_page+1}}</a></li>
                      <li :class="(purchases.current_page==purchases.last_page)?'page-item disabled':'page-item'"><a @click.prevent="loadpurchases(purchases.current_page+1)"  href="" data-bs-original-title="" title="" class="page-link">Siguiente</a></li>
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
  import moment from 'moment'
	import VueNumberInput from '@chenfengyuan/vue-number-input';
	export default {
			components: {
				VueNumberInput
			}, 	
			data() {
					return {
              page:1,
              filtroA: "",
              from: "",
              to: "",
              filtroB: "",
              filtroC: "",
              searchValue:'',
							btn_update_active:0,
							modal_title:null,
              attached:[],
              purchases:[],
							purchase:{
                taxe:{},
                supplier_id:null,
                item:0,
                total_qty:0,
                total_tax:0,
                total_cost:0,
                order_tax:0,
                order_discount:0,
                shipping_cost:0,
                grand_total:0,

                status:0,
                payment_status:0,
                document:null,
                note: null,
                product_purchase:[/* {
                  product_id:0,
                  product_variant_id:null,
                  qty:0,
                  net_cost:0,
                  discount:0,
                  tax_rate:0,
                  tax:0,
                  total:0
                } */]
              },						
							suppliers:[],
              taxes: [],
              searchResult:[]
					};
			},

			created() {
        this.loadTaxes()
        this.loadSuppliers()
        this.loadpurchases()
			},

			methods: {
				//Métodos de carga
        
        loadpurchases:function(){
          axios.get('/api/purchase/load?page='+this.page, {
            params: {
              filtroA: this.filtroA,
              from: this.from,
              to: this.to,
              filtroB: this.filtroB,
              filtroC: this.filtroC
            }
          }).then(res=>{
            this.purchases = res.data;
          })
        },
        loadSuppliers:function() {
            axios.get('/api/provider/load').then(res=>{
              this.suppliers = res.data.data;
              console.log(this.suppliers)
            })
        },

        loadTaxes:function() {
            axios.get('/api/taxe/load').then(res=>{
              this.taxes = res.data;
            })
        },

				loadPurchase: function(page) {
          this.page = page
					axios.get('/api/purchase/load?page='+this.page).then(res=>{
						this.purchases = res.data;
					})
				},

        // Métodos de mantenimiento
        createPurchase:function(){
          const blob = JSON.stringify(this.purchase);
          let formData = new FormData();
          formData.append('file', this.attached);
          formData.append("document", blob);

          axios.post( '/api/purchase/add',formData).then(res=>{
            Swal.fire({
              title: 'Registro Exitoso!',
              text: "Se registró compra correctamente.",
              icon: 'success',
              confirmButtonColor: '#98B631',
              confirmButtonText: 'De acuerdo'
            })
            this.clearFields()
            $('#exampleModal').modal('hide')
            this.loadpurchases(this.page);                 
          })

          console.log(this.purchase);
        },
        
        editPurchaseData:function(item) {
            this.purchase = item
        },
        editPurchase:function() {
          const blob = JSON.stringify(this.purchase);
          let formData = new FormData();
          formData.append('file', this.attached);
          formData.append("document", blob);

          axios.post( '/api/purchase/edit',formData).then(res=>{
            Swal.fire({
              title: 'Actualización Exitosa!',
              text: "Se actualizó compra correctamente.",
              icon: 'success',
              confirmButtonColor: '#98B631',
              confirmButtonText: 'De acuerdo'
            })   
            this.clearFields()             
            $('#exampleModal').modal('hide') 
            this.loadpurchases(this.page);                  
          })
        },
        deletePurchase:function(item) {
            this.purchase = item
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
                axios.post('/api/purchase/delete',this.purchase).then(res=>{
                  Swal.fire({
                    title: 'Eliminado!',
                    text: "Se ha eliminado la compra.",
                    icon: 'success',
                    confirmButtonColor: '#98B631',
                    confirmButtonText: 'De acuerdo'
                  })
                  this.loadpurchases(this.page)
                })
              }
            })
        },

        clearFields() {
					this.purchase = {
                taxe:{},
                supplier_id:null,
                item:0,
                total_qty:0,
                total_tax:0,
                total_cost:0,
                order_tax:0,
                order_discount:0,
                shipping_cost:0,
                grand_total:0,

                status:0,
                payment_status:0,
                document:null,
                note: null,
                product_purchase:[/* {
                  product_id:0,
                  product_variant_id:null,
                  qty:0,
                  net_cost:0,
                  discount:0,
                  tax_rate:0,
                  tax:0,
                  total:0
                } */]
              }
        },

        clearFilters() {
          this.filtroA = '',
          this.filtroB = '',
          this.filtroC = '',
          this.from = '',
          this.to = ''
        },
				
				// Métodos de tabla
        calculateTotal() {
            var totalqty, totaldis, totaltax, totalCost;
            var totalItem=0;

            totalqty = this.purchase.product_purchase.reduce(function (sum, product) {
              totalItem+=1
                var lineTotal = parseInt(product.qty,10);
                if (!isNaN(lineTotal)) {
                    return sum + lineTotal;
                }
            }, 0);
            this.purchase.total_qty = totalqty;
            this.purchase.item=totalItem
            
            
            /* totaldis = this.purchase.product_purchase.reduce(function (sum, product) {
                var lineTotal = parseFloat(product.discount);
                if (!isNaN(lineTotal)) {
                    return sum + lineTotal;
                }
            }, 0);
            console.log(totaldis)
            this.purchase.total_discount = totaldis; */

            totalCost = this.purchase.product_purchase.reduce(function (sum, product) {
                var lineTotal = parseFloat(product.subtotal);
                if (!isNaN(lineTotal)) {
                    return sum + lineTotal;
                }
            }, 0);
            this.purchase.total_cost = totalCost;

            console.log(totalCost);
            

            /* if (this.purchase.tax_id == 1) { */
              this.purchase.order_tax = totalCost * parseFloat(this.purchase.taxe.rate)/100
              var tax = this.purchase.order_tax;
              var shipping = parseFloat(this.purchase.shipping_cost);
              var discount = parseFloat(this.purchase.order_discount);
              console.log(this.purchase.order_tax);

              if (!isNaN(shipping) && !isNaN(discount)) {
                this.purchase.grand_total = totalCost + tax + shipping - discount;
              }else if(isNaN(shipping) && !isNaN(discount)){
                this.purchase.grand_total = totalCost + tax - discount;
              }else if(!isNaN(shipping) && isNaN(discount)){
                this.purchase.grand_total = totalCost + tax + shipping;
              }else if(isNaN(shipping) && isNaN(discount)){
                this.purchase.grand_total = totalCost + tax;
              }
            /* }else{
              this.purchase.order_tax = 0;
              var shipping = parseFloat(this.purchase.shipping_cost);
              var discount = parseFloat(this.purchase.order_discount);
              if (!isNaN(shipping) && !isNaN(discount)) {
                this.purchase.grand_total = totalCost + shipping - discount;
              }else if(isNaN(shipping) && !isNaN(discount)){
                this.purchase.grand_total = totalCost - discount;
              }else if(!isNaN(shipping) && isNaN(discount)){
                this.purchase.grand_total = totalCost + shipping;
              }else if(isNaN(shipping) && isNaN(discount)){
                this.purchase.grand_total = totalCost;
              } 


            }*/

        },
        calculateLineTotal(item) {
/*           console.log( (item.price * parseInt(item.qty,10)) - parseFloat(item.discount??0) ) */
             var total = ((parseFloat(item.cost)+ parseFloat(item.product_variant_selected?item.product_variant_selected.additional_cost:0)) * parseInt(item.qty)) - parseFloat(item.discount??0) ;
            if (!isNaN(total)) {
              console.log(total)
                item.subtotal = total;
            } 
            this.calculateTotal();
        },
        deleteRow(index) {
            this.purchase.product_purchase.splice(index, 1);
            this.calculateTotal();
        },
        addNewRow(item) {
          this.purchase.product_purchase.push(item);
        },

        searchProduct:function(value) {
          axios.get('/api/product/search',{params: { 
            value:value,
          }}).then(res=>{
            this.searchResult= res.data;
          })
        },

        handleFile(){
          this.attached=this.$refs.file.files[0]
        },

        buscarCompra(){
          clearTimeout(this.setTimeoutBuscador)
          this.setTimeoutBuscador = setTimeout(this.loadpurchases, 360)
        },
			},

      filters: {
        timeformat: function (arg) {
          // return moment(arg).subtract(10, 'days').calendar()
          moment.locale('es');
          return moment(arg).format('L');
        }
      }   
	};
</script>