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
            <form @submit.prevent="submit">
              <input type="file" @input="form.product_image = $event.target.files[0]">
              <button type="submit" class='px-4 py-2 text-white font-bold rounded hover:bg-blue-500 shadow bg-blue-600'>
                Upload
              </button>
              <img src="/storage/imgs/product/default.png" alt="product_image">
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
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';

const form = useForm({
  product_image: ''
})

const submit = () => {
  form.post('/debug/upload', {
    onSuccess: () => {
      alert('Uploaded')
    }
  });
}

</script>
