<template>
    <a target="_blank" :href="link">
        <FacebookIcon width="8" height="8" />        
    </a>
</template>

<script setup>
import FacebookIcon from '@/Components/Social/Icons/FacebookIcon.vue';

const prop = defineProps({
    link: String
})
</script>
