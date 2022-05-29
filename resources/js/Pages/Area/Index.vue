<template>
  <Admin :headerStats="false" >
    <Head title="Areas" />
    <HeadlessArea />
    <HeadlessAreaEdit v-if="areaOpenEdit" />
    <div class="relative flex mt-2 sm:mt-4
       flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
       <div class="rounded-t bg-white mb-0 px-6 py-6">
          <div class="text-center flex justify-between">
             <h6 class="text-gray-700 text-xl font-bold">Delivery Areas</h6>
             <button @click="areaOpen = true" class="px-4 py-2 text-sm rounded shadow bg-blue-500 text-white hover:bg-blue-700">Create</button>
          </div>
       </div>
       <div class="flex-auto px-4 lg:px-10 py-10">
         <table class="min-w-full border-collapse block md:table rounded-lg">
           <thead class="block md:table-header-group">
             <tr class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
               <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">No</th>
               <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Area</th>
               <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Delivery Charge</th>
               <th class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">Actions</th>
             </tr>
           </thead>
           <tbody class="block md:table-row-group">
             <tr v-for="(area, index) in areas" class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
               <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">No:</span>{{ index+1 }}</td>
               <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span class="inline-block w-1/3 md:hidden font-bold">Area:</span>{{ area.name }}</td>
               <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                 <span class="inline-block w-1/3 md:hidden font-bold">
                   Delivery Charge:
                 </span>
                 {{ area.delivery_fee }}
               </td>
               <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                 <span class="inline-block w-1/3 md:hidden font-bold">Actions</span>
                 <button @click="openAreaEdit(area)" class="ml-2 mr-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">Edit</button>
                <button @click="deleteArea(area.id)" class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded">Delete</button>
               </td>
             </tr>
           </tbody>
         </table>
       </div>
    </div>
  </Admin>
</template>

<script setup>
import axios from "axios";
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { onMounted, computed, ref, reactive, provide } from 'vue';
import { Inertia } from '@inertiajs/inertia';

import Admin from "@/Layouts/Admin.vue";
import CardStats from "@/Components/Cards/CardStats.vue";
import HeadlessArea from '@/Components/Dialogs/HeadlessArea.vue';
import HeadlessAreaEdit from '@/Components/Dialogs/HeadlessAreaEdit.vue';
import Swal from 'sweetalert2';

const props = defineProps({
  areas: Object
})

const areaOpen = ref(false);
const areaOpenEdit = ref(false);
const dArea = ref({});

const openAreaEdit = (area) => {
  dArea.value = area
  areaOpenEdit.value = true
}

const deleteArea = (id) => {
  Swal.fire({
    title: 'Are you sure?',
    text: 'Area will be deleted permanently',
    showDenyButton: true,
    confirmButtonText: 'Yes',
    denyButtonText: 'No',
  }).then((result) => {
    if (result.isConfirmed) {
      Inertia.delete(route('areas.destroy', { area: id }), {
        onSuccess: () => {
          Swal.fire({
            icon: 'success',
            title: 'Delivery Area Deleted!',
            timer: 1500
          })
        }
      })
    } else if (result.isDenied) {
      Swal.fire({
        icon: 'info',
        title: 'Changes are not saved',
        timer: 1000
      })
    }
  })
}

provide('data', {
  areaOpen,
  areaOpenEdit,
  areas: props.areas,
  dArea,
})



</script>
