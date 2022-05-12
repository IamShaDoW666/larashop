<template>
  <div v-if="cart.items" id="small-modal" tabindex="-1" class="hidden overflow-y-auto overflow-x-hidden fixed top-0 right-0 left-0 z-50 w-full md:inset-0 h-modal md:h-full mx-4 px-4">
    <div class="bg-white p-4 rounded w-full">
      <div class="text-center divide-y divide-solid font-bold">
        <div class="p-4 rounded bg-gray-200">
          <ul class="space-y-2">
            <li>
              <div class="flex justify-between divide-solid divide-y bg-gray-300 text-center p-2 rounded-lg text-base font-bold">
                <i class="pr-2 fa-solid fa-cart-shopping"></i>
                Cart ({{ cart.getTotalItems }})
                <div data-modal-toggle="small-modal">
                  <i class="hover:opacity-60 fa-solid fa-xmark"></i>
                </div>
              </div>
            </li>
            <li v-for="(item, index) in cart.items" :key="item.id" class="odd:bg-gray-100 rounded-lg">
              <div class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white">
                <div class="font-bold flex-1 ml-3 whitespace-nowrap">
                  {{ item.name }}
                </div>
                <span>${{ item.price }} <strong>x</strong> </span>
                <button @click="fromCart(item.id, index)" class="inline-flex justify-center items-center p-3 ml-3 w-3 h-3 hover:ring-2 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">
                  {{ item.quantity }}
                </button>
              </div>
            </li>
            <li>
              <div class="font-bold rounded shadow-lg bg-white text-center flex items-center p-3 text-base text-gray-900 rounded-lg dark:text-white">
                Subtotal: <span class="ml-2 text-green-700">${{ cart.getSubTotal }}</span>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </div>
  </div>
</template>

<script setup>
const props = defineProps({
  cart: Object,
  fromCart: Function
});

</script>
