<template>
<div>
<li class="onhover-dropdown">
          <div class="notification-box"><i data-feather="bell"> </i><span class="badge rounded-pill badge-secondary">2</span></div>
          <ul class="notification-dropdown onhover-show-div">
            <li>
              <i data-feather="bell"></i>
              <h6 class="f-18 mb-0">Notificaciones</h6>
            </li>
            <li>
              <p><i class="fa fa-circle-o me-3 font-primary"> </i>Notificación 1<span class="pull-right">10 min.</span></p>
            </li>
            <li>
              <p><i class="fa fa-circle-o me-3 font-success"></i>Notificación 2<span class="pull-right">1 hr</span></p>
            </li>
            <li></li>
          </ul>
        </li>
</div>

</template>

<script>
export default {
  data() {
    return {
      modal_title: "",
      btn_update_active: 0,
      attached: [],
      brands: [],
      brand: {
        title: "",
        image: "",
      },
    }
  },

  created(){
   
  },

  methods: {
    //Métodos de carga de data
    /* loadBrands:function() {
      axios.get('/api/brand/load').then(res=>{
      this.brands = res.data;
      })      
    } */

  }
    
};
</script>