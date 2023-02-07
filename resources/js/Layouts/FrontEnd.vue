<template>
<div class="min-h-screen bg-gray-100 dark:bg-secondary-dark">
<nav id="navBar" class="
          bg-transparent
          text-white
          transition-all
          duration-300
          bg-green-400
          dark:bg-primary-dark
          px-4
          flex
          justify-between
          items-center
          sticky          
          top-0
          z-30
          py-4
        ">
<div class="flex items-center">
        <img :src="getImagePath(store.logo, 'logo')" class="w-12 h-12 rounded-full" />
        <h1 class="ml-4 sm:text-lg md:text-xl font-bold">
          {{ store ? store.name : "store Name" }}
        </h1>
      </div>
      <div class="flex gap-x-4 items-center">
        <LanguageList />
        <ThemeSwitcher />
      </div>
    </nav>
    <!-- Page Heading / Image -->
    <header class="">
    <div class="container-xxl py-5 bg-gray-900 hero-header mb-5">
    <div class="container mx-auto sm:px-4 my-5 py-5">
    <div class="flex flex-wrap  items-center g-5">
    <div class="lg:w-1/2 pr-4 pl-4 text-left   text-lg-start">
    <h1 class="text-white text-4xl font-extrabold leading-12 animated slideInLeft">Enjoy Our<br>Delicious Meal</h1>
    <p class="text-white animated slideInLeft mb-4 pb-2">Tempor erat elitr rebum at clita. Diam dolor diam ipsum
    Aliqu diam amet diam et eos. Clita erat ipsum et lorem et sit, sed stet lorem sit clita duo justo magna dolore erat</p>
    <a href="" class="btn btn-primary py-sm-3 px-sm-5 me-3 animated slideInLeft">Register</a>
</div>
<div class="lg:w-1/2 pr-4 pl-4 text-center text-4xl font-extrabold text-lg-end overflow-hidden">
<img class="animate-wiggle w-10/12 ml-12" :src="getImagePath(store.banner, 'large')" alt="">
</div>
</div>
</div>
</div>
</header>
    <!-- Page Content -->
<main>
<slot />
</main>
<FooterEnd :store="store" />
</div>
</template>

<script setup>
import { watch, ref } from "vue";
import FooterEnd from "@/Components/Footers/Footer.vue";
import ThemeSwitcher from "@/Components/ThemeSwitcher.vue";
import LanguageList from '@/Components/Dropdowns/LanguageList.vue';
import useCommon from '@/utils/common';
const { getImagePath } = useCommon()
const props = defineProps({
  store: Object,
});
</script>
