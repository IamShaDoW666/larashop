<template>
    <a :href="link" target="_blank">
        <TwitterIcon width="5" height="5" smWidth="8" smHeight="8" />
    </a>
</template>

<script setup>
import TwitterIcon from './Icons/TwitterIcon.vue';
const props = defineProps({
    link: String
})
</script>