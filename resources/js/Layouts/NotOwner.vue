<template>
  <div>
    <GuestSidebar />
    <div class="relative md:ml-64">
      <div class="px-4 md:px-10 mx-auto w-full">
        <slot />
        <footer-admin />
      </div>
    </div>
  </div>
</template>
<script setup>
import AdminNavbar from "@/Components/Navbars/AdminNavbar.vue";
import GuestSidebar from "@/Components/Sidebar/GuestSidebar.vue";
import HeaderStats from "@/Components/Headers/HeaderStats.vue";
import FooterAdmin from "@/Components/Footers/FooterAdmin.vue";


</script>
