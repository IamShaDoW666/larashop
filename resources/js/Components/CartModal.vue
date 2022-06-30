<template>
    <div
        @click="openModal"
        class="flex justify-between mx-4 sm:hidden z-30 hover:bg-blue-300 shadow bg-blue-400 rounded-lg sticky p-4 mb-4 bottom-2"
    >
        <div class="font-bold">
            <i class="pr-2 fa-solid fa-cart-shopping"></i>Cart({{
                cart.getTotalItems
            }})
        </div>
        <div class="font-bold text-black"></div>
    </div>

    <TransitionRoot appear :show="isOpen" as="template">
        <Dialog as="div" @close="closeModal" class="absolute z-30">
            <TransitionChild as="template">
                <div class="fixed inset-0 bg-black bg-opacity-25" />
            </TransitionChild>

            <div class="fixed bottom-0 w-screen h-3/4">
                <div
                    class="flex rounded-2xl h-full items-center justify-center text-center"
                >
                    <TransitionChild
                        as="template"
                        enter="duration-300 ease-out"
                        enter-from="opacity-0 scale-80 translate-y-32"
                        enter-to="opacity-100 scale-100 translate-y-0"
                        leave="duration-200 ease-in"
                        leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-80 translate-y-32"
                    >
                        <DialogPanel
                            class="w-full overflow-y-scroll h-full transform rounded-2xl bg-white text-left align-middle shadow-xl transition-all"
                        >
                            <DialogTitle
                                as="h3"
                                class="px-6 py-2 bg-gray-200 text-lg font-medium leading-6 text-gray-900"
                            >
                                <i class="pr-2 fa-solid fa-cart-shopping"></i>
                                Your Cart ({{ cart.getTotalItems }})
                            </DialogTitle>
                            <div
                                class="mt-2 px-2 py-4 flex flex-col gap-y-3 overflow-y-scroll"
                            >
                                <div
                                    v-for="(item, index) in cart.items"
                                    :key="item.id"
                                    class="flex rounded pr-3 justify-between odd:bg-gray-300 even:bg-gray-200"
                                >
                                    <div
                                        class="flex w-full h-10 justify-center items-center mr-4"
                                    >
                                        <div class="block relative mr-3">
                                            <img
                                                alt="profil"
                                                :src="item.image_path"
                                                class="mx-auto object-cover rounded-full h-10 w-10"
                                            />
                                        </div>
                                        <span
                                            >{{ item.name }} x
                                            {{ item.quantity }}</span
                                        >
                                    </div>
                                
                                
                                    <div>Hello</div>
                                </div>
                            </div>

                            <div class="mt-4 px-6 pb-4 float-right">
                                <button
                                    type="button"
                                    class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                    @click="closeModal"
                                >
                                    Checkout
                                </button>
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
import { ref } from "vue";
import { gsap } from "gsap";
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from "@headlessui/vue";

const isOpen = ref(false);

const props = defineProps({
  cart: Object,
  fromCart: Function,
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
