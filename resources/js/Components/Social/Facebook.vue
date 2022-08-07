<template>
    <a target="_blank" :href="link">
        <FacebookIcon width="5" height="5" smWidth="8" smHeight="8" />        
    </a>
</template>

<script setup>
import FacebookIcon from '@/Components/Social/Icons/FacebookIcon.vue';

const prop = defineProps({
    link: String
})
</script>
