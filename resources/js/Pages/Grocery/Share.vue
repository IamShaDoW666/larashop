<template>
    <Admin :headerStats="false">

        <Head title="Products" />
        <!--<div class="-mt-2 md:mt-0 mx-auto bg-gray-100">
            <div class="w-full mx-auto sm:mt-4 bg-gray-100 rounded-lg px-4 py-12">
           
                <div class="mx-auto p-5 text-center bg-slate-300 rounded-lg shadow">
                    <span class="rounded shadow text-sm font-bold bg-slate-200 px-2 py-1.5">{{ $page.props.auth.grocery.name }}</span>
                    <h2 class="text-xl md:text-3xl font-semibold mt-4">
                        Scan QR code to view store
                    </h2>
                </div>
            </div>
        </div>-->
		<div class="mx-auto p-5 text-center bg-slate-300 rounded-lg shadow">
            <h2 class="text-xl md:text-3xl font-semibold mt-4">
                QR CODE FOR YOUR STORE
            </h2>
        </div>
        <div class="grid grid-cols gap-12 place-content-center mt-16 h-48">
             <qrcode-vue
                :value="value"
                :size="size"
                :margin="margin"
                :background="background"
                level="H"
            /> 
        </div>
        <input type="number" v-model="spot">
        <button @click="pramod" class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5" >hello</button>
        <div class="grid grid-cols gap-12 place-content-center mt-16 h-12">
            <button
                @click="downloadQrCode"
                class="text-white bg-gradient-to-br from-purple-600 to-blue-500 hover:bg-gradient-to-bl focus:ring-4 focus:outline-none focus:ring-blue-300 dark:focus:ring-blue-800 font-medium rounded-lg text-sm px-5 py-2.5 text-center mr-2 mb-2"
            >
                Download QRcode
            </button>
        </div>
    </Admin>
</template>

<script setup>
import Admin from "@/Layouts/Admin.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import QrcodeVue from "qrcode.vue";
import { computed, ref } from "vue";
import { Inertia } from "@inertiajs/inertia";
//let url = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + usePage().props.value.app.url + '/grocerys/' + usePage().props.value.auth.grocery.slug


const value = usePage().props.value.app.url+ '/grocerys/' + usePage().props.value.auth.grocery.slug;
const margin = 2;
const size = ref(200);
const spot = ref(150)
const background = "#fff";
const pramod = () => {
    size.value = spot.value
}
const downloadQrCode = () => {
     let canvasImage = document
         .getElementsByTagName("canvas")[0]
         .toDataURL("image/png");
     let xhr = new XMLHttpRequest();
     xhr.responseType = "blob";
     xhr.onload = function () {
         let a = document.createElement("a");
         a.href = window.URL.createObjectURL(xhr.response);
         a.download = "qrcode.png";
         a.style.display = "none";
       document.body.appendChild(a);
         a.click();
         a.remove();
     };
     xhr.open("GET", canvasImage);
     xhr.send();
};
</script>

