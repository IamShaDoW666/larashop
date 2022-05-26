<template>
  <Head title="Checkout" />
  <BreezeAuthenticatedLayout>
    <div class="py-12">
      <div class="sm:px-6 lg:px-8">
        <CartList :cart="cart" :areas="areas"/>
      </div>
    </div>
</BreezeAuthenticatedLayout>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { onMounted, provide } from 'vue';
import { useCart } from '@/Stores/cart';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import CartList from '@/Components/CartList.vue';

const props = defineProps({
  restorant: Object,
  items: Object,
  subtotal: String,
  order_type: String,
  areas: Object,
});

provide('restorant', {
  restorant: props.restorant
})

const cart = useCart();


</script>
