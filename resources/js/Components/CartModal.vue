<template>
    <div @click="openModal"
        class="flex justify-between items-center mx-4 sm:hidden z-30 hover:bg-blue-300 shadow bg-blue-400 rounded-lg sticky p-4 mb-4 bottom-2">
        <div class="font-bold">
            <i class="pr-2 fa-solid fa-cart-shopping"></i>Cart({{
                    cart.getTotalItems
            }})
        </div>
        <div class="font-bold text-black">{{ formatPrice(cart.getSubTotal) }}</div>
    </div>

    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal" class="absolute z-30">
            <TransitionChild enter="duration-300 ease-in" enter-from="opacity-0" leave-from="opacity-100"
                leave="duration-300 ease-in" as="template">
                <div class="fixed inset-0 bg-black bg-opacity-25" />
            </TransitionChild>

            <div class="fixed bottom-0 w-screen h-3/4">
                <div class="flex rounded-2xl h-full items-center justify-center text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-80 translate-y-32" enter-to="opacity-100 scale-100 translate-y-0"
                        leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-80 translate-y-32">
                        <DialogPanel ref="el"
                            class="w-full overflow-y-scroll h-full transform rounded-2xl bg-white text-left align-middle shadow-xl transition-all">

                            <DialogTitle as="h3"
                                class="flex justify-between items-center px-6 py-2 bg-gray-200 text-lg font-medium leading-6 text-gray-900">
                                <div>
                                    <i class="pr-2 fa-solid fa-cart-shopping"></i>
                                    <span>Your Cart ({{ cart.getTotalItems }})</span>
                                </div>
                                <div class="cursor-pointer" @click="closeModal()">
                                    <span
                                        class="active:opacity-50 transition-all duration-200 material-icons">close</span>
                                </div>
                            </DialogTitle>
                            <div class="mt-4">

                                <div class="flex justify-between my-2 py-4 border-b border-gray-400 px-2"
                                    v-for="(item, index) in cart.items" :key="item.id">


                                    <div class="flex items-center gap-x-2">
                                        <img alt="product-image" :src="`${item.image_path}_thumbnail.webp`"
                                            class="mx-auto object-cover rounded-full h-10 w-10" />
                                        <span class="font-semibold text-sm">{{ item.name }}</span>
                                        <span
                                            class="text-xs px-0.5  rounded shadow bg-green-400 text-white font bold">{{
                                                    item.price
                                            }}</span>
                                    </div>

                                    <div class="flex items-center">
                                        <button tabindex="-1" @click="fromCart(item.id)" class="px-1 py-1 rounded-full">
                                            <span class="material-icons">remove</span>
                                        </button>
                                        <span
                                            class="w-6 h-6 text-white rounded-full bg-green-400 font-bold align-middle pt-[1px] text-center text-sm">
                                            {{
                                                    item.quantity
                                            }}</span>
                                        <button tabindex="-1" @click="cart.addCart(item.id)"
                                            class="px-1 py-1 rounded-full">
                                            <span class="material-icons">add</span>
                                        </button>
                                    </div>


                                </div>

                            </div>
                            <div class="flex items-center justify-between mx-4">
                                <div class="flex text-sm gap-x-2">
                                    <span class="font-bold">Subtotal: </span>
                                    <span class="bg-green-400 shadow-md px-1 rounded text-white font-extrabold">{{
                                            formatPrice(cart.getSubTotal)
                                    }}</span>
                                </div>
                                <div class="mt-4 mr-2 pb-4">
                                    <button type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                        @click="checkout">
                                        Checkout
                                    </button>
                                </div>
                            </div>

                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
            <!-- 
      <TransitionChild>
        <div class="fixed inset-x-0 bottom-0 bg-red-400 h-3/4 rounded-t-lg">
          <
        </div>
      </TransitionChild> -->
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { onMounted, ref, watch } from "vue";
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from "@headlessui/vue";
import { useScroll } from "@vueuse/core";
import { useCart } from "@/Stores/cart";

const isOpen = ref(false);

const el = ref(null);

const { x, y } = useScroll(el);

watch(x, (newValue) => {
    console.log(newValue)
})

const cart = useCart();

const props = defineProps({
    cart: Object,
    fromCart: Function,
    formatPrice: Function,
    checkout: Function
});

function closeModal() {
    isOpen.value = false;
}
function openModal() {
    isOpen.value = true;
}

//GSAP animations
const beforeEnter = (el) => {
    alert(el);
};
</script>
