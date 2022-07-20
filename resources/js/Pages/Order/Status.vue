<template>
    <div class="py-12 max-w-4xl bg-blue-400 mx-auto">
        <div class="flex gap-x-2 px-4">
            <ul>
                <li>Name: </li>
                <li>Phone: </li>
                <li v-if="order.order_type == 1">Address: </li>
                <li>Status: </li>
                <li>Total: </li>
            </ul>
            <ul>
                <li>{{ order.customer_name }}</li>
                <li>{{ order.customer_phone }}</li>
                <li>{{ order.address }}</li>
                <li>{{ order.status }}</li>
                <li>{{ order.total }}</li>
            </ul>
        </div>        
    </div>
</template>

<script setup>
const props = defineProps({
    order: Object
})
</script>