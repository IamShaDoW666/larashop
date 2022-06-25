<template>
    <a :href="link" target="_blank">
        <WhatsappIcon width="8" height="8" />
    </a>
</template>

<script setup>
import WhatsappIcon from './Icons/WhatsappIcon.vue';
const props = defineProps({
    phone: String | Number
})

let link = 'https://wa.me/' + props.phone

</script>