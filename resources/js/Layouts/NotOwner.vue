<template>
  <div>
    <GuestSidebar />
    <div class="relative md:ml-64">
      <div class="px-4 md:px-10 mx-auto w-full">
        <slot />
      </div>
    </div>
  </div>
</template>
<script setup>
import GuestSidebar from "@/Components/Sidebar/GuestSidebar.vue";

</script>
