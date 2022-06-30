<template>
    <div>
        <div class="min-h-screen bg-gray-100">

            <nav id="nav"
                class="bg-transparent text-white transition-all duration-300 px-4 flex items-center sticky -mt-20 top-0 z-30 py-4">
                <img :src="restaurant.logo + '_logo.webp'"
                    class="w-12 h-12 rounded-full">
                <h1 class="ml-4 sm:text-lg md:text-xl font-bold">
                    {{ restaurant ? restaurant.name : 'Restaurant Name'}}
                </h1>
            </nav>

            <!-- Page Heading / Image -->
            <header class="bg-white shadow">
                <div class="mx-auto h-96">
                    <img class="opacity-90 object-cover h-96 w-full"
                        :src="restaurant.banner + '_large.jpg'">
                </div>
            </header>

            <!-- Page Content -->
            <main>
                <slot ref="child" />
            </main>
        </div>
    </div>
</template>

<script setup>
import { watch } from 'vue';
import { useWindowScroll } from '@vueuse/core'
const { x, y } = useWindowScroll();

const props = defineProps({
    restaurant: Object
})

watch(y, (newValue) => {
    if (newValue != 0) {
        document.getElementById('nav').classList.add('bg-white', 'text-black', 'shadow-lg');
        document.getElementById('nav').classList.remove('bg-transparent', 'text-white', 'shadow-0');
    } else {
        document.getElementById('nav').classList.remove('bg-white', 'text-black', 'shadow-lg');
        document.getElementById('nav').classList.add('bg-transparent', 'text-white', 'shadow-lg-0');

    }
})

</script>