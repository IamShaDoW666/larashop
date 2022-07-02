<template>

  <Head title="Products" />
  <FrontEnd :restaurant="restaurant">
    <div class="flex px-4 items-center md:mr-4 md:ml-8  my-2 justify-between">
      <div class="sm:flex sm:space-x-4 items-center">

        <div class="flex space-x-2 items-center">
          <span class="rounded px-2 my-2 text-white font-bold overflow-visible"
            :class="restaurant.open_status ? 'bg-green-400' : 'bg-red-500'">
            {{ restaurant.open_status ? 'Open' : 'Closed' }}
          </span>
          <span :class="restaurant.open_status ? 'bg-green-800' : 'bg-red-800'"
            class="animate-ping inline-flex h-2 w-2 rounded opacity-75"></span>

          <a target="_blank" :href="addressMap" class="sm:hidden flex space-x-2 items-center">
            <span class="material-icons">place</span>
            <span>{{ restaurant.address }}</span>
          </a>
        </div>

        <p class="text-xs m-0 sm:text-sm font-semibold">{{ restaurant.open_msg }}</p>

        <a target="_blank" :href="addressMap" class="hidden sm:flex space-x-2 items-center">
          <span class="material-icons">place</span>
          <span>{{ restaurant.address }}</span>
        </a>

      </div>
      <div class="flex gap-y-4 sm:gap-y-0 gap-x-4">
        <Facebook v-if="restaurant.facebook" :link="restaurant.facebook" />
        <Whatsapp v-if="restaurant.phone" :phone='restaurant.phone' />
        <Twitter v-if="restaurant.twitter" :link='restaurant.twitter' />
        <Instagram v-if="restaurant.instagram" :link='restaurant.instagram' />
      </div>
    </div>
    <div ref="category_slider"
      class="z-20 bg-white shadow-lg rounded-b py-3 sticky top-[72px] px-4 md:ml-8 w-full md:w-3/5 overflow-y-auto no-scrollbar">

      <div v-if="restaurant.categories" class="justify-start mx-auto flex items-center md:gap-x-3 gap-x-2 gap-y-2">
        <div @click="resetCategory"
          class="p-2 shrink-0 cursor-pointer rounded lg:rounded-t-0 hover:bg-green-200 bg-green-300"
          :class="[active[0] ? 'bg-green-400 hover:bg-green-400' : 'bg-green-300']">
          All Category
        </div>
        <div @click="categoryFilter(category.id)"
          :class="[active[category.id] ? 'bg-green-400 hover:bg-green-400 disabled' : 'bg-green-300']"
          v-for="category in restaurant.categories" :key="category.id"
          class="p-2 shrink-0 cursor-pointer rounded lg:rounded-t-0 hover:bg-green-200 bg-green-300">
          {{ category.name }}
        </div>
      </div>
    </div>

    <!-- Sidebar Cart -->
    <transition appear v-if="cart.items.length > 0" name="slide-fade">
      <aside class="hidden sm:block w-1/3 float-right ml-5 sticky top-20 right-0 static py-10" aria-label="Sidebar">
        <div class="py-4 px-3 rounded dark:bg-green-800">
          <ul class="space-y-2 bg-green-50 rounded">
            <li>
              <div
                class="text-md md:text-xl divide-solid divide-y bg-green-300 text-center p-2 rounded-lg text-base font-bold">
                <i class="pr-2 fa-solid fa-cart-shopping"></i>Cart ({{ cart.getTotalItems }})
              </div>
            </li>
            <transition v-for="(item, index) in cart.items" :key="item.id" appear leave name="slide-fade">
              <li class="odd:bg-green-100 rounded-lg">
                <div class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white">
                  <div class="font-bold flex-1 ml-3">
                    {{ item.name }}
                  </div>
                  <span>{{ item.price }} <strong>x</strong> </span>
                  <button @click="fromCart(item.id, index)"
                    class="inline-flex justify-center items-center p-3 ml-3 w-3 h-3 hover:ring-2 text-sm font-medium text-blue-600 bg-green-200 rounded-full dark:bg-green-900 dark:text-blue-200">
                    {{ item.quantity }}
                  </button>
                </div>
              </li>
            </transition>
            <li>
              <div class="flex flex-col space-y-4">
                <div
                  class="px-4 font-bold rounded shadow-lg bg-white text-center flex gap-x-2 justify-between items-center p-3 text-base text-gray-900 rounded-lg dark:text-white">
                  <div class="rounded shadow-lg p-4">Subtotal: <span class="ml-2 text-green-700">
                      {{ formatPrice(cart.getSubTotal) }}
                    </span></div>
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
              <button :class="{ 'opacity-25 hover:bg-green-500': form.processing }" :disabled="form.processing"
                class="bg-green-500 px-4 py-2 rounded shadow hover:bg-green-700 text-white font-bold">
                Checkout
              </button>
            </div>
          </form>
        </div>
      </aside>
    </transition>

    <!-- Empty Cart -->
    <transition name="slide-fade" v-else>
      <aside class="hidden sm:block w-1/3 float-right ml-5 px-4 sticky top-20 right-0 static py-10">
        <div class="text-center font-bold shadow-md overflow-y-auto py-4 px-3 bg-green-50 rounded dark:bg-green-800">
          <i class="pr-2 fa-solid fa-cart-shopping"></i>Cart Empty...
        </div>
        <div
          class="mt-4 font-bold rounded shadow-lg bg-white text-center flex items-center p-3 text-base text-gray-900 rounded-lg dark:text-white">
          Total: <span class="ml-2 text-green-700">{{ formatPrice(cart.getSubTotal) }}</span>
        </div>
      </aside>
    </transition>

    <div class="py-10">
      <div class="max-w-7xl  sm:px-6 lg:px-8">
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shadow-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-10 sm:gap-y-8">
              <div class="px-4 py-2" v-for="(product, index) in prod" :key="product.id">
                <div class="shadow md:transform md:transition md:duration-300 md:hover:scale-110 bg-blue-400 rounded">
                  <img :src="product.image_path + '_large.webp'" class="shadow rounded object-cover h-48 w-full">
                </div>
                <div class="pl-4 pb-2 pt-6 pr-2 bg-gray-300 rounded-lg shadow-md">
                  <h1 class="font-bold mb-2">{{ product.name }}</h1>
                  <div class="flex items-end justify-between ">
                    <div>
                      <h1>{{ product.price }}</h1>
                    </div>
                    <div>
                      <button v-if="restaurant.open_status" @click="toCart(product.id, index)"
                        class="sm:px-2 sm:py-2 px-1.5 py-1 text-lg sm:text-xs lg:text-xs active:bg-green-200 hover:ring-blue-900 text-white font-bold rounded bg-green-500 hover:bg-green-400">Add
                        To Cart</button>
                    </div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <CartModal v-if="cart.items.length" :checkout="checkout" :cart="cart" :formatPrice="formatPrice" :fromCart="fromCart" />
  </FrontEnd>
