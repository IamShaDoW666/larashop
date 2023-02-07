<template>
  <Admin :headerStats="false">
<HeadlessTable />
<HeadlessTableEdit v-if="tableOpenEdit" />
    <div class="relative flex mt-2 sm:mt-4
       flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
    <div class="rounded-t bg-white mb-0 px-6 py-6">
        <div class="text-center flex justify-between">
          <h6 class="text-gray-700 text-xl font-bold">Tables</h6>
          <button @click="tableOpen = true"
            class="px-4 py-2 text-sm rounded shadow bg-blue-500 text-white hover:bg-blue-700">Create</button>
        </div>
    </div>
<div class="flex-auto px-4 lg:px-10 py-10">
        <table class="min-w-full border-collapse block md:table rounded-lg">
          <thead class="block md:table-header-group">
            <tr
              class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
              <th style="z-index: 0!important"
                class="bg-gray-600 p-2 text-slate-500 font-bold md:border md:border-grey-500 text-left block md:table-cell">
                ID</th>
              <th
                class="bg-gray-600 p-2 text-slate-500 font-bold md:border md:border-grey-500 text-left block md:table-cell">
                Table</th>
              <th
                class="bg-gray-600 p-2 text-slate-500 font-bold md:border md:border-grey-500 text-left block md:table-cell">
                Table Number</th>
              <th
                class="bg-gray-600 p-2 text-slate-500 font-bold md:border md:border-grey-500 text-left block md:table-cell">
                Actions</th>
            </tr>
          </thead>
          <tbody class="block md:table-row-group">
            <tr v-for="(table, index) in tables"
              class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
              <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                  class="inline-block w-1/3 md:hidden font-bold">No:</span>{{ index+1 }}</td>
              <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                  class="inline-block w-1/3 md:hidden font-bold">Area:</span>{{ table.name }}</td>
              <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                <span class="inline-block w-1/3 md:hidden font-bold">
                  Delivery Charge:
                </span>
                {{ table.number }}
              </td>
              <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                <span class="inline-block w-1/3 md:hidden font-bold">Actions</span>
                <a :href="route('tables.qrcode', {table: table.id})"
                  class="ml-2 mr-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">Download</a>
                  <button @click="openTableEdit(table)"
                  class="ml-2 mr-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">Edit</button>
                <button @click="deleteTable(table.id)"
                  class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </Admin>
</template>

<script setup>
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { onMounted, computed, ref, reactive, provide } from 'vue';
import { Inertia } from '@inertiajs/inertia';
import HeadlessTable from '@/Components/Dialogs/HeadlessTable.vue';
import HeadlessTableEdit from '@/Components/Dialogs/HeadlessTableEdit.vue';
import Admin from "@/Layouts/Admin.vue";
import CardStats from "@/Components/Cards/CardStats.vue";
import Swal from 'sweetalert2';
const props = defineProps({
  tables: Object
})
const tableOpen = ref(false);
const tableOpenEdit = ref(false);
const dTable = ref({});
const openTableEdit = (table) => {
  dTable.value = table
  tableOpenEdit.value = true
}

const deleteTable = (id) => {
  Swal.fire({
    title: 'Are you sure?',
    text: 'Area will be deleted permanently',
    showDenyButton: true,
    confirmButtonText: 'Yes',
    denyButtonText: 'No',
  }).then((result) => {
    if (result.isConfirmed) {
      Inertia.delete(route('tables.destroy', { table: id }), {
        onSuccess: () => {
          Swal.fire({
            icon: 'success',
            title: 'Table Deleted!',
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
  tableOpen,
  tableOpenEdit,
  tables: props.tables,
  dTable,
})



</script>
