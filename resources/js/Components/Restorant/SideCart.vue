<template>
  <!-- Sidebar Cart -->
  <transition appear v-if="cart.items.length > 0" name="slide-fade">
    <aside
      class="
        hidden
        sm:block
        w-1/3
        float-right
        bg-grey-800
        dark:bg-primary-dark
        ml-5
        sticky
        top-20
        right-0
        static
        py-10
      "
      aria-label="Sidebar"
    >
      <div class="py-4 px-3 rounded dark:bg-primary-dark">
        <ul class="space-y-2 bg-green-50 rounded">
          <li>
            <div
              class="
                text-md
                md:text-xl
                divide-solid divide-y
                bg-green-300
                text-center
                p-2
                rounded-lg
                text-base
                font-bold
              "
            >
              <i class="pr-2 fa-solid fa-cart-shopping"></i>Cart ({{
                cart.getTotalItems
              }})
            </div>
          </li>
          <transition
            v-for="(item, index) in cart.items"
            :key="item.id"
            appear
            leave
            name="slide-fade"
          >
            <li class="odd:bg-green-100 rounded-lg">
              <div
                class="
                  flex
                  items-center
                  p-2
                  text-base
                  font-normal
                  text-gray-900
                  rounded-lg
                  dark:text-white
                "
              >
                <div class="font-bold flex-1 ml-3">
                  {{ item.name }}
                </div>
                <span>{{ item.price }} <strong>x</strong> </span>
                <button
                  @click="fromCart(item.id, index)"
                  class="
                    inline-flex
                    justify-center
                    items-center
                    p-3
                    ml-3
                    w-3
                    h-3
                    hover:ring-2
                    text-sm
                    font-medium
                    text-blue-600
                    bg-green-200
                    rounded-full
                    dark:bg-green-900 dark:text-blue-200
                  "
                >
                  {{ item.quantity }}
                </button>
              </div>
            </li>
          </transition>
          <li>
            <div class="flex flex-col space-y-4">
              <div
                class="
                  px-4
                  font-bold
                  rounded
                  shadow-lg
                  bg-white
                  text-center
                  flex
                  gap-x-2
                  justify-between
                  items-center
                  p-3
                  text-base text-gray-900
                  rounded-lg
                  dark:text-white
                "
              >
                <div class="rounded shadow-lg p-4">
                  Subtotal:
                  <span class="ml-2 text-green-700">
                    {{ formatPrice(cart.getSubTotal) }}
                  </span>
                </div>
              </div>
              <!-- <div class="font-bold rounded shadow-lg bg-white text-center flex items-center p-3 text-base text-gray-900 rounded-lg dark:text-white">
                Total: <span class="ml-2 text-green-700">${{ cart.getSubTotal }}</span>
              </div> -->
            </div>
          </li>
        </ul>
        <!-- Checkout Options -->
        <form @submit.prevent="checkout">
          <div class="p-3 mt-4 flex gap-x-4 justify-between float-right">
            <button
              :class="{
                'opacity-25 hover:bg-green-500': form.processing,
              }"
              :disabled="form.processing"
              class="
                bg-green-500
                px-4
                py-2
                rounded
                shadow
                hover:bg-green-700
                text-white
                font-bold
              "
            >
              {{ __('Checkout') }}
            </button>
          </div>
        </form>
      </div>
    </aside>
  </transition>

  <!-- Empty Cartii -->
  <transition name="slide-fade" v-else>
    <aside
      class="
        hidden
        sm:block
        w-1/4
        float-right
        bg-green-700
        dark:bg-primary-dark
        ml-5
        px-4
        sticky
        top-20
        right-0
        static
        py-10
      "
    >
      <div
        class="
          text-center
          font-bold
          shadow-md
          overflow-y-auto
          py-4
          px-3
          bg-green-50
          rounded
          dark:bg-green-800
        "
      >
        <i class="pr-2 fa-solid fa-cart-shopping"></i>Cart Empty...
      </div>
      <div
        class="
          mt-4
          font-bold
          rounded
          shadow-lg
          bg-white
          text-center
          flex
          items-center
          p-3
          text-base text-gray-900
          rounded-lg
          dark:text-white
        "
      >
        Total:
        <span class="ml-2 text-green-700">{{
          formatPrice(cart.getSubTotal)
        }}</span>
      </div>
    </aside>
  </transition>
</template>

<script setup>
const props = defineProps({
    cart: Object,
    checkout: Function,
    formatPrice: Function,
    form: Object
})
</script>