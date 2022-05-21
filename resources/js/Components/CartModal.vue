<template>
  <div @click="openModal"
    class="flex justify-between mx-4 sm:hidden hover:bg-blue-300 shadow bg-blue-400 rounded sticky p-4 mb-4 bottom-2">
    <div class="font-bold">
      <i class="pr-2 fa-solid fa-cart-shopping"></i>Cart({{ cart.getTotalItems }})
    </div>
    <div class="font-bold text-black">
    </div>
  </div>
  <TransitionRoot appear :show="isOpen" as="template">
    <Dialog as="div" @close="closeModal" class="relative z-10">
      <TransitionChild as="template">
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-auto">
        <div class="flex min-h-full items-center justify-center p-4 text-center">
          <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95">
            <DialogPanel
              class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left align-middle shadow-xl transition-all">
              <DialogTitle as="h3" class="px-6 py-2 bg-gray-200 text-lg font-medium leading-6 text-gray-900">
                <i class="pr-2 fa-solid fa-cart-shopping"></i> Your Cart ({{ cart.getTotalItems }})
              </DialogTitle>
              <div class="mt-2 px-2 py-4 flex flex-col gap-y-3">
                <div v-for="(item, index) in cart.items" :key="item.id" class="flex rounded pr-3 justify-between odd:bg-gray-300 even:bg-gray-200">
                  <div>
                    <div class="flex w-full h-10 justify-center items-center mr-4">
                      <div class="block relative mr-3">
                        <img alt="profil" :src="item.imglarge" class="mx-auto object-cover rounded-full h-10 w-10" />
                      </div>
                      <span>{{ item.name }} x {{ item.quantity }}</span>
                    </div>
                  </div>
                  <div>
                    Hello
                  </div>
                </div>
              </div>

              <div class="mt-4 px-6 pb-4 float-right">
                <button type="button"
                  class="inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  @click="closeModal">
                  Checkout
                </button>
              </div>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
import { ref } from 'vue';
import { gsap } from 'gsap';
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue'

const isOpen = ref(false)

const props = defineProps({
  cart: Object,
  fromCart: Function
})

function closeModal() {
  isOpen.value = false
}
function openModal() {
  isOpen.value = true
}

//GSAP animations
const beforeEnter = (el) => {
  alert(el);
}

</script>
