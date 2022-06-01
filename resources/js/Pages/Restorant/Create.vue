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
import { Head, Link } from '@inertiajs/inertia-vue3';

</script>
