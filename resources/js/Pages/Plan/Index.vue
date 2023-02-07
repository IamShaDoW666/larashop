<template>
    <HeadlessPlan v-if="planOpen" />
    <HeadlessPlanEdit v-if="editPlan" />
    <Super>
        <div class="max-w-5xl gap-4 mx-auto grid grid-cols-2 m-4">
            
            <button @click="planOpen= true" class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white font-bold text-sm active:bg-blue-500">Add New Plan</button>
           
            
            <div class="rounded p-4 shadow-lg bg-white rounded" v-for="(plan, index) in plans">
                <h1 class="text-xl font-semibold">{{ plan.name }}</h1>
                <h3 class="text-sm mb-4 font-bold">{{ plan.price }}</h3>
                <h3 class="text-sm mb-4 font-bold">{{ plan.items }}</h3>
                <div class="flex justify-between">
                <button @click="showEdit(plan)" class="px-4 py-2 rounded bg-red-500 hover:bg-red-700 text-white font-bold text-sm active:bg-red-500">Edit</button>
                <button @click="deletePlan(plan.id)" class="px-4 py-2 rounded bg-red-500 hover:bg-red-700 text-white font-bold text-sm active:bg-red-500">Remove</button>

            </div>
        </div>
    </div>
    </Super>
</template>

<script setup>
import Super from "@/Layouts/Super.vue";
import { ref,provide } from "vue";
import { Inertia } from "@inertiajs/inertia";
import HeadlessPlan from '@/Components/Dialogs/HeadlessPlan.vue';
import HeadlessPlanEdit from '@/Components/Dialogs/HeadlessPlanEdit.vue';



const planOpen = ref(false);
const editPlan = ref(false);
const dPlan = ref({});
const props = defineProps({
    plans: Object
})

const deletePlan = (id) => {
    Inertia.delete(route('super.plans.destroy', {plan: id}))
}

const showEdit = (plan) => {
    editPlan.value = !editPlan.value
    dPlan.value = plan
  
}

provide('data', {
  planOpen,
  editPlan,
  dPlan
})


</script>
