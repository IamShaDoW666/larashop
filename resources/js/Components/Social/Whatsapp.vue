<template>
    <a :href="link" target="_blank">
        <WhatsappIcon width="5" height="5" smWidth="8" smHeight="8" />
    </a>
</template>

<script setup>
import WhatsappIcon from './Icons/WhatsappIcon.vue';
const props = defineProps({
    phone: String | Number
})

let link = 'https://wa.me/' + props.phone

</script>