<template>
    <RestaurantLayout>
        <div class="rounded-t bg-white mb-0 px-6 py-6">
            <div class="text-center flex justify-between">
                <h6 class="text-gray-700 text-xl font-bold">Restaurant Settings</h6>
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
                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
                    Restaurant Information
                </h6>
                <div class="flex flex-wrap">
                    <div class="w-full lg:w-6/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password">
                                Restaurant Name
                            </label>
                            <input v-model="form.name" type="text"
                                class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                        </div>
                    </div>
                    <div class="w-full lg:w-6/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password">
                                Whatsapp Phone
                            </label>
                            <MazPhoneNumberInput no-use-browser-locale no-example v-model="form.phone" show-code-on-list
                                color="info" :preferred-countries="[
                                    'IN',
                                    'FR',
                                    'BE',
                                    'DE',
                                    'US',
                                    'GB',
                                ]" @update="results = $event" :success="results?.isValid" />
                        </div>
                    </div>
                    <div class="w-full lg:w-6/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password">
                                Country
                            </label>
                            <input type="text" v-model="form.country"
                                class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                        </div>
                    </div>
                    <div class="w-full lg:w-6/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password">
                                City
                            </label>
                            <input type="text" v-model="form.city"
                                class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                        </div>
                    </div>
                    <div class="w-full lg:w-12/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password">
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
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password">
                                Minimum Order
                            </label>
                            <input type="number" v-model="form.minimum_order"
                                class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150"
                                placeholed="100" />
                        </div>
                    </div>
                    <div class="w-full lg:w-4/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password">
                                Order Types
                            </label>
                            <div class="grid grid-cols-2 gap-x-2 gap-y-4 items-center">
                                <div class="flex items-center">
                                    <label class="mr-2 block uppercase text-blueGray-600 text-xs"
                                        for="Delivery">Delivery</label>
                                    <input type="checkbox" v-model="form.can_deliver"
                                        class="border-0 px-2 py-2 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring ease-linear transition-all duration-150"
                                        value="Delivery" />
                                </div>
                                <div class="flex items-center">
                                    <label class="mr-2 block uppercase text-blueGray-600 text-xs"
                                        for="Delivery">Pickup</label>
                                    <input type="checkbox" v-model="form.can_pickup"
                                        class="border-0 px-2 py-2 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring ease-linear transition-all duration-150"
                                        value="Pickup" />
                                </div>
                                <div class="flex items-center">
                                    <label class="mr-2 block uppercase text-blueGray-600 text-xs"
                                        for="Delivery">Dine-in</label>
                                    <input type="checkbox" v-model="form.can_dinein"
                                        class="border-0 px-2 py-2 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring ease-linear transition-all duration-150"
                                        value="Dine-in" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="w-full lg:w-4/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password">
                                Postal Code
                            </label>
                            <input type="number" v-model="form.postal_code"
                                class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                        </div>
                    </div>
                    <div class="w-full lg:w-4/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password">
                                Currency
                            </label>
                            <input type="text" :value="form.currency"
                                @input="event => form.currency = event.target.value.toUpperCase()"
                                class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                        </div>
                    </div>
                    <div class="w-full lg:w-8/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password">
                                Delivery Info
                            </label>
                            <input type="text" v-model="form.delivery_info"
                                class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                        </div>
                    </div>
                </div>

                <hr class="mt-6 border-b-1 border-blueGray-300" />

                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
                    Page Settings
                </h6>
                <div class="flex flex-wrap">
                    <div class="w-full lg:w-4/12 px-4">
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password">
                                Restaurant Logo
                            </label>
                            <div v-if="logoPreviewImage" class="logoPreviewWrapper mb-3" :style="{
                                'background-image': `url(${logoPreviewImage})`,
                            }"></div>
                            <input @input="pickLogo" ref="logoFileInput" type="file"
                                class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                        </div>
                        <div class="relative w-full mb-3">
                            <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                htmlFor="grid-password">
                                Restaurant Banner
                            </label>
                            <div v-if="previewImage" class="bannerPreviewWrapper mb-3" :style="{
                                'background-image': `url(${previewImage})`,
                            }"></div>
                            <input @input="pickFile" ref="fileInput" type="file"
                                class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                        </div>
                    </div>
                </div>

                <hr class="mt-6 border-b-1 border-blueGray-300" />

                <h6 class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase">
                    Social Links
                </h6>
                <div class="flex flex-wrap">
                    <div class="w-full lg:w-6/12 px-4">
                        <div class="relative w-full mb-3">
                            <div class="flex items-center">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password">
                                    Facebook
                                </label>
                                <FacebookIcon class="ml-2 mb-4" width="6" height="6" />
                            </div>
                            <input v-model="form.facebook" placeholder="https://facebook.com/example" type="text"
                                class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                        </div>
                    </div>
                    <div class="w-full lg:w-6/12 px-4">
                        <div class="relative w-full mb-3">
                            <div class="flex items-center">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password">
                                    Instagram
                                </label>
                                <InstagramIcon class="ml-2 mb-4" width="6" height="6" />
                            </div>
                            <input v-model="form.instagram" type="text" placeholder="https://instagram.com/example"
                                class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                        </div>
                    </div>
                    <div class="w-full lg:w-6/12 px-4">
                        <div class="relative w-full mb-3">
                            <div class="flex items-center">
                                <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2"
                                    htmlFor="grid-password">
                                    Twitter
                                </label>
                                <TwitterIcon class="ml-2 mb-4" width="6" height="6" />
                            </div>
                            <input v-model="form.twitter" type="text" placeholder="https://twitter.com/example"
                                class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                        </div>
                    </div>
                    <!-- <div class="w-full lg:w-12/12 px-4">
                  <div class="relative w-full mb-3">
                     <label class="block uppercase text-blueGray-600 text-xs font-bold mb-2" htmlFor="grid-password">
                        Address
                     </label>
                     <input type="text" v-model="form.address"
                        class="border-0 px-3 py-3 placeholder-blueGray-300 text-blueGray-600 bg-white rounded text-sm shadow focus:outline-none focus:ring w-full ease-linear transition-all duration-150" />
                  </div>
               </div> -->
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
    </RestaurantLayout>
