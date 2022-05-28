<template>
    <Admin :headerStats="false">

        <Head title="Orders" />
        <div class="relative flex mt-2 sm:mt-4
       flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
            <div class="rounded-t bg-white mb-0 px-6 py-6">
                <div class="text-center flex justify-between">
                    <h6 class="text-gray-700 text-xl font-bold">Orders</h6>
                    <!-- <button @click="areaOpen = true" class="px-4 py-2 text-sm rounded shadow bg-blue-500 text-white hover:bg-blue-700">Create</button> -->
                </div>
            </div>
            <div class="flex-auto px-4 lg:px-10 py-10">
                <table class="min-w-full border-collapse block md:table rounded-lg">
                    <thead class="block md:table-header-group">
                        <tr
                            class="border border-grey-500 md:border-none block md:table-row absolute -top-full md:top-auto -left-full md:left-auto  md:relative ">
                            <th
                                class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                No</th>
                            <th
                                class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                Status</th>
                            <th
                                class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                Total</th>
                            <th
                                class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                Ordered</th>
                            <th
                                class="bg-gray-600 p-2 text-white font-bold md:border md:border-grey-500 text-left block md:table-cell">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="block md:table-row-group">
                        <tr v-for="order in restaurant.orders" :key="order.id"
                            class="bg-gray-300 border border-grey-500 md:border-none block md:table-row">
                            <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell"><span
                                    class="inline-block w-1/3 md:hidden font-bold">No:</span>{{ order.id }}</td>
                            <td class="p-2 md:border md:border-grey-500 text-center block md:table-cell">
                                <span class="inline-block w-1/3 md:hidden font-bold">
                                    Status:
                                </span>
                                <OrderStatusBadge :status="order.status" />
                            </td>
                            <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                <span class="inline-block w-1/3 md:hidden font-bold">
                                    Total:
                                </span>
                                {{ order.total }}
                            </td>
                            <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                <span class="inline-block w-1/3 md:hidden font-bold">
                                    Ordered:
                                </span>
                                {{ order.ordered_at }}
                            </td>
                            <td class="p-2 md:border md:border-grey-500 text-left block md:table-cell">
                                <span class="inline-block w-1/3 md:hidden font-bold">Actions</span>
                                <OrderButton class="mr-3" @click="updateStatus(order.status, order.id)"
                                    :status="order.status" />
                                <OrderButton :reject="true" v-if="order.status == 'pending'"
                                    @click="updateStatus(order.status, order.id, false)" />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </Admin>
</template>

<script setup>
import Admin from "@/Layouts/Admin.vue";
import OrderButton from "@/Components/Buttons/OrderButton.vue";
import OrderStatusBadge from "@/Components/Badges/OrderStatusBadge.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head } from "@inertiajs/inertia-vue3";

const props = defineProps({
    restaurant: Object
})


const updateStatus = (status, id, accept = true) => {
    if (status != 'rejected' && status != 'closed') {
        Inertia.post(route('admin.orders.update-status', { order: id }), {
            current_status: status,
            action: accept
        })
    }
}

</script>
