<template>
  <div>
    <sidebar />
    <div class="relative md:ml-64 bg-blueGray-100">
      <admin-navbar />
      <header-stats v-if="showStats"/>
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

    onMounted(() => showStats.value = props.headerStats);

    return{
      showStats
    }
  }

};
</script>
