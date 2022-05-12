<template>
  <NotOwner>
    <Head title="Dashboard" />
    <AdminNavbar />
    <div>
      <div class="flex flex-wrap">
        <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
        </div>
        <div class="w-full xl:w-4/12 px-4">
        </div>
      </div>
      <div class="flex flex-wrap mt-4">
        <div class="w-full xl:w-8/12 mb-12 xl:mb-0 px-4">
        </div>
        <div class="w-full xl:w-4/12 px-4">
        </div>
      </div>
    </div>
  </NotOwner>
</template>
<script setup>
import { Head, Link} from '@inertiajs/inertia-vue3';
import NotOwner from "@/Layouts/NotOwner.vue";
import AdminNavbar from "@/Components/Navbars/AdminNavbar.vue";


</script>
