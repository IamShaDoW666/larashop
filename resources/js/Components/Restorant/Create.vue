<template>
   <div class="relative flex pt-12
      flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
      <div class="rounded-t bg-white mb-0 px-6 py-6">
         <div class="text-center flex justify-between">
            <h6 class="text-gray-700 text-xl font-bold">Register Restaurant</h6>
            <UserDropdown />
         </div>
      </div>
      <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
        <BreezeValidationErrors class="mb-4 bg-red-100 rounded my-4 py-2 px-4" />
         <form @submit.prevent="register">
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
               Restaurant Information
            </h6>
            <div class="flex flex-wrap">
               <div class="w-full lg:w-6/12 px-4">
                  <div class="relative w-full mb-3">
                     <label
                        class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                        htmlFor="grid-password">
                     Restaurant Name
                     </label>
                     <input v-model="form.name"
                        type="text"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                        />
                  </div>
               </div>
               <div class="w-full lg:w-6/12 px-4">
                  <div class="relative w-full mb-3">
                     <label
                        class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                        htmlFor="grid-password">
                        Phone
                     </label>
                     <input
                        type="number" v-model="form.phone"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                        />
                  </div>
               </div>
               <div class="w-full lg:w-6/12 px-4">
                  <div class="relative w-full mb-3">
                     <label
                        class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                        htmlFor="grid-password">
                     Country
                     </label>
                     <input
                        type="text" v-model="form.country"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                        />
                  </div>
               </div>
               <div class="w-full lg:w-6/12 px-4">
                  <div class="relative w-full mb-3">
                     <label
                        class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                        htmlFor="grid-password">
                     City
                     </label>
                     <input
                        type="text" v-model="form.city"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                        />
                  </div>
               </div>
               <div class="w-full lg:w-6/12 px-4">
                  <div class="relative w-full mb-3">
                     <label
                        class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                        htmlFor="grid-password">
                     Email
                     </label>
                     <input
                        type="text" v-model="form.email"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                        />
                  </div>
               </div>
               <div class="w-full lg:w-12/12 px-4">
                  <div class="relative w-full mb-3">
                     <label
                        class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                        htmlFor="grid-password">
                     Address
                     </label>
                     <input
                        type="text" v-model="form.address"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                        />
                  </div>
               </div>
            </div>
            <hr class="mt-6 border-b-1 border-blueGray-300" />
            <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
               Confirmation
            </h6>
            <button :class="{ 'opacity-25 hover:bg-blue-500': form.processing || !form.isDirty }" :disabled="form.processing || !form.isDirty" class="px-4 py-2 rounded shadow bg-blue-500 hover:bg-blue-600 text-white">
              Register Now
            </button>
         </form>
      </div>
   </div>
</template>

<script setup>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import { onMounted, ref } from 'vue';
import NotOwner from "@/Layouts/NotOwner.vue";
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import Swal from 'sweetalert2';

const form = useForm({
    name: 'Restaurant Name',
    phone: 'Phone',
    email: 'Email',
    minimum_order: 0,
    country: 'Country',
    address: 'Address',
    city: 'City',
});

const register = () => {
  console.log(form);
  form.post(route('restorant.store'), {
    onSuccess: () => {
      Swal.fire({
        icon: 'success',
        title: "Registered Successfully!",
        timer: 1500
      })
    }
  })
}

</script>
