<template>
<Head title="Dashboard" />
    <Super>
        <div v-for="grocery in groceries" :key="grocery.id">
            <h1>{{ grocery.name }}</h1>
            <button @click="deleteStore(grocery.id)" class="rounded shadow px-4 py-2 bg-red-400 text-white">Delete</button>
        </div>
    </Super>
</template>
<script setup>
import { Head, Link } from "@inertiajs/inertia-vue3";
import Super from "@/Layouts/Super.vue";
import { Inertia } from "@inertiajs/inertia";
const props = defineProps({
    groceries: Object,
});
const deleteStore = (id) => {
    Inertia.delete(route('super.groceries.destroy', id))
}
</script>
