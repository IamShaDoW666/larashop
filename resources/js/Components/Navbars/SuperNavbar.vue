<template>
    <!-- Navbar -->
    <nav
      class="bg-gray-100 md:shadow-lg top-0 left-0 w-full z-10 bg-transparent md:flex-row flex-nowrap flex items-center p-4 pb-7"
    >
      <div
        class="w-full mx-auto items-center flex justify-between md:flex-nowrap flex-wrap md:px-10 px-4"
      >
        <!-- Brand -->
        <Link :href="route('super.dashboard')"
          class="text-black text-sm uppercase hidden lg:inline-block font-semibold"
        >
          {{ __('Dashboard') }}
        </Link>      
        <!-- User -->
        <ul class="flex-col md:flex-row list-none items-center hidden md:flex">
          <user-dropdown />
        </ul>
      </div>
    </nav>
    <!-- End Navbar -->
  </template>
  
  <script setup>
  import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
  import { Link } from '@inertiajs/inertia-vue3';
  
  </script>
  