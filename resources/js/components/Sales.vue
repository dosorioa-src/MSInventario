<template>
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-12">
                <div class="card">
                    <div class="card-header">
                        <div class="file-content">
                            <div class="media">
                                <form
                                    class="form-inline"
                                    action="#"
                                    method="get"
                                >
                                    <div class="form-group mb-0">
                                        <i class="fa fa-search"></i>
                                        <input
                                            class="form-control-plaintext"
                                            type="text"
                                            placeholder="Buscar..."
                                        />
                                    </div>
                                </form>
                                <div class="media-body text-end">
																	<button
																		@click="modal_title='Nueva Venta'"
																		class="btn btn-primary"
																		type="button"
																		data-bs-toggle="modal"
																		data-original-title="test"
																		data-bs-target="#exampleModal"
																		data-bs-original-title=""
																		title=""
																	>
																		Nueva Venta
																	</button>																	
                                </div>
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
                          <label class="form-label" for="">Cliente</label>
														<input
															class="form-control"
															type="text"
															v-model="sale.client"
															placeholder=""
														/>														
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="">Origen de Venta</label>
                          <select
                            class="form-select"
                            v-model="sale.origin"
                          >	
														<option selected="" disabled="" value="">Seleccione origen</option>
                            <option value="Página Web" >Página Web</option>
                            <option value="MercadoLibre" >MercadoLibre</option>
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
														<input
															class="form-control"
															type="text"
															v-model="product"
															placeholder="Escriba el título o código de producto"
														/>	
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
																		<th scope="col">Producto</th>
																		<th scope="col">Variante</th>
																		<th scope="col">Cantidad</th>
																		<th scope="col">Precio Unitario Neto</th>
																		<th scope="col">Descuento</th>
																		<th scope="col">Total Parcial</th>
																		<th scope="col">Acción</th>
                                  </tr>
                                </thead>
                                <tbody>
                                  <tr v-for="(item, index) in sale.product_sales">
                                      <td style="vertical-align: middle;">Producto</td>
                                      <td style="vertical-align: middle;">
                                        <select
                                          class="form-select"
                                          v-model="item.variant_id"
                                        >
                                        <option v-for="variant in variants" :key="variant.id" :value="variant.id" >{{ variant.name }}</option> 
                                        </select>
                                      </td>
                                      <td>
																				<vue-number-input v-model="item.qty" :min="1" inline center controls @change="calculateLineTotal(item)"></vue-number-input>
																			</td>
                                      <td>
																				<input class="form-control" type="number" v-model="item.unit_price" @change="calculateLineTotal(item)">
																			</td>
                                      <td>
																				<input class="form-control" type="number" v-model="item.discount" placeholder="00.00" @change="calculateLineTotal(item)">
																			</td>
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
																		<th scope="col">{{sale.total_qty}}</th>
																		<th scope="col"></th>
																		<th scope="col">{{sale.total_discount}}</th>
																		<th scope="col">{{sale.total_price}}</th>
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
                          <label class="form-label" for="">Impuesto</label>
                          <select
                            class="form-select"
                            @change="calculateTotal()"
                            v-model="sale.tax_id"
                          >
                          <option selected="" disabled="" value="">
                            Seleccione impuesto
                          </option>
                          <option v-for="item in taxes" :key="item.id" :value="item.id" >{{ item.name }}</option> 
                          </select>													
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Descuento al total de venta</label>
														<div class="input-group">
                              <span class="input-group-text">$</span>
                              <input @change=" calculateTotal()" class="form-control" type="number" v-model="sale.order_discount" placeholder="00.00">
                            </div>	                          
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Costo de envío</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input @change=" calculateTotal()" class="form-control" type="number" v-model="sale.shipping_cost" placeholder="00.00">
                          </div>	                          
                        </div>
                      </div>      
                    </div>

                    <div class="row">
                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Documento adjunto</label>
													<input class="form-control" type="file" title="">													
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Estado de Venta</label>
                          <select
                            class="form-select"                           
                            v-model="sale.sale_status"
                            required=""
                          >
                            <option selected="" disabled="" value="">Seleccione estado</option>
                            <option value = "1">Pendiente</option>
                            <option value = "2">Finalizado</option>
                            <option value = "3">Cancelado</option>
                          </select>	                          
                        </div>
                      </div>

                      <div class="col-md-4">
                        <div class="mb-3">
                          <label class="form-label" for="">Estado de Pago</label>
                          <select
                            class="form-select"
                            
                            v-model="sale.payment_status"
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
                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="">Nota de venta</label>
                          <textarea class="form-control" v-model="sale.sale_note" rows="3"></textarea>
                        </div>
                      </div>

                      <div class="col-md-6">
                        <div class="mb-3">
                          <label class="form-label" for="">Nota del personal</label>
                          <textarea class="form-control" v-model="sale.staff_note" rows="3"></textarea>
                        </div>
                      </div>
                    </div>

                    <div class="row shadow shadow-showcase p-25" style="background-color: #e9ecef; ">
                      <div class="col-md-2">
                        <div class="mb-2">
                          <label class="form-label" for="">Artículos</label>
                          <div class="input-group">
                            <span class="input-group-text">#</span>
                            <input disabled class="form-control" type="number" v-model="sale.total_qty" placeholder="0">
                          </div>                          
                        </div>
                      </div>  
                      <div class="col-md-2">
                        <div class="mb-2">
                          <label class="form-label" for="">Total</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input disabled class="form-control" type="number" v-model="sale.total_price" placeholder="0.00">
                          </div>                          
                        </div>
                      </div>  
                      <div class="col-md-2">
                        <div class="mb-2">
                          <label class="form-label" for="">Impuesto de venta</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input disabled class="form-control" type="number" v-model="sale.order_tax" placeholder="0.00" value="0">
                          </div>                          
                        </div>
                      </div>  
                      <div class="col-md-2">
                        <div class="mb-2">
                          <label class="form-label" for="">Descuento de venta</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input disabled class="form-control" type="number" v-model="sale.order_discount" placeholder="0.00">
                          </div>                          
                        </div>
                      </div>  
                      <div class="col-md-2">
                        <div class="mb-2">
                          <label class="form-label" for="">Costo de Envío</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input disabled class="form-control" type="number" v-model="sale.shipping_cost" placeholder="0.00" value= "0">
                          </div>                          
                        </div>
                      </div>  
                      <div class="col-md-2">
                        <div class="mb-2">
                          <label class="form-label" for="">Gran total</label>
                          <div class="input-group">
                            <span class="input-group-text">$</span>
                            <input disabled class="form-control" type="number" v-model="sale.grand_total" placeholder="0.00">
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
          <!-- FIN MODAL - REGISTRAR VENTA -->  


                    <div class="table-responsive style-1 table-hover non-hover m-b-30">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th scope="col">#</th>
                                    <th scope="col">Fecha</th>
                                    <th scope="col">Referencia</th>
                                    <th scope="col">Origen</th>
                                    <th scope="col">Cliente</th>
                                    <th scope="col">Estado de venta</th>
                                    <th scope="col">Estado de pago</th>
                                    <th scope="col">Gran total</th>
                                    <th scope="col">Pagado</th>
                                    <th scope="col">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr v-for="item in sales" :key="item.id">
                                    <td>1</td>
                                    <td>{{ item.created_at }}</td>
                                    <td>Referencia</td>
                                    <td>{{ item.origin }}</td>
                                    <td>Cliente</td>

                                    <td v-if="item.sale_status == 1"><span class="badge badge-warning">Pendiente</span></td> 
                                    <td v-if="item.sale_status == 2"><span class="badge badge-primary">Finalizado</span></td> 
                                    <td v-if="item.sale_status == 3"><span class="badge badge-secondary">Cancelado</span></td>
                                    
                                    <td v-if="item.payment_status == 1"><span class="badge badge-warning">Pendiente</span></td> 
                                    <td v-if="item.payment_status == 2" ><span class="badge badge-primary">Pagado</span></td>                                        
                                    
                                    <td>{{ item.total_price }}</td>
                                    <td>{{ item.paid_amount }}</td>
                                    <td>00.00</td>
                                    <td>
																			<div class="btn-group">
																				<button @click="editSaleData(item), btn_update_active=1, modal_title='Editar Venta'" class="btn btn-primary btn-xs" type="button" title=""  data-bs-toggle="modal"  data-bs-target="#exampleModal">
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
																				<button  @click="deleteSale(item)" class="btn btn-secondary btn-xs" type="button" title="">
																						<svg class="align-middle" width="15" height="15" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
																							<g clip-path="url(#clip0)">
																							<path fill-rule="evenodd" clip-rule="evenodd" d="M1.25 17.5C1.25 17.5 0 17.5 0 16.25C0 15 1.25 11.25 7.5 11.25C13.75 11.25 15 15 15 16.25C15 17.5 13.75 17.5 13.75 17.5H1.25ZM7.5 10C8.49456 10 9.44839 9.60491 10.1517 8.90165C10.8549 8.19839 11.25 7.24456 11.25 6.25C11.25 5.25544 10.8549 4.30161 10.1517 3.59835C9.44839 2.89509 8.49456 2.5 7.5 2.5C6.50544 2.5 5.55161 2.89509 4.84835 3.59835C4.14509 4.30161 3.75 5.25544 3.75 6.25C3.75 7.24456 4.14509 8.19839 4.84835 8.90165C5.55161 9.60491 6.50544 10 7.5 10ZM15.1825 6.4325C15.2406 6.3743 15.3095 6.32812 15.3855 6.29661C15.4614 6.2651 15.5428 6.24888 15.625 6.24888C15.7072 6.24888 15.7886 6.2651 15.8645 6.29661C15.9405 6.32812 16.0094 6.3743 16.0675 6.4325L17.5 7.86625L18.9325 6.4325C19.0499 6.31514 19.209 6.24921 19.375 6.24921C19.541 6.24921 19.7001 6.31514 19.8175 6.4325C19.9349 6.54986 20.0008 6.70903 20.0008 6.875C20.0008 7.04097 19.9349 7.20014 19.8175 7.3175L18.3837 8.75L19.8175 10.1825C19.9349 10.2999 20.0008 10.459 20.0008 10.625C20.0008 10.791 19.9349 10.9501 19.8175 11.0675C19.7001 11.1849 19.541 11.2508 19.375 11.2508C19.209 11.2508 19.0499 11.1849 18.9325 11.0675L17.5 9.63375L16.0675 11.0675C15.9501 11.1849 15.791 11.2508 15.625 11.2508C15.459 11.2508 15.2999 11.1849 15.1825 11.0675C15.0651 10.9501 14.9992 10.791 14.9992 10.625C14.9992 10.459 15.0651 10.2999 15.1825 10.1825L16.6163 8.75L15.1825 7.3175C15.1243 7.25944 15.0781 7.19047 15.0466 7.11454C15.0151 7.03861 14.9989 6.95721 14.9989 6.875C14.9989 6.79279 15.0151 6.71139 15.0466 6.63546C15.0781 6.55953 15.1243 6.49056 15.1825 6.4325Z" fill="white"/>
																							</g>
																							<defs>
																							<clipPath id="clip0">
																							<rect width="20" height="20" fill="white"/>
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
                    <nav class = "m-b-30" aria-label="...">
                        <ul class="pagination justify-content-center pagination-primary">
                            <li class="page-item disabled"><a class="page-link" href="#" tabindex="-1" data-bs-original-title="" title="">Anterior</a></li>
                            <li class="page-item"><a class="page-link" href="#" data-bs-original-title="" title="">1</a></li>
                            <li class="page-item active"><a class="page-link" href="#" data-bs-original-title="" title="">2 <span class="sr-only">(current)</span></a></li>
                            <li class="page-item"><a class="page-link" href="#" data-bs-original-title="" title="">3</a></li>
                            <li class="page-item"><a class="page-link" href="#" data-bs-original-title="" title="">Siguiente</a></li>
                        </ul>
                    </nav>

                </div>
            </div>
        </div>
    </div>
