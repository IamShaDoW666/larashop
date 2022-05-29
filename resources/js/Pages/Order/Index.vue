<template>
    <Admin :headerStats="false">

        <Head title="Orders" />
        <div 
            class="relative flex mt-2 sm:mt-4 flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
            <div class="rounded-t bg-slate-50 mb-0 px-6 py-6">
                <div class="text-center flex justify-between">
                    <h6 class="text-gray-700 text-xl font-bold">Orders</h6>
                    <!-- <button @click="areaOpen = true" class="px-4 py-2 text-sm rounded shadow bg-blue-500 text-white hover:bg-blue-700">Create</button> -->
                </div>
            </div>
            <div v-if="orders" class="flex-auto">
                <table class="min-w-full border-collapse block lg:table lg:table-fixed rounded-lg">
                    <thead class="block lg:table-header-group">
                        <tr
                            class="block border border-slate-400 lg:table-row absolute -top-full lg:top-auto -left-full lg:left-auto lg:relative ">
                            <th
                                class="bg-slate-200 p-2 text-slate-600 font-bold lg:border lg:border-slate-400 text-left sm:text-center block lg:table-cell">
                                No</th>
                            <th
                                class="bg-slate-200 p-2 text-slate-600 font-bold lg:border lg:border-slate-400 text-left sm:text-center block lg:table-cell">
                                Status</th>
                            <th
                                class="bg-slate-200 p-2 text-slate-600 font-bold lg:border lg:border-slate-400 text-left sm:text-center block lg:table-cell">
                                Order Type</th>
                            <th
                                class="bg-slate-200 p-2 text-slate-600 font-bold lg:border lg:border-slate-400 text-left sm:text-center block lg:table-cell">
                                Total</th>
                            <th
                                class="bg-slate-200 p-2 text-slate-600 font-bold lg:border lg:border-slate-400 text-left sm:text-center block lg:table-cell">
                                Ordered</th>
                            <th
                                class="bg-slate-200 p-2 text-slate-600 font-bold lg:border lg:border-slate-400 text-left sm:text-center block lg:table-cell">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody class="block lg:table-row-group">
                        <tr v-for="order in orders.data" :key="order.id"
                            class="bg-gray-300 border border-slate-400 lg:border-none block lg:table-row">
                            <td class="p-2 lg:border lg:border-slate-400 text-left lg:text-center block lg:table-cell">
                                <span class="inline-block w-1/3 lg:hidden font-bold">No:</span>
                                <span :class="classes"
                                    class="text-sm font-medium mr-2 px-3 py-0.5 rounded-full bg-green-200 text-green-800">
                                    #{{ order.id }}
                                </span>
                            </td>
                            <td class="p-2 lg:border lg:border-slate-400 text-left lg:text-center block lg:table-cell">
                                <span class="inline-block w-1/3 lg:hidden font-bold">
                                    Status:
                                </span>
                                <OrderStatusBadge :status="order.status" />
                            </td>
                            <td class="p-2 lg:border lg:border-slate-400 text-left lg:text-center block lg:table-cell">
                                <span class="inline-block w-1/3 lg:hidden font-bold">
                                    Order Type:
                                </span>
                                <OrderTypeBadge :type="order.order_type" />
                            </td>
                            <td class="p-2 lg:border lg:border-slate-400 text-left block lg:table-cell">
                                <span class="inline-block w-1/3 lg:hidden font-bold">
                                    Total:
                                </span>
                                {{ order.total }}
                            </td>
                            <td class="p-2 lg:border lg:border-slate-400 text-left block lg:table-cell">
                                <span class="inline-block w-1/3 lg:hidden font-bold">
                                    Ordered:
                                </span>
                                {{ order.ordered_at }}
                            </td>
                            <td class="p-2 lg:border lg:border-slate-400 text-left block lg:table-cell">
                                <span class="inline-block w-1/3 lg:hidden font-bold">Actions</span>
                                <OrderButton class="mr-3 mb-2 lg:mb-0" @click="updateStatus(order.status, order.id)"
                                    :status="order.status" />
                                <OrderButton :reject="true" v-if="order.status == 'pending'"
                                    @click="updateStatus(order.status, order.id, false)" />
                            </td>
                        </tr>
                    </tbody>
                </table>
                <Pagination class="mt-4 pb-2 mx-auto px-4" :links="orders.meta.links" />
            </div>
            <div class="p-12 text-center md:text-3xl text-xl flex justify-center items-center" v-else>
                No orders yet <i class="material-icons align-center text-3xl ml-2">more_horiz</i>
            </div>
        </div>
    </Admin>
</template>

<script setup>
import Admin from "@/Layouts/Admin.vue";
import OrderButton from "@/Components/Buttons/OrderButton.vue";
import OrderStatusBadge from "@/Components/Badges/OrderStatusBadge.vue";
import OrderTypeBadge from "@/Components/Badges/OrderTypeBadge.vue";
import Pagination from "@/Components/Pagination/Pagination.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";

const props = defineProps({
    orders: Object
})


const updateStatus = async (status, id, accept = true) => {
    if (status != 'rejected' && status != 'closed') {
        await Inertia.post(route('admin.orders.update-status', { order: id }), {
            current_status: status,
            action: accept
        },
            {
                preserveScroll: true,
                onSuccess: () => {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener('mouseenter', Swal.stopTimer)
                            toast.addEventListener('mouseleave', Swal.resumeTimer)
                        }
                    })

                    Toast.fire({
                        icon: 'success',
                        title: usePage().props.value.flash.message
                    })
                }
            })
    }
}

</script>
