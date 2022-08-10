<template>
  <Admin>
    <RestaurantLayout>
      <div class="rounded-t bg-white mb-0 px-6 py-6">
        <div class="text-center flex justify-between">
          <h6 class="text-gray-700 text-xl font-bold">Mail Settings</h6>
          <Link
            :href="
              route('restorants.show', {
                restorant: $page.props.auth.restorant.slug,
              })
            "
            class="
              bg-emerald-500
              text-white
              active:bg-emerald-600
              font-bold
              uppercase
              text-xs
              px-4
              py-2
              rounded
              shadow
              hover:shadow-md
              outline-none
              focus:outline-none
              mr-1
              ease-linear
              transition-all
              duration-150
            "
            type="button"
          >
            View
          </Link>
        </div>
      </div>
      <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
        <BreezeValidationErrors
          class="mb-4 bg-red-100 rounded my-4 py-2 px-4"
        />
        <form @submit.prevent="update">
          <div class="flex items-center mt-3 mb-6">
            <!-- <h6 class="text-blueGray-400 text-sm mr-4 font-bold uppercase">
                            Razorpay
                        </h6> -->
            <!-- <RazorpayIcon width="128" height="56" /> -->
          </div>
          <div class="flex flex-wrap">
            <div class="w-full lg:w-6/12 px-4">
              <div class="relative w-full mb-3">
                <label
                  class="
                    block
                    uppercase
                    text-blueGray-600 text-xs
                    font-bold
                    mb-2
                  "
                  htmlFor="grid-password"
                >
                  Host
                </label>
                <input
                  v-model="form.MAIL_HOST"
                  type="text"
                  class="
                    border-0
                    px-3
                    py-3
                    placeholder-blueGray-300
                    text-blueGray-600
                    bg-white
                    rounded
                    text-sm
                    shadow
                    focus:outline-none focus:ring
                    w-full
                    ease-linear
                    transition-all
                    duration-150
                  "
                />
              </div>
            </div>
            <div class="w-full lg:w-6/12 px-4">
              <div class="relative w-full mb-3">
                <label
                  class="
                    block
                    uppercase
                    text-blueGray-600 text-xs
                    font-bold
                    mb-2
                  "
                  htmlFor="grid-password"
                >
                  Port
                </label>
                <input
                  v-model="form.MAIL_PORT"
                  type="text"
                  class="
                    border-0
                    px-3
                    py-3
                    placeholder-blueGray-300
                    text-blueGray-600
                    bg-white
                    rounded
                    text-sm
                    shadow
                    focus:outline-none focus:ring
                    w-full
                    ease-linear
                    transition-all
                    duration-150
                  "
                />
              </div>
            </div>
            <div class="w-full lg:w-6/12 px-4">
              <div class="relative w-full mb-3">
                <label
                  class="
                    block
                    uppercase
                    text-blueGray-600 text-xs
                    font-bold
                    mb-2
                  "
                  htmlFor="grid-password"
                >
                  Username
                </label>
                <input
                  v-model="form.MAIL_USERNAME"
                  type="text"
                  class="
                    border-0
                    px-3
                    py-3
                    placeholder-blueGray-300
                    text-blueGray-600
                    bg-white
                    rounded
                    text-sm
                    shadow
                    focus:outline-none focus:ring
                    w-full
                    ease-linear
                    transition-all
                    duration-150
                  "
                />
              </div>
            </div>
            <div class="w-full lg:w-6/12 px-4">
              <div class="relative w-full mb-3">
                <label
                  class="
                    block
                    uppercase
                    text-blueGray-600 text-xs
                    font-bold
                    mb-2
                  "
                  htmlFor="grid-password"
                >
                  Password
                </label>
                <input
                  v-model="form.MAIL_PASSWORD"
                  type="text"
                  class="
                    border-0
                    px-3
                    py-3
                    placeholder-blueGray-300
                    text-blueGray-600
                    bg-white
                    rounded
                    text-sm
                    shadow
                    focus:outline-none focus:ring
                    w-full
                    ease-linear
                    transition-all
                    duration-150
                  "
                />
              </div>
            </div>
            
            <div class="w-full lg:w-6/12 px-4">
              <div class="relative w-full mb-3">
                <label
                  class="
                    block
                    uppercase
                    text-blueGray-600 text-xs
                    font-bold
                    mb-2
                  "
                  htmlFor="grid-password"
                >
                Encryption
                </label>
                <input
                  v-model="form.MAIL_ENCRYPTION"
                  type="text"
                  class="
                    border-0
                    px-3
                    py-3
                    placeholder-blueGray-300
                    text-blueGray-600
                    bg-white
                    rounded
                    text-sm
                    shadow
                    focus:outline-none focus:ring
                    w-full
                    ease-linear
                    transition-all
                    duration-150
                  "
                />
              </div>
            </div>
            <div class="w-full lg:w-6/12 px-4">
              <div class="relative w-full mb-3">
                <label
                  class="
                    block
                    uppercase
                    text-blueGray-600 text-xs
                    font-bold
                    mb-2
                  "
                  htmlFor="grid-password"
                >
                  From address
                </label>
                <input
                  v-model="form.MAIL_FROM_ADDRESS"
                  type="text"
                  class="
                    border-0
                    px-3
                    py-3
                    placeholder-blueGray-300
                    text-blueGray-600
                    bg-white
                    rounded
                    text-sm
                    shadow
                    focus:outline-none focus:ring
                    w-full
                    ease-linear
                    transition-all
                    duration-150
                  "
                />
              </div>
            </div>
          </div>
          <hr class="mt-6 border-b-1 border-blueGray-300" />
          <button
            :class="{ 'opacity-25': form.processing || !form.isDirty }"
            :disabled="form.processing || !form.isDirty"
            class="
              px-4
              py-2
              mt-4
              rounded
              shadow
              bg-blue-500
              hover:bg-blue-600
              text-white
            "
          >
            Update
          </button>
        </form>
      </div>
    </RestaurantLayout>
  </Admin>
</template>

<script setup>
import Admin from "@/Layouts/Admin";
import RestaurantLayout from "@/Layouts/Restaurant.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
const props = defineProps({
  data: Object
})
const form = useForm({
    MAIL_HOST: props.data.mail_host ?? '',
    MAIL_PORT: props.data.mail_port ?? '',    
    MAIL_USERNAME: props.data.mail_username ?? '',    
    MAIL_PASSWORD: props.data.mail_password ?? '',    
    MAIL_ENCRYPTION: props.data.mail_encryption ?? '',    
    MAIL_FROM_ADDRESS: props.data.mail_from_address ?? ''    
})

const update = () => {
    form.patch(route('owner.restorant.smtp.update', { restorant: usePage().props.value.auth.restorant.id }), {
      onSuccess: () => {
        Swal.fire({
          icon: "success",
          title: "Updated Successfully",
          timer: 2000
        })
      }
    })
}


</script>
            