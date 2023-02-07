<template>
  <NotOwner>
    <Head title="Register" />
    <div class="w-full px-4">
      <Registergrocery />
    </div>
  </NotOwner>
</template>

<script setup>
import NotOwner from "@/Layouts/NotOwner.vue";
import Registergrocery from "@/Components/grocery/Create.vue";
import { Head} from '@inertiajs/inertia-vue3';

</script>
