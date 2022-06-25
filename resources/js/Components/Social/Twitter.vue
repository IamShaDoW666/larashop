<template>
    <a :href="link" target="_blank">
        <TwitterIcon width="8" height="8" />
    </a>
</template>

<script setup>
import TwitterIcon from './Icons/TwitterIcon.vue';
const props = defineProps({
    link: String
})
</script>