<script setup>
import { computed } from 'vue';

const props = defineProps(['status']);

const text = computed(() => {
    switch(props.status) {
        case 'pending': 
            return 'Pending'
        case 'accepted':
            return 'Accepted'
        case 'prepared':
            return 'Prepared'
        case 'delivered':
            return 'Delivered'
        case 'closed':
            return 'Closed'
        case 'rejected':
            return 'Rejected'
        default: 
            return null
    }
})

const classes = computed(() => {
    switch(props.status) {
        case 'pending': 
            return 'bg-gradient-to-r from-yellow-200 to-yellow-300 text-yellow-800'
        case 'accepted':
            return 'bg-gradient-to-r from-indigo-200 to-blue-300 text-indigo-800'
        case 'prepared':
            return 'bg-gradient-to-r from-green-200 to-green-300 text-green-800'
        case 'delivered':
            return 'bg-gradient-to-r from-green-300 to-green-400 text-green-800'
        case 'rejected':
            return 'bg-gradient-to-r from-red-200 to-red-300 text-red-800'
        case 'closed':
            return 'bg-blue-300 text-blue-800'
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