<template>
  <div class="md:flex space-x-1 justify-around mt-8 sm:mt-0 bg-white rounded shadow-lg p-8 pr-0">
    <form method="POST" @submit.prevent="submit" class="flex flex-col">
      <BreezeValidationErrors class="mb-4" />
      <label class="font-semibold text-xs" for="name">Name</label>
      <input v-model="form.customer_name"
        class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="text">
      <label class="font-semibold text-xs mt-3" for="phonenumber">Phone Number</label>
      <input v-model="form.customer_phone"
        class="flex items-center h-12 px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2" type="text">
      <label class="font-semibold text-xs mt-3" for="address">Order type</label>
      <div class="flex gap-x-2">
        <div>
          <input v-model="form.order_type" value="1" type="radio" name="order_type" id="delivery"><span
            class="ml-2">Delivery</span>
        </div>
        <div>
          <input v-model="form.order_type" value="3" type="radio" name="order_type" id="dinein"><span
            class="ml-2">Dine-in</span>
        </div>
        <div>
          <input v-model="form.order_type" value="2" type="radio" name="order_type" id="pickup"><span
            class="ml-2">Pickup</span>
        </div>
      </div>
      <label class="font-semibold text-xs mt-3" for="address">Address</label>
      <textarea v-model="form.address" rows="4"
        class="flex items-center px-4 w-64 bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2"
        type="text"></textarea>
      <div class="flex items-center my-4 px-4">
        <input id="default-checkbox" type="checkbox" v-model="form.checked"
          class="w-4 h-4 text-blue-600 bg-gray-100 border-gray-300 rounded focus:ring-blue-500 dark:focus:ring-blue-600 dark:ring-offset-gray-800 focus:ring-2 dark:bg-gray-700 dark:border-gray-600">
        <label for="default-checkbox" class="ml-2 text-sm font-medium text-gray-900 dark:text-gray-300">I agree to terms
          and conditions</label>
      </div>
      <button type="submit" :disabled="!form.checked || form.processing"
        :class="{ 'opacity-25 hover:bg-green-600': !form.checked || form.processing }"
        class="flex items-center justify-center h-12 px-6 w-64 bg-green-600 mt-8 rounded font-semibold text-sm text-green-100 hover:bg-green-700">Place
        Order</button>
    </form>
    <div class="py-3 rounded w-1/3">
      <!-- <button id="dropdownDefault" data-dropdown-toggle="dropdown" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none w-full font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Dropdown button <i class="fa-solid fa-caret-down"></i></button> -->
      <span v-if="areas.length" class="font-bold">Select Delivery Area</span>
      <select v-if="areas.length" v-model="cart.delivery"
        class="w-full text-sm mt-2 rounded group ring-0 shadow active:text-black hover:text-black font-bold text-white bg-gray-600 hover:bg-gray-100"
        aria-labelledby="dropdownDefaselectt">
        <option placeholder="Delivery Area" aria-placeholder="Delivery Area" :value="area.delivery_fee"
          v-for="area in areas" :key="area.id">
          <span class="block text-sm py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ area.name
          }} {{ formatPrice(area.delivery_fee) }}</span>
        </option>
      </select>

      <div class="flex flex-col gap-y-4 mt-12">
        <div v-if="cart.delivery" class="flex justify-between">
          <h1>Subtotal: </h1><span>{{ formatPrice(cart.getSubTotal) }}</span>
        </div>
        <div v-if="cart.delivery" class="flex justify-between">
          <h1>Delivery Fee: </h1><span>{{ formatPrice(cart.delivery) }}</span>
        </div>
        <div class="flex justify-between">
          <h1>Payable: </h1><span>{{ formatPrice(cart.getTotal.toFixed(2)) }}</span>
        </div>
      </div>

    </div>
  </div>
</template>

<script setup>
import { useForm, usePage } from '@inertiajs/inertia-vue3';
import { inject, onMounted } from 'vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import Swal from 'sweetalert2';
import { Inertia } from '@inertiajs/inertia';
const props = defineProps({
  areas: Object,
  cart: Object
})

const form = useForm({
  customer_name: '',
  customer_phone: '',
  address: '',
  checked: false,
  order_type: 1,
  cart: props.cart

})

const { restorant } = inject('restorant');

const submit = () => {
  form.post(route('orders.store', {restorant: restorant.uuid}), {
    onSuccess: () => {
      Swal.fire({
        icon: 'success',
        title: 'Order Successful!',
        timer: 1000,
        timerProgressBar: true,
        didClose: () => {
          Inertia.post(
            route('orders.send'),
            {
              
            }
          )
        }
      })
    }
  })
}

//Currency Formatter
let locale = usePage().props.value.app.locale;
let currency = usePage().props.value.auth.restorant.config.currency;
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

onMounted(() => {
  if (props.cart.delivery) {
    console.log('yes')
  } else {
    props.cart.delivery = props.areas[0] ? props.areas[0].price : 0
  }
})


</script>
