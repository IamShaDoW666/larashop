<template>
  <Admin>
    <Head title="store" />
    <div class="w-full px-4">
      <grocery :confs="confs" />
    </div>
  </Admin>
</template>

<script setup>
import grocery from "@/Components/grocery/Index.vue";
import CardProfile from "@/Components/Cards/CardProfile.vue";
import Admin from "@/Layouts/Admin.vue";
import { Head, Link } from '@inertiajs/inertia-vue3';

const props = defineProps({
  confs: Object
})
</script>
