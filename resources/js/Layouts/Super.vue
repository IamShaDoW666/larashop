<template>
    <div>
        <SidebarSuper />
        <div class="relative md:ml-64 bg-blueGray-100">
            <SuperNavbar />
            <slot />
        </div>
    </div>
</template>

<script setup>
import SuperNavbar from "@/Components/Navbars/SuperNavbar.vue";
import SidebarSuper from "@/Components/Sidebar/SidebarSuper.vue";
</script>