</template>

<script setup>
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import { onMounted, ref } from "vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import MazPhoneNumberInput from "maz-ui/components/MazPhoneNumberInput";
import RestaurantLayout from '@/Layouts/Restaurant';
import Swal from "sweetalert2";
import { Inertia } from "@inertiajs/inertia";
import FacebookIcon from "../Social/Icons/FacebookIcon.vue";
import TwitterIcon from "../Social/Icons/TwitterIcon.vue";
import InstagramIcon from "../Social/Icons/InstagramIcon.vue";

const emit = defineEmits(["input"]);
const props = defineProps({
    confs: Object
})
let restorant = usePage().props.value.auth.restorant;
let conf = usePage().props.value.auth.restorant.config;
console.log(restorant);
const previewImage = ref(`${restorant.banner}_large.webp`);
const logoPreviewImage = ref(`${restorant.logo}_logo.webp`);
const fileInput = ref();
const logoFileInput = ref();
onMounted(() => {
    console.log(props)
})
const pickFile = () => {
    form.banner = fileInput.value.files[0];
    if (fileInput.value.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            previewImage.value = e.target.result;
        };
        reader.readAsDataURL(fileInput.value.files[0]);
        emit("input", fileInput.value.files[0]);
    }
};

const pickLogo = () => {
    form.logo = logoFileInput.value.files[0];
    if (logoFileInput.value.files[0]) {
        const reader = new FileReader();
        reader.onload = (e) => {
            logoPreviewImage.value = e.target.result;
        };
        reader.readAsDataURL(logoFileInput.value.files[0]);
        emit("input", logoFileInput.value.files[0]);
    }
};

const form = useForm({
    name: restorant ? restorant.name : "",
    phone: restorant ? restorant.phone : "",
    minimum_order: conf ? conf.minimum_order : 0,
    country: restorant ? restorant.country : "",
    address: restorant ? restorant.address : "",
    can_deliver: conf ? Boolean(Number(conf.can_deliver)) : false,
    can_dinein: conf ? Boolean(Number(conf.can_dinein)) : false,
    can_pickup: conf ? Boolean(Number(conf.can_pickup)) : false,
    city: restorant ? restorant.city : "",
    postal_code: restorant ? restorant.postal_code : "",
    currency: conf ? conf.currency : "",
    banner: restorant ? restorant.banner : "",
    logo: restorant ? restorant.logo : "",
    instagram: restorant ? restorant.instagram : "",
    facebook: restorant ? restorant.facebook : "",
    twitter: restorant ? restorant.twitter : "",
    delivery_info: props.confs.delivery_info ?? '',
    _method: "patch",
});
const results = ref();

const update = () => {    
    Inertia.post(
        route("owner.restorant.update", { restorant: restorant.id }),
        form,
        {
            onSuccess: () => {
                Swal.fire({
                    icon: "success",
                    title: "Updated Successfully!",
                    timer: 1000,
                });
            },
        }
    );
};
</script>

<style scoped>
@media (min-width: 1024px) {
    .bannerPreviewWrapper {
        display: block;
        width: 700px;
        height: 300px;
        cursor: pointer;
        background-size: cover;
        background-position: center center;
    }
}

@media (max-width: 1024px) {
    .bannerPreviewWrapper {
        display: block;
        width: 360px;
        height: 200px;
        cursor: pointer;
        background-size: cover;
        background-position: center center;
    }
}

.logoPreviewWrapper {
    display: block;
    width: 100px;
    height: 100px;
    cursor: pointer;
    background-size: cover;
    background-position: center center;
}
</style>