</template>

<script>
	import VueNumberInput from '@chenfengyuan/vue-number-input';
	export default {
			components: {
				VueNumberInput
			}, 	
			data() {
					return {
							btn_update_active:0,
							modal_title:'',
							sales: [],
							sale: {
								client: '',
								origin: '',
								product_sales: [{ 
                  product_id: '',
                  variant_id: '',
									qty: 1,
									unit_price: 0,
									discount: 0,
									subtotal: 0
								}],
								tax_id: '',                
								total_qty: '',
								total_discount: 0,
								total_price: '',
								order_tax: '',
                order_discount: 0,                
								shipping_cost: 0,
                grand_total: '',                
								document: '',
								sale_status: '',
								payment_status: '',
								sale_note: '',
								staff_note: ''
							},
							product: '',
							warehouses: [],
              taxes: ''
					};
			},

			created() {
				//this.loadSales()
        //this.loadTaxes()
				this.sale.product_sales = []
			},

			methods: {
				//Métodos de carga
        loadTaxes:function() {
            axios.get('/api/taxe/load').then(res=>{
              this.taxes = res.data;
              console.log(this.taxes)
            })
        },

				loadSales: function() {
					axios.get('/api/product/load').then(res=>{
						this.sales = res.data;
					})
				},

        // Métodos de mantenimiento
        createSale:function(){
            axios.post('/api/categorie/add',this.categorie).then(res=>{
              $('#exampleModal').modal('hide')
              this.loadSales()
            })
        },
        
        editSaleData:function(item) {
            this.sale = item
        },
        editSale:function() {
            axios.put('/api/categorie/edit',this.categorie).then(res=>{
                $('#exampleModal').modal('hide')
                this.loadSales()
                this.clearFields()
            })
        },
        deleteCategorie:function(item) {
            this.categorie = item
            axios.post('/api/categorie/delete',this.categorie).then(res=>{
                this.loadSales()
            })
        },
        clearFields() {
					this.sale.client = '',
					this.sale.origin= '',
					this.sale.product_sales= [],
					this.sale.total_qty= '',
					this.sale.order_tax= '',
					this.sale.total_price= '',
					this.sale.tax_id= '',
					this.sale.total_discount= '',
					this.sale.order_discount= '',
					this.sale.shipping_cost= '',
					this.sale.document= '',
					this.sale.sale_status= '',
					this.sale.payment_status= '',
					this.sale.sale_note= '',
					this.sale.staff_note= ''
        },
				
				// Métodos de tabla
        calculateTotal() {
            var totalqty, totaldis, totaltax, totalprice;
            totalqty = this.sale.product_sales.reduce(function (sum, product) {
                var lineTotal = parseInt(product.qty,10);
                if (!isNaN(lineTotal)) {
                    return sum + lineTotal;
                }
            }, 0);
            this.sale.total_qty = totalqty;

            totaldis = this.sale.product_sales.reduce(function (sum, product) {
                var lineTotal = parseFloat(product.discount);
                if (!isNaN(lineTotal)) {
                    return sum + lineTotal;
                }
            }, 0);
            this.sale.total_discount = totaldis.toFixed(2);

            // totaltax = this.sale.product_sales.reduce(function (sum, product) {
            //     var lineTotal = parseFloat(product.tax);
            //     if (!isNaN(lineTotal)) {
            //         return sum + lineTotal;
            //     }
            // }, 0);
            // this.sale.order_tax = totaltax.toFixed(2);

            totalprice = this.sale.product_sales.reduce(function (sum, product) {
                var lineTotal = parseFloat(product.subtotal);
                if (!isNaN(lineTotal)) {
                    return sum + lineTotal;
                }
            }, 0);
            this.sale.total_price = totalprice.toFixed(2);

            console.log(totalprice);
            console.log(this.sale.tax_id);

            if (this.sale.tax_id == 1) {
              this.sale.order_tax = totalprice * 0.15;
              var tax = this.sale.order_tax;
              var shipping = parseFloat(this.sale.shipping_cost);
              var discount = parseFloat(this.sale.order_discount);
              console.log(this.sale.order_tax,shipping,discount);
              if (!isNaN(shipping) && !isNaN(discount)) {
                this.sale.grand_total = totalprice + tax + shipping - discount;
              }else if(isNaN(shipping) && !isNaN(discount)){
                this.sale.grand_total = totalprice + tax - discount;
              }else if(!isNaN(shipping) && isNaN(discount)){
                this.sale.grand_total = totalprice + tax + shipping;
              }else if(isNaN(shipping) && isNaN(discount)){
                this.sale.grand_total = totalprice + tax;
              }
            }else{
              this.sale.order_tax = 0;
              var shipping = parseFloat(this.sale.shipping_cost);
              var discount = parseFloat(this.sale.order_discount);
              if (!isNaN(shipping) && !isNaN(discount)) {
                this.sale.grand_total = totalprice + shipping - discount;
              }else if(isNaN(shipping) && !isNaN(discount)){
                this.sale.grand_total = totalprice - discount;
              }else if(!isNaN(shipping) && isNaN(discount)){
                this.sale.grand_total = totalprice + shipping;
              }else if(isNaN(shipping) && isNaN(discount)){
                this.sale.grand_total = totalprice;
              }
            }

        },
        calculateLineTotal(item) {
            var total = (parseFloat(item.unit_price) * parseInt(item.qty,10)) - parseFloat(item.discount) ;
            if (!isNaN(total)) {
                item.subtotal = total.toFixed(2);
            }
            this.calculateTotal();
        },
        deleteRow(index) {
            this.sale.product_sales.splice(index, 1);
            this.calculateTotal();
        },
        addNewRow() {
            this.sale.product_sales.push({ 
              product_id:'',
              variant_id: '',
							qty: 1,
							unit_price: 0,
							discount: 0,
							subtotal: 0
            });
            this.product = ""
        } 
			}
	};
</script>