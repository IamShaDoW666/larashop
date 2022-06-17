<template>
    <div>
        <div class="min-h-screen bg-gray-100">
            <nav id="nav" class="bg-transparent text-white transition-all duration-300 px-4 flex items-center sticky -mt-20 top-0 z-30 py-4">
                <img src="https://foodypoint.in/wp-content/uploads/2019/04/Anil-Restaurant-Banner-New.png"
                    class="w-10 h-10 rounded-full">
                <h1 class="ml-2 sm:text-lg md:text-xl font-bold">Restaurant Name</h1>
            </nav>


            <!-- Page Heading / Image -->
            <header class="bg-white shadow">
                <div class="mx-auto h-96">
                    <img class="opacity-90 object-cover h-96 w-full"
                        src="https://foodypoint.in/wp-content/uploads/2019/04/Anil-Restaurant-Banner-New.png">
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
import banner from "@/assets/img/restaurant.jpg";
import { watch } from 'vue';
import { useWindowScroll } from '@vueuse/core'
const { x, y } = useWindowScroll();

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