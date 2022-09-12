<template>
    <div
        class="mt-8 md:mt-0 bg-white rounded-lg shadow-lg p-8 dark:bg-secondary-dark"
    >
        <form method="POST" @submit.prevent="submit" class="flex flex-col">
            <BreezeValidationErrors class="mb-4" />
            <label class="font-semibold text-xs dark:text-white" for="name"
                >Name</label
            >
            <input
                v-model="form.customer_name"
                class="flex items-center h-12 px-4 w-full bg-gray-200 dark:text-white dark:bg-primary-dark mt-2 mb-2 rounded focus:outline-none focus:ring-2"
                type="text"
            />
            <label
                class="font-semibold text-xs dark:text-white mt-3"
                for="phonenumber"
                >Phone Number</label
            >
            <input
                v-model="form.customer_phone"
                class="flex items-center h-12 px-4 w-full bg-gray-200 dark:text-white dark:bg-primary-dark mt-2 mb-2 rounded focus:outline-none focus:ring-2"
                type="text"
            />
            <label
                class="font-semibold text-xs dark:text-white mt-3 mb-2"
                for="address"
                >Order type</label
            >
            <div class="flex gap-x-2">
                <div
                    class="form-control"
                    v-if="Boolean(Number(restorant.config.can_deliver))"
                >
                    <label class="label cursor-pointer">
                        <span class="label-text mr-2 dark:text-white"
                            >Delivery</span
                        >
                        <input
                            type="radio"
                            id="delivery"
                            v-model="form.order_type"
                            value="1"
                            name="order_type"
                            class="radio checked:bg-green-500"
                        />
                    </label>
                </div>
                <div
                    class="form-control"
                    v-if="Boolean(Number(restorant.config.can_pickup))"
                >
                    <label class="label cursor-pointer">
                        <span class="label-text mr-2 dark:text-white"
                            >Pickup</span
                        >
                        <input
                            type="radio"
                            id="pickup"
                            v-model="form.order_type"
                            value="2"
                            name="order_type"
                            class="radio checked:bg-blue-500"
                        />
                    </label>
                </div>
                <div
                    class="form-control"
                    v-if="Boolean(Number(restorant.config.can_dinein))"
                >
                    <label class="label cursor-pointer">
                        <span class="label-text mr-2 dark:text-white"
                            >Dine-in</span
                        >
                        <input
                            type="radio"
                            id="dinein"
                            v-model="form.order_type"
                            value="3"
                            name="order_type"
                            class="radio checked:bg-slate-500"
                        />
                    </label>
                </div>
            </div>
            <label
                v-if="form.order_type == 1"
                class="font-semibold text-xs mt-3 dark:text-white"
                for="address"
                >Address</label
            >
            <textarea
                v-model="form.address"
                v-if="form.order_type == 1"
                rows="4"
                class="flex items-center mb-4 px-4 w-full bg-gray-200 dark:bg-primary-dark dark:text-white mt-2 rounded focus:outline-none focus:ring-2"
                type="text"
            ></textarea>
            <!-- <button id="dropdownDefault" data-dropdown-toggle="dropdown" class="text-white bg-blue-700 hover:bg-blue-800 focus:outline-none w-full font-medium rounded-lg text-sm px-4 py-2.5 text-center inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800" type="button">Dropdown button <i class="fa-solid fa-caret-down"></i></button> -->
            <span
                v-if="areas.length && form.order_type == 1"
                class="font-bold dark:text-white"
                >Select Delivery Area</span
            >
            <select
                v-if="areas.length && form.order_type == 1"
                v-model="cart.delivery"
                class="w-full text-sm mt-2 rounded group dark:text-white dark:bg-primary-dark ring-0 shadow active:text-black hover:text-black font-bold text-white bg-gray-600 hover:bg-gray-100"
                aria-labelledby="dropdownDefaselectt"
            >
                <option
                    placeholder="Delivery Area"
                    aria-placeholder="Delivery Area"
                    :value="area.delivery_fee"
                    v-for="area in areas"
                    :key="area.id"
                >
                    <span
                        class="block dark:text-white text-sm py-2 dark:bg-primary-dark hover:bg-gray-100 dark:hover:bg-gray-600 dark:hover:text-white"
                        >{{ area.name }} {{ area.delivery_fee }}</span
                    >
                </option>
            </select>
            <div class="flex gap-x-2">
                <label
                    v-if="form.order_type == 1"
                    class="font-semibold text-xs mt-3 dark:text-white"
                    for="delivery_time"
                >
                    Delivery Time
                </label>
                <label
                    v-if="form.order_type == 3"
                    class="font-semibold text-xs mt-3 dark:text-white"
                    for="dinein_time"
                >
                    Dine-in Time
                </label>
                <label
                    v-if="form.order_type == 2"
                    class="font-semibold text-xs mt-3 dark:text-white"
                    for="pickup_time"
                >
                    Pickup Time
                </label>
                <h4
                    class="text-xs mt-3 dark:text-golden-yellow"
                    v-if="form.order_type == 1"
                >
                    [{{ delivery_info }}]
                </h4>
            </div>
            <v-date-picker
                :model-config="{ mask: 'iso', type: 'string' }"
                timezone="utc"
                v-model="form.order_time"
                mode="dateTime"
                :available-dates="[
                    {
                        start: new Date(),
                        end: null,
                    },
                ]"
            >
                <template v-slot="{ inputValue, inputEvents }">
                    <input
                        class="flex items-center h-12 px-4 w-full bg-gray-200 dark:text-white dark:bg-primary-dark mt-2 mb-2 rounded focus:outline-none focus:ring-2"
                        :value="inputValue"
                        v-on="inputEvents"
                    />
                </template>
            </v-date-picker>
            <div class="flex items-center my-4 px-4">
                <input
                    id="default-checkbox"
                    type="checkbox"
                    v-model="form.checked"
                    class="w-4 h-4 text-blue-600 dark:text-golden-yellow bg-gray-100 border-gray-300 dark:border-primary-dark dark:bg-golden-yellow rounded focus:ring-blue-500 dark:focus:ring-golden-yellow dark:ring-offset-gray-800 focus:ring-2 dark:bg-golden-yellow dark:border-gray-600"
                />
                <label
                    for="default-checkbox"
                    class="ml-2 dark:text-white text-sm font-medium text-gray-900 dark:text-gray-300"
                    >I agree to terms and conditions</label
                >
            </div>
            <button
                type="submit"
                :disabled="!form.checked || form.processing || loading"
                :class="{
                    'opacity-25 hover:bg-green-600':
                        !form.checked || form.processing || loading,
                }"
                class="flex items-center dark:text-black justify-center gap-x-2 h-12 px-6 w-64 bg-green-600 dark:bg-golden-yellow mt-8 rounded font-semibold text-sm text-green-100 hover:bg-green-700"
            >
                <span>Place Order</span>
                <WhatsappIcon width="10" height="10" />
            </button>
        </form>

        <button
            v-if="props.restorantConfigs.razorpay_enable"
            @click="razorpay"
            :disabled="!form.checked || form.processing || loading"
            :class="{
                'opacity-25 hover:bg-green-600':
                    !form.checked || form.processing || loading,
            }"
            class="flex items-center dark:text-black justify-center h-12 px-6 w-64 bg-green-600 dark:bg-golden-yellow mt-8 rounded font-semibold text-sm text-green-100 hover:bg-green-700"
        >
            Pay with Razorpay
        </button>

        <button
            v-if="props.restorantConfigs.stripe_enable"
            @click="payWithStripe"
            :disabled="!form.checked || form.processing || loading"
            :class="{
                'opacity-25 hover:bg-green-600':
                    !form.checked || form.processing || loading,
            }"
            class="flex items-center dark:text-black justify-center h-12 px-6 w-64 bg-green-600 dark:bg-golden-yellow mt-8 rounded font-semibold text-sm text-green-100 hover:bg-green-700"
        >
            Pay with Stripe
        </button>

        <div class="flex mt-10 px-5 dark:text-white">
            <h1 class="font-bold">Payable:</h1>
            <span class="ml-2">{{
                formatPrice(cart.getTotal.toFixed(2))
            }}</span>
        </div>
    </div>
