<template>
   <div class="relative flex
      flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
      <div class="rounded-t bg-white mb-0 px-6 py-6">
         <div class="text-center flex justify-between">
            <h6 class="text-gray-700 text-xl font-bold">store Settings</h6>
            <Link :href="route('grocerys.show', { grocery: $page.props.auth.grocery.slug })"
               class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
               type="button">
            View
            </Link>
         </div>
      </div>
      <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
         <BreezeValidationErrors class="mb-4 bg-red-100 rounded my-4 py-2 px-4" />
         <form @submit.prevent="update">
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
               store Information
            </h6>
            <div class="flex flex-wrap">
               <div class="w-full lg:w-6/12 px-4">
                  <div class="relative w-full mb-3">
                     <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                        store Name
                     </label>
                     <input v-model="form.name" type="text"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                  </div>
               </div>
               <div class="w-full lg:w-6/12 px-4">
                  <div class="relative w-full mb-3">
                     <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                        Phone
                     </label>
                     <input type="string" v-model="form.phone"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                  </div>
               </div>
               <div class="w-full lg:w-6/12 px-4">
                  <div class="relative w-full mb-3">
                     <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                        Country
                     </label>
                     <input type="text" v-model="form.country"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                  </div>
               </div>
               <div class="w-full lg:w-6/12 px-4">
                  <div class="relative w-full mb-3">
                     <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                        City
                     </label>
                     <input type="text" v-model="form.city"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                  </div>
               </div>
               <div class="w-full lg:w-12/12 px-4">
                  <div class="relative w-full mb-3">
                     <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                        Address
                     </label>
                     <input type="text" v-model="form.address"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                  </div>
               </div>
            </div>
            <hr class="mt-6 border-b-1 border-blueGray-300" />
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
               Ordering Information
            </h6>
            <div class="flex flex-wrap">
               <div class="w-full lg:w-4/12 px-4">
                  <div class="relative w-full mb-3">
                     <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                        Minimum Order
                     </label>
                     <input type="number" v-model="form.minimum_order"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                        placeholed="100" />
                  </div>
               </div>
               <div class="w-full lg:w-4/12 px-4">
                  <div class="relative w-full mb-3">
                     <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                        Order Types
                     </label>
                     <div class="grid grid-cols-2 gap-x-2 gap-y-4 items-center">
                        <div class="flex items-center">
                           <label class="mr-2 block uppercase text-blueGray-600 text-xs" for="Delivery">Delivery</label>
                           <input type="checkbox" v-model="form.can_deliver"
                              class="border-0 px-2 py-2 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring ease-linear transition-all duration-150"
                              value="Delivery" />
                        </div>
                        <div class="flex items-center">
                           <label class="mr-2 block uppercase text-blueGray-600 text-xs" for="Delivery">Pickup</label>
                           <input type="checkbox" v-model="form.can_pickup"
                              class="border-0 px-2 py-2 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring ease-linear transition-all duration-150"
                              value="Pickup" />
                        </div>
                        <div class="flex items-center">
                           <label class="mr-2 block uppercase text-blueGray-600 text-xs" for="Delivery">Dine-in</label>
                           <input type="checkbox" v-model="form.can_dinein"
                              class="border-0 px-2 py-2 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring ease-linear transition-all duration-150"
                              value="Dine-in" />
                        </div>
                     </div>
                  </div>
               </div>
               <div class="w-full lg:w-4/12 px-4">
                  <div class="relative w-full mb-3">
                     <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                        Postal Code
                     </label>
                     <input type="number" v-model="form.postal_code"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                  </div>
               </div>
               <div class="w-full lg:w-4/12 px-4">
                  <div class="relative w-full mb-3">
                     <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                        Currency
                     </label>
                     <input type="text" v-model="form.currency"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                  </div>
               </div>
            </div>
            <hr class="mt-6 border-b-1 border-blueGray-300" />
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
               Confirmation
            </h6>
            <button :class="{ 'opacity-25': form.processing || !form.isDirty }"
               :disabled="form.processing || !form.isDirty"
               class="px-4 py-2 rounded shadow bg-blue-500 hover:bg-blue-600 text-white">
               Update
            </button>
         </form>
      </div>
   </div>
</template>

<script setup>
import { Head, Link, useForm, usePage } from '@inertiajs/inertia-vue3';
import { onMounted, ref } from 'vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import MazPhoneNumberInput from 'maz-ui/components/MazPhoneNumberInput'
import Swal from 'sweetalert2';

let grocery = usePage().props.value.auth.grocery;
let conf = usePage().props.value.auth.grocery.config;

const form = useForm({
   name: grocery ? grocery.name : '',
   phone: grocery ? grocery.phone : '',
   minimum_order: conf ? conf.minimum_order : 0,
   country: grocery ? grocery.country : '',
   address: grocery ? grocery.address : '',
   can_deliver: conf ? Boolean(Number(conf.can_deliver)) : false,
   can_dinein: conf ? Boolean(Number(conf.can_dinein)) : false,
   can_pickup: conf ? Boolean(Number(conf.can_pickup)) : false,
   city: grocery ? grocery.city : '',
   postal_code: grocery ? grocery.postal_code : '',
   currency: conf ? conf.currency : ''
});

const update = () => {
   form.patch(route('owner.grocery.update', { grocery: usePage().props.value.auth.grocery.id }), {
      onSuccess: () => {
         Swal.fire({
            icon: 'success',
            title: "Updated Successfully!",
            timer: 1000
         })
      }
   })
}

</script>
