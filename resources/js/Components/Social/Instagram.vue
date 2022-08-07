<template>
    <a :href="link" target="_blank">
        <InstagramIcon width="5" height="5" smWidth="8" smHeight="8" />
    </a>
</template>

<script setup>
import InstagramIcon from './Icons/InstagramIcon.vue';
const props = defineProps({
    link: String
})
</script>
