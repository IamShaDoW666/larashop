<template>
    <Head title="Dashboard" />
    <Super>
      <div class="relative flex mt-2 sm:mt-4
       flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
      <div class="rounded-t bg-white mb-0 px-6 py-6">
        <div class="text-center flex justify-between">
          <h6 class="text-gray-700 text-xl font-bold">Groceries</h6>
          <button
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
                Grocery Name</th>
              <th
                class="bg-gray-600 p-2 text-slate-500 font-bold md:border md:border-grey-500 text-left block md:table-cell">
                Email</th>
              <th
                class="bg-gray-600 p-2 text-slate-500 font-bold md:border md:border-grey-500 text-left block md:table-cell">
                Actions</th>
            </tr>
          </thead>
          <tbody class="block md:table-row-group">
            <tr v-for="(grocery, index) in groceries" :key="grocery.id"
              class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
              <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                  class="inline-block w-1/3 md:hidden font-bold">No:</span>{{ index+1 }}</td>
              <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                  class="inline-block w-1/3 md:hidden font-bold">Grocery Name:</span>{{ grocery.name }}</td>
              <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                <span class="inline-block w-1/3 md:hidden font-bold">
                  Delivery Charge:
                </span>
                {{ grocery.email }}
              </td>
              <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                <span class="inline-block w-1/3 md:hidden font-bold">Actions</span>
                <button @click="loginShow(grocery.id)"
                  class="ml-2 mr-3 bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-2 border border-blue-500 rounded">Login As</button>
                <button @click= "deleteStore(grocery.id)"
                  class="bg-red-500 hover:bg-red-700 text-white font-bold py-1 px-2 border border-red-500 rounded">Delete</button>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
    </Super>
</template>
<script setup>
import { Head, Link} from '@inertiajs/inertia-vue3';
import Super from "@/Layouts/Super.vue";
import { Inertia } from "@inertiajs/inertia";
const props = defineProps({
    groceries: Object,
});

const deleteStore = (id) => {
    Inertia.delete(route('super.groceries.destroy', id))
}
const loginShow = (id) => {
    Inertia.post(route('super.loginShow'), {id: id})
}

</script>