<template>

    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <p>{{ center }}</p>
                    <!-- <div class="p-6 bg-white border-b border-gray-200">
                       <div class="grid grid-cols-2 gap-2 text-center">
                        <h1 class="p-4 bg-blue-300">1</h1>
                        <h1 class="p-4 bg-blue-300">2</h1>
                        <h1 class="p-4 bg-blue-300">3</h1>
                        <h1 class="p-4 bg-blue-300">4</h1>
                       </div>
                    </div> -->
                    <button class="butn ml-8 hover:scale-110 transition-all duration-200">Click</button>

                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>

<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { reactive } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';


</script>
