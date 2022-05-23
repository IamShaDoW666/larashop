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
              <input v-model="form.number" type="number">
              <input v-model="form.num" type="number">
            <button @click="submit" class="bg-blue-400 hover:bg-blue-500 px-4 py-2 rounded">Toggle</button>
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

const isOpen = ref(true);
const props = defineProps({
  categories: Object,
  restorant: Object,
  money: Object
})

const form = useForm({
  number: 0,
  num: 0
})

const submit = () => {
  form.post(route('debug.test'))
}

//GSAP animations
const leave = (el) => {
  gsap.to(el, {
    opacity: 0,
    duration: 1,
    y: 50,
  })
}

const enter = (el) => {
  gsap.from(el, {
    opacity: 0,
    duration: 0.7,
    y: 50,
  })
}
</script>
