<template>
  <NotOwner>
    <Head title="Register" />
    <div class="w-full px-4">
      <RegisterRestorant />
    </div>
  </NotOwner>
</template>

<script setup>
import NotOwner from "@/Layouts/NotOwner.vue";
import RegisterRestorant from "@/Components/Restorant/Create.vue";
import { Head} from '@inertiajs/inertia-vue3';

</script>
