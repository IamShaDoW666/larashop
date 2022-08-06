<template>
  <div>
    <div class="min-h-screen bg-gray-100 dark:bg-secondary-dark">
      <nav
        id="navBar"
        class="
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
          -mt-20
          top-0
          z-30
          py-4
        "
      >
        <div class="flex items-center">
          <img
            :src="restaurant.logo + '_logo.webp'"
            class="w-12 h-12 rounded-full"
          />
          <h1 class="ml-4 sm:text-lg md:text-xl font-bold">
            {{ restaurant ? restaurant.name : "Restaurant Name" }}
          </h1>
        </div>
        <div class="flex gap-x-4 items-center">
          <LanguageList />
          <ThemeSwitcher />          
        </div>
      </nav>
      <!-- Page Heading / Image -->
      <header class="bg-white shadow">
        <div class="mx-auto h-96">
          <img
            class="opacity-90 object-cover h-96 w-full"
            :src="restaurant.banner + '_large.webp'"
          />
        </div>
      </header>
      <!-- Page Content -->
      <main>
        <slot />
      </main>
      <FooterEnd :restaurant="restaurant" />
    </div>
  </div>
</template>

<script setup>
import { watch } from "vue";
import { useWindowScroll } from "@vueuse/core";
import FooterEnd from "@/Components/Footers/Footer.vue";
import ThemeSwitcher from "@/Components/ThemeSwitcher.vue";
import LanguageList from '@/Components/Dropdowns/LanguageList.vue';


const props = defineProps({
  restaurant: Object,
});

const { x, y } = useWindowScroll();
watch(y, (newValue) => {
  console.log(newValue);
  if (newValue != 0) {
    document
      .getElementById("navBar")
      .classList.add("bg-white", "text-black", "shadow-lg");
    document
      .getElementById("navBar")
      .classList.remove("bg-transparent", "text-white", "shadow-0");
  } else {
    document
      .getElementById("navBar")
      .classList.remove("bg-white", "text-black", "shadow-lg");
    document
      .getElementById("navBar")
      .classList.add("bg-transparent", "text-white", "shadow-lg-0");
  }
});
</script>