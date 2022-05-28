<script setup>
import { computed } from 'vue';

const props = defineProps(['status', 'reject']);

const text = computed(() => {

    if (props.reject) {
        return "Reject"
    }

    switch(props.status) {
        case 'pending': 
            return 'Accept'
        case 'accepted':
            return 'Prepared'
        case 'prepared':
            return 'Delivered'
        case 'delivered':
            return 'Close'
        default: 
            return null
    }
})

const classes = computed(() => {

    if (props.reject) {
        return 'bg-red-500 border-red-500 hover:bg-red-700'
    }

    switch(props.status) {
        case 'pending': 
            return 'bg-blue-500 border-blue-500 hover:bg-blue-700'
        case 'accepted':
            return 'bg-yellow-500 border-yellow-500 hover:bg-yellow-700'
        case 'prepared':
            return 'bg-green-500 border-green-500 hover:bg-green-700'
        case 'delivered':
            return 'bg-blue-600 border-blue-500 hover:bg-blue-700'
        default:
            return null
    }
})

</script>

<template>
    <button v-if="text" :class="classes" class="px-4 py-2 text-white font-bold border rounded-lg shadow">
        {{ text }}
    </button>
    <span v-else>No actions for this order...</span>
</template>