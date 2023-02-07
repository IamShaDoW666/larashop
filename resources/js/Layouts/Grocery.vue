<template>
    <div
        class="relative flex flex-col min-w-0 break-words w-full mb-6 mt-4 shadow-lg rounded-lg bg-blueGray-100 border-0"
    >
        <div class="flex items-center gap-x-4 mx-4 my-4">
            <Link
                :href="route('owner.grocery.index')"
                class="flex justify-between items-center px-4 py-2 bg-emerald-500 rounded shadow cursor-pointer hover:bg-emerald-400"
            >
                <span class="font-semibold text-white text-sm mr-2">Main</span>
                <span class="material-icons text-white">home</span>
            </Link>

            <Link
                :href="route('owner.grocery.apps')"
                class="flex justify-between items-center px-4 py-2 bg-emerald-500 rounded shadow cursor-pointer hover:bg-emerald-400"
            >
                <span class="font-semibold text-white text-sm mr-2">Apps</span>
                <span class="material-icons text-white">settings</span>
            </Link>

            <Link :href="route('owner.grocery.payments')"
                class="flex justify-between items-center px-4 py-2 bg-emerald-500 rounded shadow cursor-pointer hover:bg-emerald-400"
            >
                <span class="font-semibold text-white text-sm mr-2">Payment</span>
                <span class="material-icons text-white">payment</span>
            </Link>
            <Link :href="route('owner.grocery.smtp')"
                class="flex justify-between items-center px-4 py-2 bg-emerald-500 rounded shadow cursor-pointer hover:bg-emerald-400"
            >
                <span class="font-semibold text-white text-sm mr-2">SMTP</span>
                <span class="material-icons text-white">email</span>
            </Link>
        </div>
        <slot />
    </div>
</template>

<script setup>
import { Link } from '@inertiajs/inertia-vue3';


</script>
