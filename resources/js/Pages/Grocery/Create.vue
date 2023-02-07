<template>
  <NotOwner>
    <Head title="store" />
    <div class="w-full px-4">
      <Creategrocery />
    </div>
  </NotOwner>
</template>

<script setup>
import Creategrocery from "@/Components/grocery/Create.vue";
import { Head, Link } from '@inertiajs/inertia-vue3';

</script>
