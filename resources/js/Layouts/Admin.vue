<template>
  <div>
    <sidebar />
    <div class="relative md:ml-64 bg-blueGray-100">
      <admin-navbar />
      <header-stats v-if="showStats" />
      <div class="px-4 md:px-10 mx-auto w-full" :class="{ '-m-24': showStats }">
        <slot />
      </div>
    </div>
  </div>
</template>
<script>
import AdminNavbar from "@/Components/Navbars/AdminNavbar.vue";
import Sidebar from "@/Components/Sidebar/Sidebar.vue";
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
import { onMounted, reactive, ref } from 'vue';
import Swal from 'sweetalert2';
import { usePage } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";

export default {
  name: "admin-layout",
  components: {
    AdminNavbar,
    Sidebar,
    HeaderStats,
    // FooterAdmin,
  },

  props: {
    headerStats: Boolean
  },

  setup(props) {
    const showStats = ref(true);
    const response = reactive({});
    let audio = new Audio('https://soundbible.com/mp3/Phone%20Ringing-SoundBible.com-1579776269.mp3');
    onMounted(() => {
      showStats.value = props.headerStats;
      console.log(process)
      Echo.private('test.' + usePage().props.value.auth.restorant.user_id)
        .listen('NewOrder', (e) => {
          audio.play();
          if (usePage().component.value == 'Order/Index1') {
            Inertia.reload();
          }
          const Toast = Swal.mixin({            
            toast: true,
            position: 'top-end',
            // iconColor: 'white',
            // customClass: {
            //   popup: 'colored-toast'
            // },
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })

          //Mutate Response
          switch(e.order.order_type) {
            case 1: 
              response.order_type = 'Delivery';
              break;
            case 2:
              response.order_type = 'Pickup';
              break;
            case 3:
              response.order_type = 'Dine-in';
              break;
            default:
              response.order_type = null
          }

          Toast.fire({
            icon: 'success',
            title: 'Success',
          })
        })
    });

    return {
      showStats
    }
  }

};
</script>

<!-- <style scoped>
.colored-toast.swal2-icon-success {
  background-color: #a5dc86 !important;
}

.colored-toast .swal2-title {
  color: white;
}

.colored-toast .swal2-close {
  color: white;
}

.colored-toast .swal2-html-container {
  color: white;
}
</style> -->