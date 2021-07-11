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
                  <input class="form-control" type="text" placeholder="Nombre o código...">
                </div>
              </div>

              <div class="col-md-3 col-sm-6">
                <label for="">Desde:</label>
								<input class="form-control digits form-control-sm" type="date" value="" data-bs-original-title="" title="">
              </div>

              <div class="col-md-3 col-sm-6">
                <label for="">Hasta:</label>
								<input class="form-control digits form-control-sm" type="date" value="" data-bs-original-title="" title=""> 
              </div>
            </div> 

          </div>

          <div class="card-body" style="padding: 20px 40px !important">
            <div class="table-responsive style-1 table-hover non-hover">
              <table class="table table-bordered">
                <thead>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th colspan="2" class="text-center bg-primary">Entradas</th>
                    <th colspan="2" class="text-center bg-primary">Salidas</th>
                    <th colspan="2" class="text-center bg-primary">Saldo</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <th>Fecha</th>
                    <th>Producto</th>
                    <th>Detalle</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                    <th>Cantidad</th>
                    <th>Total</th>
                  </tr>
                  <tr>
                    <th></th>
                    <th></th>
                    <th></th>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>                   
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
export default {

}
</script>

<style>

</style>