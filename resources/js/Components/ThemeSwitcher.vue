<script setup>
import { useThemeSwitcher } from '@/Composables/useThemeSwitcher'
const { toggleTheme, currentTheme } = useThemeSwitcher()
</script>

<template>
  <a href="#" @click.prevent="toggleTheme()" aria-label="Theme Switcher">
    <i      
    v-if="currentTheme == 'light'"
      class="
        text-black
        material-icons
        hover:text-gray-400
        dark:text-white dark:hover:text-liBorder-primary-light
        w-5
      "
      >dark_mode</i
    >

    <i      
    v-else
      class="
        text-black
        material-icons
        hover:text-gray-400
        dark:text-white dark:hover:text-liBorder-primary-light
        w-5
      "
      >light_mode</i
    >
  </a>
</template>