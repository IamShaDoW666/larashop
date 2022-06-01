<template>
  <Admin :headerStats="true">
    <Head title="Settings" />
    <div class="flex flex-wrap">
      <div class="w-full lg:w-8/12 px-4">
        <CardSettings :user="$page.props.auth.user"/>

      </div>
      <div class="w-full lg:w-4/12 px-4">
        <CardProfile />
      </div>
    </div>
  </Admin>
</template>
<script setup>
import CardSettings from "@/Components/Cards/CardSettings.vue";
import CardProfile from "@/Components/Cards/CardProfile.vue";
import Admin from "@/Layouts/Admin.vue";
import { Head } from '@inertiajs/inertia-vue3';

</script>
