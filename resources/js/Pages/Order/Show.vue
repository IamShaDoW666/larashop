<template>
    <Admin>
        <section class="mt-8 rounded shadow bg-gray-300 text-blueGray-600">
            <div
                class="bg-gray-800 text-white py-4 sm:py-6 rounded flex items-center justify-between px-4"
            >
                <div class="flex gap-x-2 items-center">
                    <h1
                        class="font-bold sm:text-2xl bg-green-800 rounded-full py-2 px-1.5"
                    >
                        #{{ order.id }}
                    </h1>
                </div>
                <div class="flex items-center gap-x-2">
                    <div class="flex flex-col gap-y-2 items-center">
                        <OrderStatusBadge :status="order.status" />
                        <OrderTypeBadge :type="order.order_type" />
                    </div>
                    <div class="flex flex-col justify-around">
                        <span class="text-sm">{{
                            order.ordered_at_datetime.date
                        }}</span>
                        <span
                            @click="
                                ordered_time = switchTimeFormat(
                                    ordered_time,
                                    order.ordered_at_datetime.time,
                                    order.ordered_at_datetime.time_24
                                )
                            "
                            class="text-sm cursor-pointer hover:text-gray-400"
                            >{{ ordered_time }}</span
                        >
                    </div>
                </div>
            </div>
            <div class="mt-4">
                <!-- <p>{{ JSON.stringify(order) }}</p> -->
            </div>
        </section>
       <div class="max-w-7xl mx-auto">


    <div class="p-10">

        <div class="grid grid-cols-1 gap-5 sm:grid-cols-2">

            <div class="flex flex-col">
           <h2 class="text-4xl sm:py-5">{{ $page.props.auth.restorant ? $page.props.auth.restorant.name : 'Restaurant Name'}}</h2>
                <span class="text-gray-500">{{ $page.props.auth.restorant ? $page.props.auth.restorant.phone : '' }}</span>
                <span class="text-gray-500 mt-4">{{ $page.props.auth.restorant ? $page.props.auth.restorant.address : '' }}</span>
            </div>

            <div class="flex flex-col sm:justify-end sm:items-end">
                <h2 class="text-4xl text-gray-500 sm:py-5">Receipt</h2>

                <dl class="max-w-1/2">
                    <div class="grid grid-cols-2 items-end">
                        <dt class="text-gray-500 ">
                            Receipt number
                        </dt>
                        <dd class="text-right">
                            RF-310205
                        </dd>
                    </div>
                    <div class="grid grid-cols-2">
                        <dt class="text-gray-500">
                            Invoice number
                        </dt>
                        <dd class="text-right">
                            100205
                        </dd>
                    </div>
                    <div class="grid grid-cols-2">
                        <dt class="text-gray-500">
                            Date paid
                        </dt>
                        <dd class="text-right">
                            Dec 14, 2016
                        </dd>
                    </div>
                    <div class="grid grid-cols-2">
                        <dt class="text-gray-500">
                            Payment method
                        </dt>
                        <dd class="text-right">
                            PayPal
                        </dd>
                    </div>
                </dl>

            </div>

            <div class="md:col-span-2">
                <h4 class="text-lg">Customer Info</h4>
                <p class="text-gray-500">{{ order.customer_name }}</p>
                <p class="text-gray-500">{{ order.customer_phone }}</p>
            </div>

        </div>

        <div class="flex flex-col">

           

            <div class="overflow-auto mt-4">
                <table class="min-w-full">
                    <thead class="text-bold rounded shadow bg-gray-300">
                    <tr>
                        <th scope="col"
                            class="text-left w-2/5 sm:px-8 px-4 py-4">
                            #
                        </th>
                        <th scope="col"
                            class="text-left w-2/5 sm:px-8 px-4 py-4">
                            Name
                        </th>
                        <th scope="col"
                            class="text-left w-1/5 sm:px-8 px-4 py-4">
                            Qty
                        </th>
                        <th scope="col"
                            class="text-left w-1/5 sm:px-8 px-4 py-4">
                            Unit price
                        </th>
                        <th scope="col"
                            class="text-right w-1/5 sm:px-8 px-4 py-4">
                            Amount
                        </th>
                    </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-200">
                    <tr v-for="(item, index) in order.items" :key="item.id" class="text-left bg-gray-50">
                        <td class="sm:px-8 px-4 py-4">
                            {{ index + 1 }}
                        </td>
                        <td class="sm:px-8 px-4 py-4">
                            {{ item.name }}
                        </td>
                        <td class="sm:px-8 px-4 py-4">
                            {{ item.pivot_quantity }}
                        </td>
                        <td class="sm:px-8 px-4 py-4">
                            {{ item.price }}
                        </td>
                        <td class="sm:px-8 px-4 py-4 text-right">
                            {{ item.subtotal_formatted }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="">
                            &nbsp;
                        </td>
                        <td class="sm:px-8 px-4 py-4">
                            Subtotal
                        </td>
                        <td class="sm:px-8 px-4 py-4 text-right">
                            {{ order.total }}
                        </td>
                    </tr>
                    <tr v-if="order.order_type == 1">
                        <td colspan="3" class="">
                            &nbsp;
                        </td>
                        <td class="sm:px-8 px-4 py-4">
                            Delivery
                        </td>
                        <td class="sm:px-8 px-4 py-4 text-right">
                            {{ order.delivery_fee }}
                        </td>
                    </tr>
                    <tr>
                        <td colspan="3" class="">
                            &nbsp;
                        </td>
                        <td class="sm:px-8 px-4 py-4 bg-gray-300 font-bold">
                            Total
                        </td>
                        <td class="sm:px-8 px-4 py-4 text-right bg-gray-300 font-bold">
                            {{ order.total }}
                        </td>
                    </tr>
                    </tbody>
                </table>

            </div>

        </div>

    </div>


</div>
 
    </Admin>
</template>

<script setup>
import Admin from "@/Layouts/Admin.vue";
import OrderStatusBadge from "@/Components/Badges/OrderStatusBadge.vue";
import OrderTypeBadge from "@/Components/Badges/OrderTypeBadge.vue";
import useCommon from "@/utils/common";
import { ref } from "vue";

const { switchTimeFormat } = useCommon();
const props = defineProps({
    order: Object,
});
const ordered_time = ref(props.order.ordered_at_datetime.time);

</script>
