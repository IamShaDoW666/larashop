<template>
  <div class="mt-8 md:mt-0 bg-white rounded-lg shadow-lg p-8">
    <form method="POST" @submit.prevent="submit" class="flex flex-col">
      <BreezeValidationErrors class="mb-4" />
      <label class="font-semibold text-xs" for="name">Name</label>
      <input v-model="form.customer_name"
        class="flex items-center h-12 px-4 w-full bg-gray-200 mt-2 mb-2 rounded focus:outline-none focus:ring-2"
        type="text">
      <label class="font-semibold text-xs mt-3" for="phonenumber">Phone Number</label>
      <input v-model="form.customer_phone"
        class="flex items-center h-12 px-4 w-full bg-gray-200 mt-2 mb-2 rounded focus:outline-none focus:ring-2"
        type="text">
      <label class="font-semibold text-xs mt-3 mb-2" for="address">Order type</label>
      <div class="flex gap-x-2">
        <div class="form-control" v-if="Boolean(Number(restorant.config.can_deliver))">
          <label class="label cursor-pointer">
            <span class="label-text mr-2">Delivery</span>
            <input type="radio" id="delivery" v-model="form.order_type" value="1" name="order_type"
              class="radio checked:bg-green-500" />
          </label>
        </div>
        <div class="form-control" v-if="Boolean(Number(restorant.config.can_pickup))">
          <label class="label cursor-pointer">
            <span class="label-text mr-2">Pickup</span>
            <input type="radio" id="pickup" v-model="form.order_type" value="2" name="order_type"
              class="radio checked:bg-blue-500" />
          </label>
        </div>
        <div class="form-control" v-if="Boolean(Number(restorant.config.can_dinein))">
          <label class="label cursor-pointer">
            <span class="label-text mr-2">Dine-in</span>
            <input type="radio" id="dinein" v-model="form.order_type" value="3" name="order_type"
              class="radio checked:bg-slate-500" />
          </label>
        </div>
      </div>
      <label class="font-semibold text-xs mt-3" for="address">Address</label>
      <textarea v-model="form.address" rows="4"
        class="flex items-center mb-4 px-4 w-full bg-gray-200 mt-2 rounded focus:outline-none focus:ring-2"
        type="text"></textarea>
      <!-- <button id="dropdownDefault" data-dropdown-toggle="dropdown" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none w-full font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Dropdown button <i class="fa-solid fa-caret-down"></i></button> -->
      <span v-if="areas.length && form.order_type == 1" class="font-bold">Select Delivery Area</span>
      <select v-if="areas.length && form.order_type == 1" v-model="cart.delivery"
        class="w-full text-sm mt-2 rounded group ring-0 shadow active:text-black hover:text-black font-bold text-white bg-gray-600 hover:bg-gray-100"
        aria-labelledby="dropdownDefaselectt">
        <option placeholder="Delivery Area" aria-placeholder="Delivery Area" :value="area.delivery_fee"
          v-for="area in areas" :key="area.id">
          <span class="block text-sm py-2 hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white">{{ area.name
          }} {{ area.delivery_fee }}</span>
        </option>
      </select>
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

    <div class="flex mt-10 px-5">
      <h1 class="font-bold">Payable: </h1><span class="ml-2">{{ formatPrice(cart.getTotal.toFixed(2)) }}</span>
    </div>
  </div>
</template>

<script setup>
import { usePage } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, watch } from 'vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import { Inertia } from '@inertiajs/inertia';

const props = defineProps({
  areas: Object,
  cart: Object,
  restorant: Object
})

//For having default value for order_type
// const getOrderType = computed(() => {
//   if (Boolean(Number(props.restorant.config.can_deliver))) {
//     return "1"
//   } else if (Boolean(Number(props.restorant.config.can_pickup))) {
//     return "2"
//   } else if (Boolean(Number(props.restorant.config.can_deliver))) {
//     return "3"
//   } else {
//     return null
//   }
// })

const form = reactive({
  customer_name: '',
  customer_phone: '',
  address: '',
  checked: false,
  order_type: 1,
})

watch(form, (value) => {
  if (value.order_type != 1) {
    props.cart.resetDelivery();
  }
})

const submit = () => {
  Inertia.post(route('orders.store', { restorant: props.restorant.uuid }), {
    form,
    cart: props.cart.getCart()
  }), {
    onSuccess: () => {
      alert('Order Successful')
    }
  }
}

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

onMounted(() => {
  if (props.cart.delivery) {
    console.log('yes')
  } else {
    props.cart.delivery = props.areas[0] ? props.areas[0].price : 0
  }
})


</script>
