<template>
  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="flex justify-between">
        <Link :href="route('lang', { locale: 'en' })" class="px-2 py-1 rounded shadow bg-blue-400">Change to English
        </Link>
        <Link :href="route('lang', { locale: 'ar' })" class="px-2 py-1 rounded shadow bg-blue-400">Change to Arabic
        </Link>
        <Link :href="route('lang', { locale: 'fr' })" class="px-2 py-1 rounded shadow bg-blue-400">Change to French
        </Link>
      </div>
      <div class="py-12 w-32">
        <LanguageList />
      </div>
      <div class="grid grid-cols-3 gap-4 mt-12">
        <h1>{{ __('Cart Empty') }}</h1>
        <h1>{{ __('All Category') }}</h1>
      </div>
    </div>
  </div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';
import LanguageList from '../Components/Dropdowns/LanguageList.vue';



</script>
