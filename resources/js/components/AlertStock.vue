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
                                <!-- <div class="media-body text-end">
                                </div> -->
                            </div>
                        </div>
                    </div>
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
                                <tr v-for="item in products.data" :key="item.id">
                                    <td><img width="50" :src="'images/product/'+item.image.split(',')[0]" alt=""></td>
                                    <td>{{item.name}}</td>
                                    <td>{{item.code}}</td>
                                    <td>{{item.qty}}</td>
                                    <td>{{item.alert_quantity}}</td>
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
export default {
    data() {
        return {
            products: []
        };
    },

    created() {
        this.loadProduct()
    },

    methods: {
        loadProduct: function() {
             axios.get('/api/alertstock/load').then(res=>{
             	this.products = res.data;
             })
        }
    }
};
</script>
