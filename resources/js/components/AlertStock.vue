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
                            <input class="form-control" type="text" v-model="buscador" @keyup="buscarAlerta" placeholder="Nombre o código de producto...">
                            </div>
                        </div>
                      </div>

                    </div>
                    
                    <div class="card-body" style="padding: 20px 40px !important">
                        <div class="table-responsive style-1 table-hover non-hover m-b-30">
                            <table class="table table-bordered">
                                <thead>
                                    <tr>
                                        <th scope="col">Imagen</th>
                                        <th scope="col">Producto</th>
                                        <th scope="col">Código</th>
                                        <th scope="col">Stock</th>
                                        <th scope="col">Stock de Alerta</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr style="vertical-align: middle" v-for="item in products.data" :key="item.id">
                                        <td>
                                            <img v-if="item.image.split(',')[0].indexOf('https')>-1" width="50" :src="item.image.split(',')[0]" alt="">
                                            <img v-else width="50" :src="item.image.split(',')[0]" alt="">
                                        </td>
                                        <td>{{item.name}}</td>
                                        <td>{{item.code}}</td>
                                        <td>{{item.qty}}</td>
                                        <td>{{item.alert_quantity}}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="row mt-4 align-items-center">
                            <div class="col-md-6">
                            <p class="card-text">Mostrando de {{(products.from)}} a {{(products.to)}} de {{products.total}} registros.</p>
                            </div>
                            <div class="col-md-6">
                            <nav>
                                <ul class="pagination justify-content-end pagination-primary">
                                <li :class="(products.current_page==1)?'page-item disabled':'page-item'">
                                    <a @click.prevent="loadProduct(products.current_page-1)" class="page-link" href="#" tabindex="-1" data-bs-original-title="" title="">Anterior</a>
                                </li>
                                <li v-if="products.current_page>1" class="page-item">
                                    <a @click.prevent="loadProduct(products.current_page-1)" class="page-link" href="#" data-bs-original-title="" title="">{{products.current_page-1}}</a>
                                </li>
                                <li class="page-item active">
                                    <a class="page-link" href="#" data-bs-original-title="" title="">{{products.current_page}}<span class="sr-only">(current)</span></a>
                                </li>
                                <li v-if="products.current_page!=products.last_page" class="page-item">
                                    <a @click.prevent="loadProduct(products.current_page+1)" class="page-link" href="#" data-bs-original-title="" title="">{{products.current_page+1}}</a>
                                </li>
                                <li :class="(products.current_page==products.last_page)?'page-item disabled':'page-item'">
                                    <a @click.prevent="loadProduct(products.current_page+1)" class="page-link" href="#" data-bs-original-title="" title="">Siguiente</a>
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
export default {
  data() {
      return {
          page:1,
          buscador: "",
          products: []
      };
  },

  created() {
      this.loadProduct(this.page)
  },

  methods: {
    loadProduct: function(page) {
        this.page = page
        axios.get('/api/alertstock/load?page='+this.page,{
          params: {
            buscador: this.buscador
          }
        }).then(res=>{
          this.products = res.data;
        })
    },

    buscarAlerta(){
      clearTimeout(this.setTimeoutBuscador)
      this.setTimeoutBuscador = setTimeout(this.loadProduct, 360)
    },           
  }
};
</script>
