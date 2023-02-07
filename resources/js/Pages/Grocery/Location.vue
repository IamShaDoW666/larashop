<template>
    <Admin :headerStats="false">

        <Head title="Location" />
        <div
            class="relative flex mt-2 sm:mt-4 flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
            <div class="rounded-t bg-gray-800 mb-0 px-6 py-6">
                <div class="text-center">
                    <h6 class="text-center text-white text-xl sm:text-2xl lg:text-3xl font-bold">
                        store Location
                    </h6>
                </div>
            </div>
            <div class="p-5 bg-slate-50">
                <GoogleMap v-if="show" :api-key="googleMapsApiKey" style="width: 100%; height: 500px" :center="center"
                    :zoom="15">
                    <Marker @dragend="setCoordinates" :options="{  position: center, draggable: true }" />
                </GoogleMap>
            </div>
        </div>
    </Admin>
</template>

<script setup>
import Admin from '@/Layouts/Admin.vue';
import { GoogleMap, Marker } from "vue3-google-map";
import { Head, usePage } from '@inertiajs/inertia-vue3';
import { onMounted, reactive, ref } from 'vue';
import axios from 'axios';

// const props = defineProps({
//     googleMapsApiKey: String
// })
const googleMapsApiKey = usePage().props.value.auth.grocery.config.google_maps_api_key;
const show = ref(false)
const center = reactive({
    lat: Number(usePage().props.value.auth.grocery.lat),
    lng: Number(usePage().props.value.auth.grocery.lng),
})

const setLatLng = async () => {
    await axios.post(route('owner.grocery.update-location', { grocery: usePage().props.value.auth.grocery.id }), center).then((res) => {
        console.log(res.data)
    })
}

const setCoordinates = (event) => {
    center.lat = event.latLng.lat()
    center.lng = event.latLng.lng()

    setLatLng();
}

onMounted(() => {
    show.value = true;
})

</script>