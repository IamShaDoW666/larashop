<template>
  <Admin :headerStats="false" >
    <Head title="Products" />
      <div class="-mt-2 md:mt-0 mx-auto bg-gray-100">
        <div class="w-full mx-auto sm:mt-4 bg-gray-100 rounded-lg px-4 py-12">
            <img class="mx-auto" :src="'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + link" alt="">
        </div>
      </div>
  </Admin>
</template>

<script setup>
import Admin from "@/Layouts/Admin.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";

let link = usePage().props.value.app.url + '/restorants/' + usePage().props.value.auth.restorant.slug;

</script>