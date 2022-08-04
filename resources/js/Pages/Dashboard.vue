<script setup>
import { Head, Link } from '@inertiajs/inertia-vue3';
import FrontEnd from '@/Layouts/FrontEnd.vue';
const props = defineProps({
  restaurant: Object
})

</script>

<template>
    <Head title="Dashboard" />
    <FrontEnd :restaurant="restaurant">
      <div class="py-12 bg-red-500">
          <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
              <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                  hello
              </div>
          </div>
      </div>
    </FrontEnd>
</template>
