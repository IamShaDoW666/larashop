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
            <div class="mb-4 mx-auto px-4 py-2 rounded-full text-center bg-red-500">
              <div class="radial-progress" :style="val">{{ pbar }}%</div>
            </div>
            <button @click="start = !start" type="button" class="btn btn-circle">
              <span class="material-icons">done_all</span>
            </button>
            <button class="butn bg-blue-300">Button</button>
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
import { Inertia } from '@inertiajs/inertia';
import Swal from 'sweetalert2';

const pbar = ref(0);
const start = ref(false);
const props = defineProps({
  categories: Object,
})

const val = computed(() => {
  return '--value:' + pbar.value
})

setInterval(function () {
  if (!start.value) {
    return ''
  }
  pbar.value++;
  if (pbar.value == 100) {
    start.value = !start.value
    pbar.value = 0
    Swal.fire({
      icon: 'success',
      title: 'Success!'
    })
  }
}, 25)



//GSAP animations

const enter = (el) => {
  gsap.from(el, {
    opacity: 0,
    duration: 0.6,
    ease: 'easeOut',
    y: -50,
  })
}

const leave = (el) => {
  gsap.fromTo(el, {
    opacity: 100,
    y: 0
  }, {
    opacity: 0,
    duration: 0.5,
    y: -50
  })
}
</script>
