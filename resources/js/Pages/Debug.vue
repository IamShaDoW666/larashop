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
        <div class="bg-white overflow-visible shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <MazPhoneNumberInput no-example class="w-1/2" v-model="phoneNumber" show-code-on-list color="info"
              :preferred-countries="['FR', 'IN', 'BE', 'DE', 'US', 'GB']" :ignored-countries="['AC']"
              @update="results = $event" :success="results?.isValid" />
            <p>{{ results }}</p>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script setup>
import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { GooglePlayButton } from 'vue-google-pay';
import MazPhoneNumberInput from 'maz-ui/components/MazPhoneNumberInput'
import GooglePay from '@/Components/GooglePay.vue';
import { ref } from 'vue'

const phoneNumber = ref()
const results = ref()

</script>
