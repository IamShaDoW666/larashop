<template>

  <Head title="Debug" />
  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Debug
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <form>
              <button class="px-4 py-2 bg-blue-500 rounded hover:bg-blue-600" @click="submit" >Click Me</button>
            </form>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script setup>
import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
import { onMounted, ref, reactive, watch, computed } from 'vue';
import { gsap } from 'gsap';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import {
  Dialog,
  DialogPanel,
  DialogTitle,
  TransitionRoot,
  TransitionChild,
  DialogDescription,
} from '@headlessui/vue';
import { Inertia } from '@inertiajs/inertia';

const isOpen = ref(true);
const props = defineProps({
  categories: Object,
})

const submit = () => {
  Inertia.post('/new');
}

//GSAP animations

const enter = (el) => {
  gsap.from(el, {
    opacity: 0,
    duration: 0.6,
    ease: 'easeOut',
    y: 50,
  })
}
</script>
