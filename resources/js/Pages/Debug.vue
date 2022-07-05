<template>

    <Head title="Dashboard" />

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">                
                    <button class="butn ml-8 hover:scale-110 transition-all duration-200">Click</button>
                    <div class="loader absolute inset-0"></div>
                </div>
            </div>
        </div>
</template>

<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { reactive } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';


</script>

<style scoped>
.loader {
  border: 16px solid #f3f3f3; /* Light grey */
  border-top: 16px solid #3498db; /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% { transform: rotate(0deg); }
  100% { transform: rotate(360deg); }
}
</style>