</template>

<script>
import { Head, useForm, usePage } from '@inertiajs/inertia-vue3';
import { onMounted, ref, watch } from 'vue';
import { useCart } from '@/Stores/cart.js';
import FrontEnd from '@/Layouts/FrontEnd.vue';
import CartModal from '@/Components/CartModal.vue';
import useProducts from '@/Composables/products';
import Facebook from '@/Components/Social/Facebook.vue';
import Whatsapp from '@/Components/Social/Whatsapp.vue';
import Twitter from '@/Components/Social/Twitter.vue';
import Instagram from '@/Components/Social/Instagram.vue';
import { useThrottleFn } from '@vueuse/core';


export default {
  components: {
    FrontEnd,
    CartModal,
    Head,
    Whatsapp,
    Facebook,
    Twitter,
    Instagram,
  },

  props: {
    restaurant: Object,
    products: Object
  },

  setup(props) {

    const { filter, prod, active } = useProducts(props);
    const cart = useCart();
    const category_slider = ref();
    const form = useForm({});
    let addressMap = `http://maps.google.com/maps?z=12&t=m&q=loc:${props.restaurant.lat}+${props.restaurant.lng}`

    watch(category_slider, (newvalue) => {
      console.log(newvalue)
    })
    const checkout = () => {
      form.get(route('orders.checkin', { restorant: props.restaurant.id }))
    };

    const categoryFilter = useThrottleFn(async (id) => {
      await filter(id)
    }, 250)

    //Mobile Cart Modal
    const isOpen = ref(false);

    //Currency Formatter
    let locale = usePage().props.value.app.locale;
    let currency = props.restaurant.config.currency;
    var formatter = new Intl.NumberFormat(locale, {
      style: 'currency',
      currency: currency,
    });

    const formatPrice = (amount) => {
      if (amount == '') {
        return '';
      }
      return formatter.format(amount);
    }

    onMounted(() => {
      cart.getProps(props)
    })

    const resetCategory = () => {
      prod.value = props.products;
      console.log('prod.data')
      active.value = []

    }

    const toCart = (p_id, id) => {
      console.log('ID CLICKED : ' + p_id)
      cart.addCart(p_id, id);
    }

    const fromCart = (p_id, id) => {
      console.log(p_id + " ||| " + id)
      cart.removeFromCart(p_id, id);
    }

    return {
      categoryFilter,
      resetCategory,
      active,
      toCart,
      fromCart,
      form,
      formatter,
      checkout,
      cart,
      isOpen,
      formatPrice,
      addressMap,
      prod

    }
  }

}

</script>
<style>
.slide-fade-enter-active {
  transition: all 0.6s ease-out;
}

.slide-fade-leave-active {
  transition: all 0.8s ease-out;
}

.slide-fade-enter-from,
.slide-fade-leave-to {
  transform: translateX(20px);
  opacity: 0;
}
</style>