</template>

<script setup>
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import WhatsappIcon from "../Social/Icons/WhatsappIcon.vue";
import { usePage } from "@inertiajs/inertia-vue3";
import {
    onMounted,
    defineComponent,
    onBeforeMount,
    reactive,
    watch,
    ref,
    inject,
} from "vue";
import { Inertia } from "@inertiajs/inertia";
import { useCart } from "@/Stores/cart";
import axios from "axios";
import Swal from "sweetalert2";

const emit = defineEmits(["startLoader", "stopLoader"]);
const order_id = ref("");
const payWithStripe = () => {
    // loading.value = true;
    emit("startLoader");
    let cartData = cart.getCart();
    cart.$reset();
    sessionStorage.clear();
    Inertia.post(
        route("orders.store", { restorant: props.restorant.uuid }),
        {
            form,
            payment_method: "stripelinks",
            cart: cartData,
        },
        {
            onSuccess: (res) => {
                emit("stopLoader");
                window.location.href = res.data;
            },
            onError: () => {
                emit("stopLoader");
            },
        }
    );
};

const form = reactive({
    customer_name: "Milan",
    customer_phone: "7902708908",
    address: "",
    checked: false,
    order_type: 1,
    order_time: null,
});

const checkFields = () => {
    if (
        form.customer_name.length &&
        form.customer_phone.length &&
        form.checked &&
        form.order_time
    ) {
        return true;
    }
    return false;
};

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
const razorpay = () => {
    if (!checkFields()) {
        Swal.fire({
            icon: "warning",
            title: "Please fill all fields",
        });
    } else {
        emit("startLoader");
        // loading.value = true;
        axios
            .post(route("pay.razorpay"), {
                restorant: props.restorant.id,
                amount: cart.getTotal,
            })
            .then((res) => {
                // loading.value = false;
                emit("stopLoader");
                const options = {
                    key: props.restorant.config.razorpay_api_key,
                    amount: cart.getTotal * 100,
                    currency: props.restorant.currency,
                    name: props.restorant.name,
                    description: "",
                    image: `${usePage().props.value.app.url}${
                        props.restorant.logo
                    }_logo.webp`, //${usePage().props.value.app.url}${usePage().props.auth.restorant.logo}_logo.webp
                    order_id: res.data,
                    handler: function (response) {
                        Swal.fire({
                            icon: "success",
                            title: "Order Successful!",
                            timer: 500000,
                            text: "Please do not refresh the page",
                            timerProgressBar: true,
                            allowOutsideClick: false,
                            didOpen: () => {
                                setTimeout(() => {
                                    window.location.href = route("front");
                                }, 500000);
                            },
                        }).then((res) => {
                            window.location.href = route("front");
                        });
                        let cartData = cart.getCart();
                        cart.$reset();
                        sessionStorage.clear();
                        Inertia.post(
                            route("orders.store", {
                                restorant: props.restorant.uuid,
                            }),
                            {
                                form,
                                payment_method: "razorpay",
                                cart: cartData,
                            }
                        ),
                            {
                                onSuccess: () => {
                                    alert("Order Successful");
                                    // loading.value = false;
                                },
                            };
                    },
                    prefill: {
                        name: form.customer_name,
                        // "email": "gaurav.kumar@example.com",
                        contact: form.customer_phone,
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
                // loading.value = false;
                emit("stopLoader");
                console.log(err);
            });
    }
};

const props = defineProps({
    areas: Object,
    cart: Object,
    restorant: Object,
    delivery_info: String,
    restorantConfigs: Object,
});
const cart = useCart();
watch(form, (value) => {
    if (value.order_type != 1) {
        props.cart.resetDelivery();
    }
});

const submit = () => {
    if (!checkFields()) {
        Swal.fire({
            icon: "warning",
            title: "Please fill all fields",
        });
        return;
    }
    let cartData = cart.getCart();
    cart.$reset();
    sessionStorage.clear();
    Swal.fire({
        icon: "success",
        title: "Order Successful!",
        timer: 500000,
        text: "Please do not refresh the page",
        timerProgressBar: true,
        allowOutsideClick: false,
        didOpen: () => {
            setTimeout(() => {
                window.location.href = route("front");
            }, 500000);
        },
        didClose: () => {
            setTimeout(() => {
                window.location.href = route("front");
            }, 3000);
        },
    }).then((res) => {
        window.location.href = route("front");
    });
    // loading.value = true;
    Inertia.post(route("orders.store", { restorant: props.restorant.uuid }), {
        form,
        payment_method: "cod",
        cart: cartData,
    }),
        {
            onSuccess: () => {
                alert("Order Successful");
                loading.value = false;
            },
        };
};

//Currency Formatter
let locale = usePage().props.value.app.locale;
let currency = props.restorant.config.currency;
var formatter = new Intl.NumberFormat(locale, {
    style: "currency",
    currency: currency,
});

const formatPrice = (amount) => {
    if (amount == "") {
        return "";
    }
    return formatter.format(amount);
};

onMounted(async () => {
    const loadedRazorpay = await loadRazorPay();
});
onMounted(() => {
    // loading.value = false;
    if (props.cart.delivery) {
        console.log("yes");
    } else {
        props.cart.delivery = props.areas[0] ? props.areas[0].price : 0;
    }
});
</script>
