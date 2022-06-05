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
import { onMounted, ref } from 'vue';
import Swal from 'sweetalert2';

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
    let audio = new Audio('https://soundbible.com/mp3/Phone%20Ringing-SoundBible.com-1579776269.mp3');
    onMounted(() => {
      showStats.value = props.headerStats;
      console.log(process)
      Echo.private('test')
        .listen('NewOrder', (e) => {
          audio.play();
          const Toast = Swal.mixin({
            toast: true,
            position: 'bottom-end',
            showConfirmButton: false,
            timer: 1500,
            timerProgressBar: true,
            didOpen: (toast) => {
              toast.addEventListener('mouseenter', Swal.stopTimer)
              toast.addEventListener('mouseleave', Swal.resumeTimer)
            }
          })

          Toast.fire({
            icon: 'success',
            title: 'Order ID: #'+e.order.id,
            titleText: 'Customer: '+e.order.customer_name
          })
        })
    });

    return {
      showStats
    }
  }

};
</script>
