<template>
    <Admin :headerStats="false">
        <Head title="Plan" />
        <div v-if="loading" class="fixed inset-0 bg-black bg-opacity-25"></div>
        <div v-if="loading" class="loader center-fixed fixed"></div>
        <div
            v-if="plans.length"
            class="max-w-5xl gap-4 mx-auto grid grid-cols-2 m-4"
        >
            <div
                :class="{
                    'bg-green-500': currentPlan
                        ? currentPlan.id === plan.id
                        : false,
                }"
                class="rounded p-4 shadow-lg rounded"
                v-for="(plan, index) in plans"
                :key="plan.id"
            >
                <h1 class="text-xl font-semibold">{{ plan.name }}</h1>
                <h3 class="text-sm mb-4 font-bold">{{ plan.price }}</h3>
                <h3 class="text-sm mb-4 font-bold">{{ plan.items }}</h3>
                <div class="flex justify-between">
                    <button
                        @click="razorpay(plan)"
                        v-if="!$page.props.impersonate"
                        class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white font-bold text-sm active:bg-blue-500"
                    >
                        Select
                    </button>
                    <button
                        @click="assignPlan(plan.id)"
                        v-if="$page.props.impersonate"
                        class="px-4 py-2 rounded bg-blue-500 hover:bg-blue-700 text-white font-bold text-sm active:bg-blue-500"
                    >
                        Assign
                    </button>
                    <button
                        @click="removePlan(plan.id)"
                        v-if="
                            $page.props.impersonate &&
                            (currentPlan ? currentPlan.id === plan.id : false)
                        "
                        class="px-4 py-2 rounded bg-red-500 hover:bg-red-700 text-white font-bold text-sm active:bg-red-500"
                    >
                        Remove
                    </button>
                </div>
            </div>
        </div>
    </Admin>
</template>

<script setup>
import Admin from "@/Layouts/Admin.vue";
import { Inertia } from "@inertiajs/inertia";
import { Head, usePage } from "@inertiajs/inertia-vue3";
import { onMounted, ref } from "vue";
import Swal from "sweetalert2";
const loading = ref(false);
const props = defineProps({
    plans: Object,
    currentPlan: Object,
});

const loadRazorPay = () => {
    return new Promise((resolve) => {
        const script = document.createElement("script");
        script.src = "https://checkout.razorpay.com/v1/checkout.js";
        script.onload = () => {
            resolve(true);
        };
        document.body.appendChild(script);
    });
};

const razorpay = (plan) => {
    loading.value = true;
    axios
        .post(route("owner.grocery.plan.pay.razorpay"), {
            grocery: usePage().props.value.auth.grocery.id,
            amount: plan.price_int,
        })
        .then((res) => {
            loading.value = false;
            const options = {
                key: "rzp_test_XJj4QGo5nLEoAa", //secret = Q4gMFuW2X7QyT9i9FYOOCV3p
                amount: plan.price_int,
                currency: "INR",
                name: "Spot",
                description: "",
                //${usePage().props.value.app.url}${usePage().props.auth.grocery.logo}_logo.webp
                order_id: res.data,
                handler: function (response) {
                    loading.value = true;
                    Inertia.post(
                        route("owner.grocery.plan.buy", {
                            grocery: usePage().props.value.auth.grocery.id,
                        }),
                        {
                            plan: plan.id,
                            payment_method: "razorpay",
                        },
                        {
                            onSuccess: () => {
                                Swal.fire("Plan purchased!", "", "success");
                                loading.value = false;
                            },
                        }
                    );
                },
                prefill: {
                    name: usePage().props.value.auth.user.name,
                    // "email": "gaurav.kumar@example.com",
                    contact: usePage().props.value.auth.user.phone,
                },
                notes: {
                    address: "Razorpay Corporate Office",
                },
                theme: {
                    color: "#3399cc",
                },
            };
            var rzp1 = new Razorpay(options);
            rzp1.open();
        })
        .catch((err) => {
            loading.value = false;
            console.log(err);
        });
};

onMounted(async () => {
    const loadedRazorPay = await loadRazorPay();
});

const assignPlan = (id) => {
    if (usePage().props.value.impersonate) {
        Inertia.post(
            route("super.groceries.assignPlan", {
                grocery: usePage().props.value.auth.grocery.id,
            }),
            { plan: id }
        );
    }
};

const selectPlan = (id) => {};

const removePlan = (id) => {
    if (usePage().props.value.impersonate) {
        Inertia.post(
            route("super.groceries.removePlan", {
                grocery: usePage().props.value.auth.grocery.id,
            })
        );
    }
};
</script>

<style scoped>
.loader {
    border: 16px solid #f3f3f3;
    /* Light grey */
    border-top: 16px solid #3498db;
    /* Blue */
    border-radius: 50%;
    width: 120px;
    height: 120px;
    animation: spin 2s linear infinite;
    position: fixed;
}

.center-fixed {
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
}

@keyframes spin {
    0% {
        transform: rotate(0deg);
    }

    100% {
        transform: rotate(360deg);
    }
}
</style>
