<script setup>
import { computed } from 'vue';

const props = defineProps(['type']);

const text = computed(() => {
    switch(props.type) {
        case 1: 
            return 'Delivery'
        case 2:
            return 'Pickup'
        case 3:
            return 'Dine-in'
        default: 
            return null
    }
})

const classes = computed(() => {
    switch(props.type) {
        case 1: 
            return 'bg-gradient-to-r from-green-200 to-green-300 text-green-800'
        case 2:
            return 'bg-gradient-to-r from-indigo-200 to-blue-300 text-indigo-800'
        case 3:
            return 'bg-gradient-to-r from-slate-200 to-slate-300 text-slate-800'
        default:
            return null
    }
})

</script>

<template>
    <span :class="classes" class="text-sm font-medium mr-2 px-2.5 py-0.5 rounded">
        {{ text }}
    </span>
</template>