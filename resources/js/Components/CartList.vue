<template>
  <div class="sm:flex block gap-x-3 justify-between">
    <div class="container flex flex-col w-full sm:w-3/5">
      <div class="px-4 py-5 sm:px-6 w-full flex justify-between border dark:bg-gray-800 bg-white shadow mb-2 rounded-md">
        <div>
          <h3 class="text-lg leading-6 font-medium text-gray-900 dark:text-white">
            <i class="pr-2 fa-solid fa-cart-shopping"></i>
            Your Cart
          </h3>
          <p class="mt-1 max-w-2xl text-sm text-gray-500 dark:text-gray-200">
            Make changes to your cart
          </p>
        </div>
        <div v-if="cart.items.length > 0" class="text-md font-bold text-green-700">
          <span class="text-black">Amount Payable: </span> ${{ cart.getTotal.toFixed(2) }}
        </div>
        <div class="font-bold text-lg">
          Total Items: {{ cart.getTotalItems }}
        </div>
      </div>
      <ul class="flex flex-col">
        <li v-for="(item, index) in cart.items" class="border-gray-400 flex flex-row mb-2">
          <div class="shadow border select-none cursor-pointer bg-white dark:bg-gray-800 rounded-md flex flex-1 items-center p-4">
            <div class="flex flex-col w-10 h-10 justify-center items-center mr-4">
              <a href="#" class="block relative">
                <img alt="profil" :src="item.imglarge" class="mx-auto object-cover rounded-full h-10 w-10"/>
              </a>
            </div>
            <div class="flex-1 pl-1 md:mr-16">
              <div class="font-medium text-xl dark:text-white">
                {{ item.name }}
              </div>
              <div class="text-gray-800 font-bold dark:text-gray-200 text-md">
                ${{ item.price }} x <span>{{ item.quantity }}</span>
              </div>
            </div>
            <button @click="cart.removeFromCart(item.id, index)" class="px-4 mr-2 text-white font-bold py-2 hover:bg-gray-700 rounded shadow bg-gray-800">-</button>
            <span class="bg-gray-300 text-gray-800 text-sm px-3 font-bold inline-flex items-center p-2 rounded-full dark:bg-gray-200 dark:text-gray-800">
              {{ item.quantity }}
            </span>
            <button @click="cart.addCart(item.id, index)" class="px-4 ml-2 text-white font-bold py-2 hover:bg-gray-700 rounded shadow bg-gray-800">+</button>
          </div>
        </li>
      </ul>
    </div>


    <CustomerForm v-if="cart.items.length > 0" :areas="areas" :cart="cart" class="sm:w-2/5" />

  </div>
</template>

<script setup>
import CustomerForm from '@/Components/Forms/CustomerForm.vue';
import { useCart } from '@/Stores/cart.js';
import { onMounted } from 'vue';

const cart = useCart();
const props = defineProps({
  areas: Object
});
</script>

<!-- <div class="container px-4 py-5 min-h-full w-1/3 sm:px-6 border dark:bg-gray-800 bg-white shadow mb-2 rounded-md">
<i class="pr-2 fa-solid fa-money-check-dollar"></i>
Checkout
</div> -->
