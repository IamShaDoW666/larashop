<template>
  <div class="relative flex
  flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
  <div class="rounded-t bg-white mb-0 px-6 py-6">
    <div class="text-center flex justify-between">
      <h6 class="text-gray-700 text-xl font-bold">My Account</h6>
      <Link v-if="user.restorant" :href="route('owner.restorant.index')"
      class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
      type="button">
      Restorant Settings
    </Link>
  </div>
</div>
<div class="flex-auto px-4 lg:px-10 py-10 pt-0">
  <form @submit.prevent="update">
    <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
      User Information
    </h6>
    <div class="flex flex-wrap">
      <div class="w-full lg:w-6/12 px-4">
        <div class="relative w-full mb-3">
          <label
          class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
          htmlFor="grid-password">
          Name
        </label>
        <input
        type="text" v-model="form.name"
        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
        />
      </div>
    </div>
    <div class="w-full lg:w-6/12 px-4">
      <div class="relative w-full mb-3">
        <label
        class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
        htmlFor="grid-password">
        Email address
      </label>
      <input
      type="email" v-model="form.email"
      class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
      />
    </div>
  </div>
</div>
<button :disabled="!form.isDirty || form.processing" :class="{'opacity-50 hover:bg-blue-500': !form.isDirty || form.processing}" class="float-right text-white font-bold mt-4 px-4 py-2 rounded shadow bg-blue-500 hover:bg-blue-600">Update</button>
</form>
</div>
</div>
</template>

<script setup>
import { Link, useForm } from '@inertiajs/inertia-vue3';
import Swal from 'sweetalert2';
const form = useForm({
  name: props.user.name,
  phone: '',
  email: props.user.email

})

const props = defineProps ({
  user: Object,
})

const update = () => {
  if (form.isDirty)


  if (props.user.restorant) {
    form.patch(route('owner.user.update', {user: props.user.id}), {
      onSuccess: () => {
        Swal.fire({
          icon: 'success',
          title: "Updated Successfully!",
          timer: 1500
        })
      }
    })
  } else {
    form.patch(route('guest.user.update', {user: props.user.id}), {
      onSuccess: () => {
        Swal.fire({
          icon: 'success',
          title: "Updated Successfully!",
          timer: 1500
        })
      }
    })
  }

}

</script>
