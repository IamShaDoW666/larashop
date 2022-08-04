<template>
  <Head title="Checkout" />
  <!-- <BreezeAuthenticatedLayout> -->
    <div class="relative" :class="currentTheme">
      <div class="sm:px-6 lg:px-8 py-12 md:flex gap-x-4 dark:bg-primary-dark justify-between">
        <CartList :cart="cart" :areas="areas" :restorant="restorant"/>
        <CustomerForm :restorant="restorant" v-if="cart.items.length" :areas="areas" :cart="cart" class="md:w-2/5 max-w-2xl" />
      </div>
    </div>
<!-- </BreezeAuthenticatedLayout> -->
</template>

<script setup>
import { Head } from '@inertiajs/inertia-vue3';
import { provide } from 'vue';
import { useCart } from '@/Stores/cart';
import CustomerForm from '@/Components/Forms/CustomerForm.vue';
import CartList from '@/Components/CartList.vue';
import { useThemeSwitcher } from "@/Composables/useThemeSwitcher.js";

const { currentTheme } = useThemeSwitcher();

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

