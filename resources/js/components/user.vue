<template>
    <div class="container-fluid">
            <div class="row">
              
              
              
              <div class="col-sm-12">
                <div class="card">
                  <div class="card-header">
                    <button class="btn btn-success " type="button" data-bs-toggle="tooltip" title="" data-bs-original-title="btn btn-success" data-original-title="btn btn-success">Registrar Usuarios</button>
                  </div>
                  <div class="table-responsive">
                    <table class="table table-sm">
                      <thead>
                        <tr>
                          <th scope="col">#</th>
                          <th scope="col">Nombres</th>
                          <th scope="col">Apellidos</th>
                          <th scope="col">Email</th><th scope="col">Teléfono</th><th scope="col">Estado</th><th scope="col">Acciones</th>
                        </tr>
                      </thead>
                      <tbody>
                        <tr>
                          <th scope="row">1</th>
                          <td>Mark</td>
                          <td>Otto</td>
                          <td>@mdo</td><td>95585456</td><td>activo</td><td>accs</td>
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
        mounted() {
            console.log('Component mounted.')
        }
    }
</script>
