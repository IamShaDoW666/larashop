<template>
  <div class="container flex flex-col w-full md:w-3/5" >
    <div class="px-4 py-5 sm:px-6 w-full flex justify-between border bg-green-500 dark:bg-golden-yellow bg-white shadow mb-2 sm:rounded-md">
      <div>
        <h3 class="text-lg leading-6 font-medium text-gray-900  dark:text-black">
          <i class="pr-2 fa-solid fa-cart-shopping"></i>
          Your Cart
        </h3>
        <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-black">
          Make changes your cart
        </p>
      </div>
      <div class="font-bold text-lg">
        Total Items: {{ cart.getTotalItems }}
      </div>
    </div>
    <div class="overflow-y-auto max-h-full">
      <ul class="flex flex-col">
        <li v-for="(item, index) in cart.items" :key="item.id" class="border-gray-400 flex flex-row mb-2">
          <div
            class="shadow border select-none cursor-pointer bg-white dark:bg-secondary-dark sm:rounded-md flex flex-1 items-center p-4">
            <div class="flex flex-col w-10 h-10 justify-center items-center mr-4">
              <a href="#" class="block relative">
                <img alt="profil" :src="`${item.image_path}_thumbnail.webp`" class="mx-auto object-cover sm:rounded-full h-10 w-10" />
              </a>
            </div>
            <div class="flex-1 pl-1 md:mr-16">
              <div class="font-medium text-xl dark:text-white">
                {{ item.name }}
              </div>
              <div class="text-gray-800 font-bold dark:text-gray-200 text-md">
                {{ item.price }} x <span>{{ item.quantity }}</span>
              </div>
            </div>
            <button @click="cart.removeFromCart(item, item.variantId, index)"
              class="px-4 mr-2 text-white font-bold py-2 hover:bg-gray-700 rounded shadow bg-gray-800">-</button>
            <span
              class="bg-gray-300 text-gray-800 text-sm px-3 font-bold inline-flex items-center p-2 rounded-full dark:bg-golden-yellow dark:text-gray-800">
              {{ item.quantity }}
            </span>
            <button @click="cart.addCart(item, item.variantId)"
              class="px-4 ml-2 text-white font-bold py-2 hover:bg-gray-700 rounded shadow bg-gray-800">+</button>
          </div>
        </li>
        <li class="shadow-md bg-white dark:bg-golden-yellow dark:text-black sm:rounded-md flex flex-1 py-4 px-8 flex flex-col gap-y-4 mb-2">
          <div v-if="cart.delivery || cart.tax" class="flex justify-between">
            <h1>Subtotal: </h1><span>{{ formatPrice(cart.getSubTotal) }}</span>
          </div>
          <div v-if="cart.delivery" class="flex justify-between">
            <h1>Delivery Fee: </h1><span>{{ cart.delivery }}</span>
          </div>
          <div v-if="cart.tax" class="flex justify-between">
            <h1>{{ restorant.config.tax_name }}<span class="text-sm">({{ cart.tax }}%)</span>: </h1><span>{{ formatPrice(cart.getTaxValue) }}</span>
          </div>
          <div class="flex justify-between">
            <h1>Payable </h1><span>{{ formatPrice(cart.getTotal) }}</span>
          </div>
        </li>
      </ul>
    </div>
  </div>
</template>

<script setup>
import { useCart } from '@/Stores/cart.js';
import { usePage } from '@inertiajs/inertia-vue3';
import { useThemeSwitcher } from "@/Composables/useThemeSwitcher";

const { currentTheme } = useThemeSwitcher();
const cart = useCart();
const props = defineProps({
  areas: Object,
  restorant: Object
});

//Currency Formatter
let locale = usePage().props.value.app.locale;
let currency = props.restorant.config.currency;
var formatter = new Intl.NumberFormat(locale, {
  style: 'currency',
  currency: currency,
});

const formatPrice = (amount) => {
  if (amount == '') {
    return '';
  }
  return formatter.format(amount);
}

</script>

<!-- <div class="container px-4 py-5 min-h-full w-1/3 sm:px-6 border dark:bg-gray-800 bg-white shadow mb-2 rounded-md">
<i class="pr-2 fa-solid fa-money-check-dollar"></i>
Checkout
</div> -->

