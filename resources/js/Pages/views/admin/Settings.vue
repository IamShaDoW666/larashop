<template>
<div>
  <Admin :headerStats="true">
        <Head title="Settings"/>
  </Admin>
  </div>
      <div class="flex content-center items-center justify-center mt-48 h-full">
        <div class="w-full lg:w-6/12 px-4">
        <div class="relative flex flex-col min-w-0 break-words w-full mb-6  rounded-lg bg-gray-50 border-0">
      <CardSettings :user="$page.props.auth.user" />
         
    </div> 
    </div>
    </div>
</template>

<script setup>
import CardSettings from "@/Components/Cards/CardSettings.vue";
import Admin from "@/Layouts/Admin.vue";
import { Head } from "@inertiajs/inertia-vue3";
</script>
