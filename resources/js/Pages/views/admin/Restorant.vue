<template>
  <Admin>
    <Head title="Restaurant" />
    <div class="w-full px-4">
      <Restorant :confs="confs" />
    </div>
  </Admin>
</template>

<script setup>
import Restorant from "@/Components/Restorant/Index.vue";
import CardProfile from "@/Components/Cards/CardProfile.vue";
import Admin from "@/Layouts/Admin.vue";
import { Head, Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
  confs: Object
})
</script>
