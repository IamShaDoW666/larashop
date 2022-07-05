<template>
    <Admin :headerStats="false">
        <Head title="Orders" />
        <div
            class="relative flex mt-2 sm:mt-4 flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0"
        >
            <div class="rounded-t bg-slate-50 mb-0 px-6 py-6">
                <div class="text-center flex justify-between">
                    <h6 class="text-gray-700 text-xl font-bold">Orders</h6>
                    <!-- <button @click="areaOpen = true" class="px-4 py-2 text-sm rounded shadow bg-blue-500 text-white hover:bg-blue-700">Create</button> -->
                </div>
            </div>

            <div class="overflow-x-auto" v-if="orders.data.length">
                <table class="table table-compact w-full">
                    <thead>
                        <tr>
                            <th
                                class="text-center"
                                style="z-index: 0 !important"
                            >
                                ID
                            </th>
                            <th>Status</th>
                            <th>Order Type</th>
                            <th>Total</th>
                            <th>Ordered</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr v-for="order in orders.data" :key="order.id">
                            <th
                                class="text-center"
                                style="z-index: 0 !important"
                            >
                                <Link :href="route('admin.orders.show', { order: order.id })" >
                                    <span
                                        class="text-sm cursor-pointer font-medium mr-2 px-3 py-0.5 rounded-full bg-green-200 hover:bg-green-300 text-green-800"
                                    >
                                        #{{ order.id }}
                                    </span>
                                </Link>
                            </th>
                            <td>
                                <OrderStatusBadge :status="order.status" />
                            </td>
                            <td>
                                <OrderTypeBadge :type="order.order_type" />
                            </td>
                            <td>{{ order.total }}</td>
                            <td>{{ order.ordered_at }}</td>
                            <td>
                                <OrderButton
                                    class="mr-3 mb-2 lg:mb-0"
                                    @click="
                                        updateStatus(order.status, order.id)
                                    "
                                    :status="order.status"
                                />
                                <OrderButton
                                    :reject="true"
                                    v-if="order.status == 'pending'"
                                    @click="
                                        updateStatus(
                                            order.status,
                                            order.id,
                                            false
                                        )
                                    "
                                />
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
            <div
                v-else
                class="p-12 text-center md:text-3xl text-xl flex justify-center items-center"
            >
                No orders yet
                <i class="material-icons align-center text-3xl ml-2"
                    >more_horiz</i
                >
            </div>
            <Pagination class="py-2 ml-2" :links="orders.meta.links" />
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
import { Head, usePage, Link } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";

const props = defineProps({
    orders: Object,
});

const updateStatus = async (status, id, accept = true) => {
    if (status != "rejected" && status != "closed") {
        await Inertia.post(
            route("admin.orders.update-status", { order: id }),
            {
                current_status: status,
                action: accept,
            },
            {
                preserveScroll: true,
                onSuccess: () => {
                    const Toast = Swal.mixin({
                        toast: true,
                        position: "top-end",
                        showConfirmButton: false,
                        timer: 1500,
                        timerProgressBar: true,
                        didOpen: (toast) => {
                            toast.addEventListener(
                                "mouseenter",
                                Swal.stopTimer
                            );
                            toast.addEventListener(
                                "mouseleave",
                                Swal.resumeTimer
                            );
                        },
                    });

                    Toast.fire({
                        icon: "success",
                        title: usePage().props.value.flash.message,
                    });
                },
            }
        );
    }
};
</script>
