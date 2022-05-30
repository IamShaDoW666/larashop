<template>
  <Head title="Checkout" />
  <BreezeAuthenticatedLayout>
    <div class="py-12">
      <div class="sm:px-6 lg:px-8 md:flex gap-x-4 justify-between">
        <CartList :cart="cart" :areas="areas" :restorant="restorant"/>
        <CustomerForm :restorant="restorant" v-if="cart.items.length > 0" :areas="areas" :cart="cart" class="md:w-2/5 max-w-2xl" />
      </div>
    </div>
</BreezeAuthenticatedLayout>
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import { provide } from 'vue';
import { useCart } from '@/Stores/cart';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import CustomerForm from '@/Components/Forms/CustomerForm.vue';
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
