<template>
 <div class="container-fluid">
   <div class="row">
      <div class="col-sm-6 col-xl-4 col-lg-6">
         <div class="card o-hidden">
            <div class="bg-secondary b-r-4 card-body">
               <div class="media static-top-widget">
                  <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-repeat"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>
                  </div>
                  <div class="media-body">
                     <span class="m-0">Tasa de Abastecimiento</span>
                     <h4 class="mb-0 counter">{{ dash.tap }}%</h4>
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-repeat icon-bg"><polyline points="17 1 21 5 17 9"></polyline><path d="M3 11V9a4 4 0 0 1 4-4h14"></path><polyline points="7 23 3 19 7 15"></polyline><path d="M21 13v2a4 4 0 0 1-4 4H3"></path></svg>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-sm-6 col-xl-4 col-lg-6">
         <div class="card o-hidden">
            <div class="bg-secondary b-r-4 card-body">
               <div class="media static-top-widget">
                  <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-cw"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                  </div>
                  <div class="media-body">
                     <span class="m-0">Índice de Rotación</span>
                     <h4 class="mb-0 counter">{{ dash.irs }}</h4>
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-rotate-cw icon-bg"><polyline points="23 4 23 10 17 10"></polyline><path d="M20.49 15a9 9 0 1 1-2.12-9.36L23 10"></path></svg>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-sm-6 col-xl-4 col-lg-6">
         <div class="card o-hidden">
            <div class="bg-secondary b-r-4 card-body">
               <div class="media static-top-widget">
                  <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                  </div>
                  <div class="media-body">
                     <span class="m-0">Ganancias</span>
                     <h4 class="mb-0 counter">${{ dash.ganancias }}</h4>
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-database icon-bg"><ellipse cx="12" cy="5" rx="9" ry="3"></ellipse><path d="M21 12c0 1.66-4 3-9 3s-9-1.34-9-3"></path><path d="M3 5v14c0 1.66 4 3 9 3s9-1.34 9-3V5"></path></svg>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-sm-6 col-xl-4 col-lg-6">
         <div class="card o-hidden">
            <div class="bg-primary b-r-4 card-body">
               <div class="media static-top-widget">
                  <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg></div>
                  <div class="media-body">
                     <span class="m-0">Ventas</span>
                     <h4 class="mb-0 counter">{{ dash.ventas }}</h4>
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-cart icon-bg"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                  </div>
               </div>
            </div>
         </div>
      </div>      
      <div class="col-sm-6 col-xl-4 col-lg-6">
         <div class="card o-hidden">
            <div class="bg-primary b-r-4 card-body">
               <div class="media static-top-widget">
                  <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                  </div>
                  <div class="media-body">
                     <span class="m-0">Productos</span>
                     <h4 class="mb-0 counter">{{ dash.productos }}</h4>
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-shopping-bag icon-bg"><path d="M6 2L3 6v14a2 2 0 0 0 2 2h14a2 2 0 0 0 2-2V6l-3-4z"></path><line x1="3" y1="6" x2="21" y2="6"></line><path d="M16 10a4 4 0 0 1-8 0"></path></svg>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-sm-6 col-xl-4 col-lg-6">
         <div class="card o-hidden">
            <div class="bg-primary b-r-4 card-body">
               <div class="media static-top-widget">
                  <div class="align-self-center text-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg></div>
                  <div class="media-body">
                     <span class="m-0">Clientes</span>
                     <h4 class="mb-0 counter">{{ dash.clientes }}</h4>
                     <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-user-plus icon-bg"><path d="M16 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="8.5" cy="7" r="4"></circle><line x1="20" y1="8" x2="20" y2="14"></line><line x1="23" y1="11" x2="17" y2="11"></line></svg>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-6 xl-100 box-col-12">
         <div class="widget-joins card widget-arrow">
            <div class="row">
               <div class="col-sm-6 pe-0">
                  <div class="media border-after-xs">
                     <div class="align-self-center me-3 text-start">
                        <h6 class="mb-1">Venta</h6>
                        <h4 class="mb-0">Hoy</h4>
                     </div>
                     <div class="media-body align-self-center"><i class="font-primary" data-feather="arrow-down"></i></div>
                     <div class="media-body">
                        <h5 class="mb-0">$<span class="counter">{{ dash.vhoy }}</span></h5>
                        <!-- <span class="mb-1">-$2658(36%)</span> -->
                     </div>
                  </div>
               </div>
               <div class="col-sm-6 ps-0">
                  <div class="media">
                     <div class="align-self-center me-3 text-start">
                        <h6 class="mb-1">Venta</h6>
                        <h4 class="mb-0">Mensual</h4>
                     </div>
                     <div class="media-body align-self-center"><i class="font-primary" data-feather="arrow-up"></i></div>
                     <div class="media-body ps-2">
                        <h5 class="mb-0">$<span class="counter">{{ dash.vmes }}</span></h5>
                        <!-- <span class="mb-1">+$369(15%)</span> -->
                     </div>
                  </div>
               </div>
               <div class="col-sm-6 pe-0">
                  <div class="media border-after-xs">
                     <div class="align-self-center me-3 text-start">
                        <h6 class="mb-1">Venta</h6>
                        <h4 class="mb-0">Semanal</h4>
                     </div>
                     <div class="media-body align-self-center"><i class="font-primary" data-feather="arrow-up"></i></div>
                     <div class="media-body">
                        <h5 class="mb-0">$<span class="counter">{{ dash.vsemana }}</span></h5>
                        <!-- <span class="mb-1">+$69(65%)</span> -->
                     </div>
                  </div>
               </div>
               <div class="col-sm-6 ps-0">
                  <div class="media">
                     <div class="align-self-center me-3 text-start">
                        <h6 class="mb-1">Venta</h6>
                        <h4 class="mb-0">Anual</h4>
                     </div>
                     <div class="media-body align-self-center ps-3"><i class="font-primary" data-feather="arrow-up"></i></div>
                     <div class="media-body ps-2">
                        <h5 class="mb-0">$<span class="counter">{{ dash.vanual }}</span></h5>
                        <!-- <span class="mb-1">+$3654(90%)          </span> -->
                     </div>
                  </div>
               </div>
            </div>
         </div>
      </div>
      <div class="col-xl-6 xl-100 box-col-12">
         <div class="widget-joins card">
            <div class="row">
               <div class="col-sm-6 pe-0">
                  <div class="media border-after-xs">
                     <!-- <div class="align-self-center me-3">68%<i class="fa fa-angle-up ms-2"></i></div> -->
                     <div class="media-body details ps-3">
                        <span class="mb-1">Nuevo</span>
                        <h4 class="mb-0 counter">{{ dash.nsemana }}</h4>
                     </div>
                     <div class="media-body align-self-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-plus-circle font-primary float-end ms-2"><circle cx="12" cy="12" r="10"></circle><line x1="12" y1="8" x2="12" y2="16"></line><line x1="8" y1="12" x2="16" y2="12"></line></svg></div>
                  </div>
               </div>
               <div class="col-sm-6 ps-0">
                  <div class="media">
                     <!-- <div class="align-self-center me-3">12%<i class="fa fa-angle-down ms-2"></i></div> -->
                     <div class="media-body details ps-3">
                        <span class="mb-1">Pendiente</span>
                        <h4 class="mb-0 counter">{{ dash.npendientes }}</h4>
                     </div>
                     <div class="media-body align-self-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-clock font-primary float-end ms-2"><circle cx="12" cy="12" r="10"></circle><polyline points="12 6 12 12 16 14"></polyline></svg></div>
                  </div>
               </div>
               <div class="col-sm-6 pe-0">
                  <div class="media border-after-xs">
                     <!-- <div class="align-self-center me-3">68%<i class="fa fa-angle-up ms-2"></i></div> -->
                     <div class="media-body details ps-3 pt-0">
                        <span class="mb-1">Finalizado</span>
                        <h4 class="mb-0 counter">{{ dash.nfinalizados }}</h4>
                     </div>
                     <div class="media-body align-self-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-send font-primary float-end ms-2"><line x1="22" y1="2" x2="11" y2="13"></line><polygon points="22 2 15 22 11 13 2 9 22 2"></polygon></svg></div>
                  </div>
               </div>
               <div class="col-sm-6 ps-0">
                  <div class="media">
                     <!-- <div class="align-self-center me-3">68%<i class="fa fa-angle-up ms-2"></i></div> -->
                     <div class="media-body details ps-3 pt-0">
                        <span class="mb-1">Cancelado</span>
                        <h4 class="mb-0 counter">{{ dash.ncancelados }}</h4>
                     </div>
                     <div class="media-body align-self-center"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="feather feather-x-circle font-primary float-end ms-3"><circle cx="12" cy="12" r="10"></circle><line x1="15" y1="9" x2="9" y2="15"></line><line x1="9" y1="9" x2="15" y2="15"></line></svg></div>
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
         dash: []
      }
   },

   created() {
      this.loadDashboard()
   },

   methods: {
      loadDashboard: function(){
         axios.get('/api/dashboard/load').then(res=>{
            this.dash = res.data
            console.log(this.dash)
         }) 
      },
   }
}
</script>

<style>

</style>