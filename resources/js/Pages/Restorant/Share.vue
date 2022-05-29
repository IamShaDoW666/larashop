<template>
    <Admin :headerStats="false">

        <Head title="Products" />
        <div class="-mt-2 md:mt-0 mx-auto bg-gray-100">
            <div class="w-full mx-auto sm:mt-4 bg-gray-100 rounded-lg px-4 py-12">
                <img id="img" class="mx-auto mb-4" :src="url">
                <div class="mx-auto p-5 text-center bg-slate-300 rounded-lg shadow">
                    <span class="rounded shadow text-sm font-bold bg-slate-200 px-2 py-1.5">{{ $page.props.auth.restorant.name }}</span>
                    <h2 class="text-xl md:text-3xl font-semibold mt-4">
                        Scan QR code to view restaurant
                    </h2>
                </div>
            </div>
        </div>
    </Admin>
</template>

<script setup>
import Admin from "@/Layouts/Admin.vue";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import { computed, ref } from "vue";

let url = 'https://api.qrserver.com/v1/create-qr-code/?size=150x150&data=' + usePage().props.value.app.url + '/restorants/' + usePage().props.value.auth.restorant.slug

</script>