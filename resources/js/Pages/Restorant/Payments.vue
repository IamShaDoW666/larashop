<template>
    <Admin>
        <RestaurantLayout>
            <div class="rounded-t bg-white mb-0 px-6 py-6">
                <div class="text-center flex justify-between">
                    <h6 class="text-gray-700 text-xl font-bold">Payments</h6>
                    <Link :href="
                        route('restorants.show', {
                            restorant: $page.props.auth.restorant.slug,
                        })
                    " class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
                        type="button">
                    View
                    </Link>
                </div>
            </div>
            <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
                <BreezeValidationErrors class="mb-4 bg-red-100 rounded my-4 py-2 px-4" />
                <form @submit.prevent="update">
                    
                    <div class="flex items-center mt-3 mb-6">
                        <!-- <h6 class="text-blueGray-400 text-sm mr-4 font-bold uppercase">
                            Razorpay
                        </h6> -->
                        <RazorpayIcon width="128" height="56" />
                    </div>
                    <div class="flex flex-wrap">
                        <div class="w-full lg:w-6/12 px-4">
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password">
                                    Razorpay API Key
                                </label>
                                <input v-model="form.razorpay_api_key" type="text"
                                    class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                            </div>
                        </div>
                        <div class="w-full lg:w-6/12 px-4">
                            <div class="relative w-full mb-3">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password">
                                    Razorpay API Secret
                                </label>
                                <input v-model="form.razorpay_api_secret" type="text"
                                    class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                            </div>
                        </div>
                    </div>
                    <hr class="mt-6 border-b-1 border-blueGray-300" />
                    <button :class="{ 'opacity-25': form.processing || !form.isDirty }"
                        :disabled="form.processing || !form.isDirty"
                        class="px-4 py-2 mt-4 rounded shadow bg-blue-500 hover:bg-blue-600 text-white">
                        Update
                    </button>
                </form>
            </div>
        </RestaurantLayout>
    </Admin>
</template>

<script setup>
import Admin from "@/Layouts/Admin";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import RestaurantLayout from "@/Layouts/Restaurant.vue";
import GoogleIcon from "@/Components/Social/Icons/GoogleIcon";
import RazorpayIcon from "@/Components/Social/Icons/RazorpayIcon";
import { Link, usePage, useForm } from "@inertiajs/inertia-vue3";
import Swal from 'sweetalert2';
let restorant = usePage().props.value.auth.restorant;
let conf = restorant.config;
const form = useForm({
   
    razorpay_api_key: conf.razorpay_api_key ?? '',
    razorpay_api_secret: conf.razorpay_api_secret ?? '',
    stripe_api_key: conf.stripe_api_key ?? '',
    stripe_api_secret: conf.stripe_api_secret ?? '',
})

const update = () => {
    form.patch(route('owner.restorant.payment.update', { config: conf.id }), {
        onSuccess: () => {
            Swal.fire({
                icon: 'success',
                title: 'Updated!'
            })
        }
    })
}
</script>