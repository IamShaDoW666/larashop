<template>
    <Head title="Checkout" />
    <!-- <BreezeAuthenticatedLayout> -->
    <div v-if="loading" class="fixed bg-black bg-opacity-25 inset-0 z-30"></div>
    <div v-if="loading" class="loader center-fixed fixed z-30 sm:left-[50%] left-[35%]"></div>
    <div class="relative" :class="currentTheme">
        <div
            class="sm:px-6 lg:px-8 py-12 md:flex gap-x-4 dark:bg-primary-dark justify-between"
        >
            <CartList :cart="cart" v-if="cart.items.length" :areas="areas" :restorant="restorant" />
            <CustomerForm
                @startLoader="loading = true"
                @stopLoader="loading = false"
                :restorantConfigs="restorantConfigs"
                :restorant="restorant"
                :delivery_info="delivery_info"
                v-if="cart.items.length"
                :areas="areas"
                :cart="cart"
                class="md:w-2/5 max-w-2xl"
            />
        </div>
    </div>
    <!-- </BreezeAuthenticatedLayout> -->
</template>

<script setup>
import { Head } from "@inertiajs/inertia-vue3";
import { provide, ref, onMounted } from "vue";
import { useCart } from "@/Stores/cart";
import CustomerForm from "@/Components/Forms/CustomerForm.vue";
import CartList from "@/Components/CartList.vue";
import { useThemeSwitcher } from "@/Composables/useThemeSwitcher.js";

const { currentTheme } = useThemeSwitcher();
const loading = ref(false);
const props = defineProps({
    restorant: Object,
    items: Object,
    subtotal: String,
    order_type: String,
    areas: Object,
    delivery_info: String,
    restorantConfigs: Object,
});

provide("restorant", {
    restorant: props.restorant,
});

onMounted(() => {
  if (cart.getTotalItems === 0) {
    window.location.href = route('front')
  }
})

const cart = useCart();
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
  }
  
  .center-fixed {
      top: 50%;      
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