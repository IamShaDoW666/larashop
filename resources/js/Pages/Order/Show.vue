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
