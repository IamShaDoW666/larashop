<script setup>
import { computed } from 'vue';
import { Link } from '@inertiajs/inertia-vue3';

const props = defineProps(['href', 'active']);

const classes = computed(() => props.active
    ? 'inline-flex items-center px-4 py-2 bg-white text-black border border-black hover:text-white border border-transparent rounded-md font-bold text-xs uppercase tracking-widest hover:bg-gray-900 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150'
    : 'inline-flex items-center px-4 py-2 bg-gray-800 border border-transparent rounded-md font-bold text-xs text-black hover:text-white uppercase tracking-widest hover:bg-gray-700 active:bg-gray-900 focus:outline-none focus:border-gray-900 focus:shadow-outline-gray transition ease-in-out duration-150'
);

</script>

<template>
    <Link :href="href" :class="classes">
        <slot />
    </Link>
</template>
