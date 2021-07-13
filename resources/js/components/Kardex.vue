<template>

  <div class="container-fluid">
    <div class="row">
      <div class="col-sm-12">
        <div class="card">
          <div class="card-header" style="padding: 20px 40px !important">

            <div class="row">
              <div class="col-md-4 col-sm-12">
                <label for="">Buscar por:</label>
                <div class="dropdown">
                  <input class="form-control" type="text" id="dropdownMenuButton"  @keyup="searchProduct(searchValue)" placeholder="Escriba el titulo o código del producto" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                  <div class="form-control dropdown-menu" aria-labelledby="dropdownMenuButton">
                    <a class="dropdown-item"  href="#" v-for="item in searchResult" :key="item.id"  data-bs-original-title="" title="" @click="search(filter.searchValue=item.code), searchValue='', searchResult=[]">{{item.code}} | {{item.name}}</a>
                  </div>
                </div>
                <!-- <div class="input-group input-group-sm">
                  <div class="input-group-prepend"><span class="input-group-text">
                    <svg xmlns="http://www.w3.org/2000/svg" width="12" height="17" fill="currentColor" class="bi bi-search" viewBox="0 0 16 16">
                      <path d="M11.742 10.344a6.5 6.5 0 1 0-1.397 1.398h-.001c.03.04.062.078.098.115l3.85 3.85a1 1 0 0 0 1.415-1.414l-3.85-3.85a1.007 1.007 0 0 0-.115-.1zM12 6.5a5.5 5.5 0 1 1-11 0 5.5 5.5 0 0 1 11 0z"/>
                    </svg>                    
                  </span></div>
                  <input @change="search()" v-model="filter.searchValue" class="form-control" type="text" placeholder="Nombre o código...">
                </div> -->
              </div>

              <div class="col-md-3 col-sm-6">
                <label for="">Desde:</label>
								<input v-model="filter.from" @change="search()" class="form-control digits form-control-sm" type="date" value="" data-bs-original-title="" title="">
              </div>

              <div class="col-md-3 col-sm-6">
                <label for="">Hasta:</label>
								<input v-model="filter.to" @change="search()" class="form-control digits form-control-sm" type="date" value="" data-bs-original-title="" title=""> 
              </div>
            </div> 

          </div>

          <div class="card-body" style="padding: 20px 40px !important">
            <div class="table-responsive style-1 table-hover non-hover">
              <table class="table table-striped table-double">
   <thead>
      <tr>
         <th class="text-center bg-primary" colspan="2">Producto</th>
         <th class="text-center bg-light" colspan="10">{{kardex.name}}</th>
      </tr>
      <tr>
         <th colspan="2" class="text-center bg-primary">Almacen</th>
         <th colspan="3" class="text-center bg-light">Bodega</th>
         <th colspan="2" class="text-center bg-primary">Minimo</th>
         <th colspan="3" class="text-center bg-light">{{kardex.alert_quantity}}</th>
      </tr>
      <tr>
         <th colspan="2" class="text-center bg-light"></th>
         <th colspan="3" class="text-center text-white" style="background-color: #7b9227">Unidades</th>
         <th colspan="1" class="text-center text-white" style="background-color: #8faa2e">Costo</th>
         <th colspan="3" class="text-center text-white" style="background-color: #7b9227">Valores</th>
      </tr>
      <tr>
         <th colspan="1" class="text-center bg-primary">Fecha</th>
         <th colspan="1" class="text-center bg-primary">Referencia</th>
         <th colspan="1" class="text-center text-white" style="background-color: #7b9227">Entrada</th>
         <th colspan="1" class="text-center text-white" style="background-color: #7b9227">Salida</th>
         <th colspan="1" class="text-center text-white" style="background-color: #7b9227">Existencia</th>
         <th colspan="1" class="text-center text-white" style="background-color: #8faa2e">Unitario</th>
         <th colspan="1" class="text-center text-white" style="background-color: #7b9227">Debe</th>
         <th colspan="1" class="text-center text-white" style="background-color: #7b9227">Haber</th>
         <th colspan="1" class="text-center text-white" style="background-color: #7b9227">Saldo</th>
      </tr>
   </thead>
   <tbody>
      <tr v-for="item in kardex.kardex" :key="item.id">
         <th>{{item.created_at | timeformat}}</th>
         <th>{{item.type}}</th>
         <!-- entrada -->
         <th> <div v-if="item.type=='Compra'">{{item.qty}}</div> <div v-if="item.action=='+'">{{item.qty}}</div> </th>
         <!-- salida -->
          <th> <div v-if="item.type=='Ajuste +' || item.type=='Ajuste -'"> <div v-if="item.action=='-'">{{item.qty}}</div> </div>  <div v-if="item.type=='Venta'">{{item.qty}}</div> </th>
         <th>
           {{item.existence}}
         </th>
         <th>$ {{item.cost}}</th>
         <th> <div v-if="item.type=='Compra' || item.type=='Ajuste +'">$ {{item.qty* item.cost}}</div> </th>
         <th> <div v-if="item.type=='Venta' || item.type=='Ajuste -'" >$ {{item.qty* item.cost}}</div> </th>
        <th>$ {{item.saldo}}</th>
      </tr>
   </tbody>
</table>
            </div>
          </div>

        </div>
      </div>
    </div>
  </div>

</template>

<script>
  import Swal from 'sweetalert2'
	import VueNumberInput from '@chenfengyuan/vue-number-input';
  import moment from 'moment'
	export default {
			components: {
				VueNumberInput
			}, 	
			data() {
        return {
            page:1,
            kardex:[],
            filter:{},
            searchResult:[]
        };
			},

			created() {
			},

			methods: {
        search: function(){
          axios.get('/api/kardex/load',{params:this.filter}).then(res=>{
            this.kardex = res.data;
          })
        },
        searchProduct:function(value){
          axios.get('/api/product/search',{params: { 
            value:value,
          }}).then(res=>{
            this.searchResult= res.data;
          })
        }
      }
	};
</script>

<style>

</style>