<template>
  <NotOwner>
    <Head title="Restaurant" />
    <div class="w-full px-4">
      <CreateRestorant />
    </div>
  </NotOwner>
</template>

<script setup>
import CreateRestorant from "@/Components/Restorant/Create.vue";
import CardProfile from "@/Components/Cards/CardProfile.vue";
import Admin from "@/Layouts/Admin.vue";
import { Head, Link } from '@inertiajs/inertia-vue3';

</script>
