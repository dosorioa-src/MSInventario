<template>
  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header" style="padding: 20px 40px !important">

            <div class="row">
              <div class="col-md-2 col-sm-6">
                <label for="">Tipo de Ajuste:</label>
                <select
                  class="form-control form-control-sm"
                  v-model="filtroA"
                  @change="buscarAjuste"
                >
                  <option selected="" disabled="" value="">
                    Seleccionar
                  </option>
                  <option value="Todos">Todos</option>
                  <option value='+'>Aumento</option>
                  <option value="-">Descuento</option>
                </select>                
              </div>

              <div class="col-md-2 col-sm-6">
                <label for="">Almacén:</label>
                <select 
                  class="form-control form-control-sm"
                  v-model="filtroB"
                  @change="buscarAjuste"
                >
                  <option selected="" disabled="" value="">
                    Seleccionar
                  </option>
                  <option value="Todos">Todos</option>
                  <option
                    v-for="item in warehouses"
                    :key="item.id"
                    :value="item.id"
                  >
                    {{ item.name }}
                  </option>
                </select>                
              </div>

              <div class="col-md-3 col-sm-6">
                <label for="">Desde:</label>
								<input class="form-control digits form-control-sm" type="date" v-model="from" @change="buscarAjuste" data-bs-original-title="" title="">
              </div>

              <div class="col-md-3 col-sm-6">
                <label for="">Hasta:</label>
								<input class="form-control digits form-control-sm" type="date" v-model="to" @change="buscarAjuste" data-bs-original-title="" title="">                
              </div>  

              <div class="col-md-2 col-sm-12 align-self-end text-end">
                <button
                  @click="btn_update_active = 0, modal_title = 'Nuevo Ajuste'"
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
              </div>  
            </div>
            <div class="row">

            </div>

          </div>

          <!-- INICIO MODAL - REGISTRAR AJUSTE -->
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
                      <p><i>Los campos con (*) son obligatorios...</i></p>
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="">Almacen(*)</label>
                          <select
                            class="form-select"
                            v-model="adjustment.warehouse_id"
                            @blur="$v.adjustment.warehouse_id.$touch()"
                          >
                            <option selected="" disabled="" value="">
                              Seleccione almacén
                            </option>
                            <option
                              v-for="item in warehouses"
                              :key="item.id"
                              :value="item.id"
                            >
                              {{ item.name }}
                            </option>
                          </select>
                          <template v-if="$v.adjustment.warehouse_id.$error">
                            <p
                              class="errorMessage error"
                              v-if="!$v.adjustment.warehouse_id.required"
                            >
                              Este campo es obligatorio(*)
                            </p>
                          </template>                            
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="validationDefault03"
                            >Documento Adjunto</label
                          >
                          <input
                            class="form-control"
                            @change="handleFile"
                            ref="file"
                            type="file"
                            title=""
                          />
                          <div class="table-responsive">
                            <table class="table">
                              <thead>
                                <tr>
                                  <th>Archivo</th>
                                  <th>Eliminar</th>
                                </tr>
                              </thead>
                              <tbody>
                                <tr v-if="adjustment.document">
                                  <td>
                                    <a :href="'files/adjustment/' + adjustment.document" height="60" width="60">
                                      {{ adjustment.document }}
                                    </a>
                                  </td>
                                  <td>
                                    <a>
                                      <button
                                        @click="adjustment.document = null"
                                        type="button"
                                        title=""
                                        class="btn btn-secondary btn-xs"
                                      >
                                        <svg xmlns="http://www.w3.org/2000/svg" width="15" height="15" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-trash-2">
                                          <polyline  points="3 6 5 6 21 6" ></polyline>
                                          <path  d="M19 6v14a2 2 0 0 1-2 2H7a2 2 0 0 1-2-2V6m3 0V4a2 2 0 0 1 2-2h4a2 2 0 0 1 2 2v2"></path>
                                          <line x1="10" y1="11" x2="10" y2="17"></line>
                                          <line x1="14" y1="11" x2="14" y2="17"></line>
                                        </svg>
                                      </button>
                                    </a>
                                  </td>
                                </tr>
                              </tbody>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="col-md-12">
                      <div class="mb-3">
                        <label class="form-label" for="validationDefault01"
                          >Producto(*)</label
                        >
                        <div class="dropdown">
                          <input
                            class="form-control"
                            type="text"
                            id="dropdownMenuButton"
                            v-model="searchValue"
                            @keyup="searchProduct(searchValue)"
                            placeholder="Escriba el titulo o código del producto"
                            data-toggle="dropdown"
                            aria-haspopup="true"
                            aria-expanded="false"
                          />
                          <div
                            class="form-control dropdown-menu"
                            aria-labelledby="dropdownMenuButton"
                          >
                            <a
                              class="dropdown-item"
                              href="#"
                              v-for="item in searchResult"
                              :key="item.id"
                              data-bs-original-title=""
                              title=""
                              @click="addNewRow(item), (searchValue = ''), (searchResult = [])"
                            >
                              {{ item.code }} | {{ item.name }}
                            </a>
                          </div>
                        </div>
                        <!-- <div class="">
                          <div class="dropdown">
                            <input id="validationDefault01" type="text"  required="required" data-bs-original-title="" title="" class=" form-control"  autocomplete="off">
                            <div class="">
                              <a class=""  ></a>
                            </div>
                          </div>
                        </div> -->
                        <!-- <Dropdown
                          :options="options"
                          v-on:selected="validateSelection"
                          v-on:filter="getDropdownValues"
                          :disabled="false"
                          placeholder="Please select an animal">
                        </Dropdown> -->
                      </div>
                    </div>

                    <!-- <div class="col-md-3">
                      <div class="mb-3">
                        <button  type='button' class="btn btn-light" @click="addNewRow">
                            Agregar
                        </button>
                      </div>
                    </div> -->

                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <div class="form-label">Lista</div>
                          <div
                            class="
                              table-responsive
                              style-1
                              table-hover
                              non-hover
                            "
                          >
                            <table class="table table-bordered">
                              <thead>
                                <tr>
                                  <th scope="col">Producto</th>
                                  <th scope="col">Código</th>
                                  <!-- <th scope="col">Variante</th> -->
                                  <th scope="col">Costo</th>
                                  <th scope="col">Cantidad</th>
                                  <th scope="col">Ajuste</th>
                                  <th scope="col">Acción</th>
                                </tr>
                              </thead>
                              <tbody v-if="btn_update_active == 0">
                                <tr v-for="(item, index) in adjustment.product_adjustment" :key="item.id">
                                  <td style="vertical-align: middle">
                                    {{ item.name }}
                                  </td>
                                  <td style="vertical-align: middle">
                                    {{ item.code }}
                                  </td>
                                  <!-- <td style="vertical-align: middle">
                                    <select
                                      class="form-select"
                                      v-model="item.product_variant_selected"
                                      name=""
                                      id=""
                                    >
                                      <option
                                        v-for="item in item.product_variant"
                                        :key="item.id"
                                        :value="item"
                                      >
                                        {{ item.name }}
                                      </option>
                                    </select>
                                  </td> -->
                                  <td>
                                    <input
                                      @change="totalQty()"
                                      v-model="item.cost"
                                      :min="1"
                                      class="touchspin form-control"
                                      type="number"
                                      style="display: block"
                                      data-bs-original-title=""
                                      title=""
                                    />
                                  </td>
                                  <!-- <td>
                                    <input
                                      v-if="item.product_variant_selected"
                                      @change="totalQty()"
                                      v-model="item.product_variant_selected.additional_cost"
                                      :min="1"
                                      class="touchspin form-control"
                                      type="number"
                                      style="display: block"
                                      data-bs-original-title=""
                                      title=""
                                    />
                                  </td> -->
                                  
                                  <td style="vertical-align: middle">
                                    <input
                                      @change="totalQty()"
                                      v-model="item.qty"
                                      :min="1"
                                      class="touchspin form-control"
                                      type="number"
                                      style="display: block"
                                      data-bs-original-title=""
                                      title=""
                                    />
                                  </td>
                                  <td style="vertical-align: middle">
                                    <select
                                      class="form-select"
                                      v-model="item.action"
                                      required=""
                                    >
                                      <option value="+">+</option>
                                      <option value="-">-</option>
                                    </select>
                                  </td>
                                  <td style="vertical-align: middle">
                                    <div class="btn-group">
                                      <button
                                        @click="deleteRow(index), totalQty()"
                                        class="btn btn-secondary"
                                        style="background-color: #898989; display: inline-block;"
                                        type="button"
                                      >
                                        Borrar
                                      </button>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                              <!-- editar -->
                              <tbody v-if="btn_update_active == 1">
                                <tr v-for="(item, index) in adjustment.product_adjustment" :key="item.id">
                                  <td v-if="!Array.isArray(item.product_variant)" >
                                    {{ item.product.name }}
                                  </td>
                                  <td v-if="!Array.isArray(item.product_variant)" >
                                    {{ item.product.code }}
                                  </td>

                                  <td v-if="Array.isArray(item.product_variant)">
                                    {{ item.name }}
                                  </td>
                                  <td v-if="Array.isArray(item.product_variant)">
                                    {{ item.code }}
                                  </td>

                                  <!-- <td>
                                    <div v-if="!Array.isArray(item.product_variant) && item.product_variant != null">
                                      {{ item.product_variant.name }}
                                    </div>
                                    <select
                                      v-if="Array.isArray(item.product_variant)"
                                      v-model="item.product_variant_selected"
                                      name=""
                                      class="form-select"
                                      id=""
                                    >
                                      <option v-for="item in item.product_variant" :key="item.id" :value="item.id">
                                        {{ item.name }}
                                      </option>
                                    </select>
                                  </td> -->
                                  <td v-if="!Array.isArray(item.product_variant)" >
                                    <input 
                                      @change="totalQty()"
                                      v-model="item.product.cost"
                                      :min="1"
                                      class="touchspin form-control"
                                      type="number"
                                      style="display: block"
                                      data-bs-original-title=""
                                      title=""
                                    />
                                  </td>
                                  <td v-if="Array.isArray(item.product_variant)">
                                    <input
                                      @change="totalQty()"
                                      v-model="item.cost"
                                      :min="1"
                                      class="touchspin form-control"
                                      type="number"
                                      style="display: block"
                                      data-bs-original-title=""
                                      title=""
                                    />
                                  </td>
                                  <!-- <td>
                                    <input
                                      v-if="item.product_variant_selected"
                                      @change="totalQty()"
                                      v-model="item.product_variant_selected.additional_cost"
                                      :min="1"
                                      class="touchspin form-control"
                                      type="number"
                                      style="display: block"
                                      data-bs-original-title=""
                                      title=""
                                    />
                                    <input
                                      v-if="item.product_variant"
                                      @change="totalQty()"
                                      v-model="item.product_variant.additional_cost"
                                      :min="1"
                                      class="touchspin form-control"
                                      type="number"
                                      style="display: block"
                                      data-bs-original-title=""
                                      title=""
                                    />
                                  </td> -->
                                  <td style="vertical-align: middle">
                                    <input
                                      @change="totalQty()"
                                      v-model="item.qty"
                                      :min="1"
                                      class="touchspin form-control"
                                      type="number"
                                      style="display: block"
                                      data-bs-original-title=""
                                      title=""
                                    />
                                  </td>
                                  <td style="vertical-align: middle">
                                    <select
                                      class="form-select"
                                      v-model="item.action"
                                      required=""
                                    >
                                      <option value="+">+</option>
                                      <option value="-">-</option>
                                    </select>
                                  </td>
                                  <td style="vertical-align: middle">
                                    <div class="btn-group">
                                      <button
                                        @click="deleteRow(index), totalQty()"
                                        class="btn btn-secondary"
                                        style="
                                          background-color: #898989;
                                          display: inline-block;
                                        "
                                        type="button"
                                      >
                                        Borrar
                                      </button>
                                    </div>
                                  </td>
                                </tr>
                              </tbody>
                              <tfoot class="tfoot active">
                                <tr>
                                  <th colspan="2">Total</th>
                                  <th></th>
                                  <th id="total-qty" colspan="2">
                                    {{ adjustment.total_qty }}
                                  </th>
                                </tr>
                              </tfoot>
                            </table>
                          </div>
                        </div>
                      </div>
                    </div>

                    <div class="row">
                      <div class="col-md-12">
                        <div class="mb-3">
                          <label for="exampleFormControlTextarea4"
                            >Nota</label
                          >
                          <textarea
                            class="form-control"
                            id="exampleFormControlTextarea4"
                            v-model="adjustment.note"
                            rows="3"
                          ></textarea>
                        </div>
                      </div>
                    </div>
                  </form>
                </div>

                <div class="modal-footer">
                  <button
                    @click="createAdjustment()"
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
                    @click="editAdjustment(), clearFields()"
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

          <div class="card-body" style="padding: 20px 40px !important">
            <div class="table-responsive style-1 table-hover non-hover">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th scope="col">Fecha</th>
                    <th scope="col">Almacen</th>
                    <th scope="col">Nota</th>
                    <th scope="col">Articulos | Stock</th>
                    <th scope="col">Acciones</th>
                  </tr>
                </thead>
                <tbody>
                  <tr v-for="item in adjustments.data" :key="item.id">
                    <td>{{ item.created_at | timeformat }}</td>
                    <td>{{ item.warehouse.name }}</td>
                    <td>{{ item.note }}</td>
                    <td>{{ item.item }} | {{ item.total_qty }}</td>
                    <td>
                      <div class="btn-group">
                        <!-- <button
                          @click="editAdjustmentData(item), btn_view_active = 1, modal_title='Ajuste'"
                          class="btn btn-ligth btn-xs"
                          style="background-color: #898989"
                          data-bs-toggle="modal"
                          data-bs-target="#exampleModal"
                          data-bs-original-title=""
                          type="button"
                          title=""
                        >
                          <svg
                            class="align-middle"
                            width="15"
                            height="15"
                            viewBox="0 0 20 20"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <path
                              d="M13.125 10C13.125 10.8288 12.7958 11.6237 12.2097 12.2097C11.6237 12.7958 10.8288 13.125 10 13.125C9.1712 13.125 8.37634 12.7958 7.79029 12.2097C7.20424 11.6237 6.875 10.8288 6.875 10C6.875 9.1712 7.20424 8.37634 7.79029 7.79029C8.37634 7.20424 9.1712 6.875 10 6.875C10.8288 6.875 11.6237 7.20424 12.2097 7.79029C12.7958 8.37634 13.125 9.1712 13.125 10Z"
                              fill="white"
                            />
                            <path
                              fill-rule="evenodd"
                              clip-rule="evenodd"
                              d="M0 10C0 10 3.75 3.125 10 3.125C16.25 3.125 20 10 20 10C20 10 16.25 16.875 10 16.875C3.75 16.875 0 10 0 10ZM10 14.375C11.1603 14.375 12.2731 13.9141 13.0936 13.0936C13.9141 12.2731 14.375 11.1603 14.375 10C14.375 8.83968 13.9141 7.72688 13.0936 6.90641C12.2731 6.08594 11.1603 5.625 10 5.625C8.83968 5.625 7.72688 6.08594 6.90641 6.90641C6.08594 7.72688 5.625 8.83968 5.625 10C5.625 11.1603 6.08594 12.2731 6.90641 13.0936C7.72688 13.9141 8.83968 14.375 10 14.375Z"
                              fill="white"
                            />
                          </svg>
                        </button> -->
                        <button
                          @click="editAdjustmentData(item), btn_update_active = 1, modal_title='Editar Ajuste'"
                          data-bs-toggle="modal"
                          data-bs-target="#exampleModal"
                          data-bs-original-title=""
                          type="button"
                          title=""
                          class="btn btn-primary btn-xs"
                        >
                          <svg
                            class="align-middle"
                            width="15"
                            height="15"
                            viewBox="0 0 20 20"
                            fill="none"
                            xmlns="http://www.w3.org/2000/svg"
                          >
                            <g clip-path="url(#clip0)">
                              <path
                                fill-rule="evenodd"
                                clip-rule="evenodd"
                                d="M16.0721 0.175179C15.9549 0.0580096 15.796 -0.0078125 15.6302 -0.0078125C15.4645 -0.0078125 15.3056 0.0580096 15.1884 0.175179L13.1296 2.23393L17.7634 6.86768L19.8221 4.81018C19.8803 4.75212 19.9265 4.68315 19.958 4.60722C19.9895 4.53129 20.0057 4.44989 20.0057 4.36768C20.0057 4.28547 19.9895 4.20407 19.958 4.12814C19.9265 4.05221 19.8803 3.98324 19.8221 3.92518L16.0721 0.175179ZM16.8796 7.75143L12.2459 3.11768L4.12086 11.2427H4.37961C4.54537 11.2427 4.70435 11.3085 4.82156 11.4257C4.93877 11.5429 5.00461 11.7019 5.00461 11.8677V12.4927H5.62961C5.79537 12.4927 5.95435 12.5585 6.07156 12.6757C6.18877 12.7929 6.25461 12.9519 6.25461 13.1177V13.7427H6.87962C7.04538 13.7427 7.20435 13.8085 7.32156 13.9257C7.43877 14.0429 7.50462 14.2019 7.50462 14.3677V14.9927H8.12962C8.29538 14.9927 8.45435 15.0585 8.57156 15.1757C8.68877 15.2929 8.75462 15.4519 8.75462 15.6177V15.8764L16.8796 7.75143ZM7.54462 17.0864C7.51831 17.0165 7.50477 16.9424 7.50462 16.8677V16.2427H6.87962C6.71386 16.2427 6.55488 16.1768 6.43767 16.0596C6.32046 15.9424 6.25461 15.7834 6.25461 15.6177V14.9927H5.62961C5.46385 14.9927 5.30488 14.9268 5.18767 14.8096C5.07046 14.6924 5.00461 14.5334 5.00461 14.3677V13.7427H4.37961C4.21385 13.7427 4.05488 13.6768 3.93767 13.5596C3.82046 13.4424 3.75461 13.2834 3.75461 13.1177V12.4927H3.12961C3.05489 12.4926 2.98079 12.479 2.91086 12.4527L2.68711 12.6752C2.62755 12.7352 2.58077 12.8066 2.54961 12.8852L0.0496099 19.1352C0.00414655 19.2488 -0.00698284 19.3732 0.0176015 19.493C0.0421858 19.6129 0.101403 19.7229 0.187911 19.8094C0.274419 19.8959 0.384414 19.9551 0.50426 19.9797C0.624105 20.0043 0.748531 19.9931 0.862111 19.9477L7.11212 17.4477C7.19069 17.4165 7.26213 17.3697 7.32212 17.3102L7.54462 17.0877V17.0864Z"
                                fill="white"
                              ></path>
                            </g>
                            <defs>
                              <clipPath id="clip0">
                                <rect width="20" height="20" fill="white"></rect>
                              </clipPath>
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
                  <p class="card-text">Mostrando de {{(adjustments.from)}} a {{(adjustments.to)}} de {{adjustments.total}} ajustes.</p>
              </div>
              <div class="col-md-6">
                <nav>
                  <ul class="pagination justify-content-end pagination-primary">
                    <li :class="(adjustments.current_page==1)?'page-item disabled':'page-item'">
                      <a @click.prevent="loadAdjustment(adjustments.current_page-1)" class="page-link" href="#" tabindex="-1" data-bs-original-title="" title="">Anterior</a>
                    </li>
                    <li v-if="adjustments.current_page>1" class="page-item">
                      <a @click.prevent="loadAdjustment(adjustments.current_page-1)" class="page-link" href="#" data-bs-original-title="" title="">{{adjustments.current_page-1}}</a>
                    </li>
                    <li class="page-item active">
                      <a class="page-link" href="#" data-bs-original-title="" title="">{{adjustments.current_page}}<span class="sr-only">(current)</span></a>
                    </li>
                    <li v-if="adjustments.current_page!=adjustments.last_page" class="page-item">
                      <a @click.prevent="loadAdjustment(adjustments.current_page+1)" class="page-link" href="#" data-bs-original-title="" title="">{{adjustments.current_page+1}}</a>
                    </li>
                    <li :class="(adjustments.current_page==adjustments.last_page)?'page-item disabled':'page-item'">
                      <a @click.prevent="loadAdjustment(adjustments.current_page+1)" class="page-link" href="#" data-bs-original-title="" title="">Siguiente</a>
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
<style >
</style>
<script>
import Swal from 'sweetalert2'
import { required } from 'vuelidate/lib/validators'
import moment from 'moment'
export default {
  data() {
    return {
      page:1,
      filtroA: "",
      filtroB: "",
      from: "",
      to: "",
      searchValue: "",
      optionSelected: "",
      searchResult: [],
      modal_title: "",
      btn_update_active: 0,
      btn_view_active: 0,
      attached: [],
      adjustments: [],
      adjustment: {
        warehouse_id: "",
        note: null,
        total_qty: 0,
        item: 0,
        product_variant_selected: {},
        product_adjustment: [],
      },
      warehouses: [],
      auxiliary: {
        product: {
          name: "",
          code: "",
        },
      },
    };
  },

  created() {
    this.loadWarehouse();
    this.loadAdjustment();
    this.updateCost();
  },
  methods: {
    updateCost: function(){
            axios.get('/api/sale/updatecost').then(res=>{
              
            })
        },
    //Métodos de carga
    loadAdjustment: function () {
      axios.get("/api/adjustment/load?page="+this.page, {
        params: {
          filtroA: this.filtroA,
          filtroB: this.filtroB,
          from: this.from,
          to: this.to
        }
      }).then((res) => {
        this.adjustments = res.data;
      });
    },
    loadWarehouse: function () {
      axios.get("/api/warehouse/load").then((res) => {
        this.warehouses = res.data;
      });
    },
    //Métodos de mantenimiento
    handleFile() {
      this.attached = this.$refs.file.files[0];
    },
    createAdjustment: function () {
      const blob = JSON.stringify(this.adjustment);
      let formData = new FormData();
      formData.append("file", this.attached);
      formData.append("document", blob);

      axios.post("/api/adjustment/add", formData).then((res) => {
        Swal.fire({
          title: 'Registro Exitoso!',
          text: "Se registró ajuste correctamente.",
          icon: 'success',
          confirmButtonColor: '#98B631',
          confirmButtonText: 'De acuerdo'
        })
        this.clearFields()
        $('#exampleModal').modal('hide')          
        this.loadAdjustment(this.page);
      });
    },
    editAdjustmentData: function (item) {
      this.adjustment = item;
    },
    editAdjustment: function () {
      const blob = JSON.stringify(this.adjustment);
      let formData = new FormData();
      formData.append("file", this.attached);
      formData.append("document", blob);

      axios.post("/api/adjustment/edit", formData).then((res) => {
        Swal.fire({
          title: 'Actualización Exitosa!',
          text: "Se actualizó ajuste correctamente.",
          icon: 'success',
          confirmButtonColor: '#98B631',
          confirmButtonText: 'De acuerdo'
        })        
        this.clearFields()             
        $('#exampleModal').modal('hide')        
        this.loadAdjustment(this.page);
      });
    },
    // Métodos de tabla
    deleteRow(index) {
      this.adjustment.product_adjustment.splice(index, 1);
      this.adjustment.item = this.adjustment.product_adjustment.length;
    },
    addNewRow(item) {
      this.adjustment.product_adjustment.push(item);
      this.adjustment.item = this.adjustment.product_adjustment.length;
    },
    totalQty: function () {
      this.adjustment.total_qty = 0;
      this.adjustment.product_adjustment.forEach((value) => {
        if (value.qty) {
          this.adjustment.total_qty =
            parseInt(this.adjustment.total_qty) + parseInt(value.qty);
        }
      });
    },
    //metodos para dropdown
    searchProduct: function (value) {
      axios
        .get("/api/product/search", {
          params: {
            value: value,
          },
        })
        .then((res) => {
          this.searchResult = res.data;
        });
    },

    //Métodos adicionales
    clearFields: function () {
      this.adjustment = {
        warehouse_id: "",
        note: "",
        total_qty: 0,
        item: 0,
        product_variant_selected: {},
        product_adjustment: [],
      };
      this.$v.$reset()
    },

    buscarAjuste(){
      clearTimeout(this.setTimeoutBuscador)
      this.setTimeoutBuscador = setTimeout(this.loadAdjustment, 360)
    },     
  },

  validations: {
    adjustment: {
      warehouse_id: {
        required
      }
    }
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

<style scoped>
.error {
  text-align: left;
  color: #f73164;
  margin-top: 0%;
  margin-bottom: 0%;
  font-size: 0.75rem;
}
</style>