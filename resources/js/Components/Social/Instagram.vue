<template>
    <a :href="link" target="_blank">
        <InstagramIcon width="8" height="8" />
    </a>
</template>

<script setup>
import InstagramIcon from './Icons/InstagramIcon.vue';
const props = defineProps({
    link: String
})
</script>
