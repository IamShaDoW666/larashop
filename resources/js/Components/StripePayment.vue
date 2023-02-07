<template>

<button @click="stripe" :disabled="!form.checked || form.processing || loading" :class="{
            'opacity-25 hover:bg-green-600':
                !form.checked || form.processing || loading,
        }"
            class="flex items-center dark:text-black justify-center h-12 px-6 w-64 bg-green-600 dark:bg-golden-yellow mt-8 rounded font-semibold text-sm text-green-100 hover:bg-green-700">
            Pay with Stripe
        </button>

</template>
<script setup>
const props = defineProps({
form:Object,
form.checked:Object

})

</script>






