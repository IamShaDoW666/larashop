<template>

  <Head title="Products" />

  <div class="drawer drawer-end" :class="currentTheme">
    <input id="my-drawer-4" type="checkbox" class="drawer-toggle" />
    <div class="drawer-content mb-4">
      <!-- Page content here -->
      <HeadlessProductShow :productShowOpen="productShow" />
      <FrontEnd :restaurant="restaurant">
        <label for="my-drawer-4" class="
            hidden
            right-0
            sm:flex
            flex-col
            items-center
            justify-center
            p-3
            pt-3.5
            fixed
            top-1/2
            -mt-12
            z-40
            shadow-900
            rounded           
            rounded-tr-none
            rounded-br-none
            rounded
            bg-red-500
            dark:bg-golden-yellow
            text-light text-sm
            font-semibold
            transition-colors
            duration-200
            focus:outline-none
            hover:bg-accent-hover            
          ">
          <span class="flex pb-0.5">
            <svg width="14" height="16" class="shrink-0" viewBox="0 0 12.686 16">
              <g transform="translate(-27.023 -2)">
                <g transform="translate(27.023 5.156)">
                  <g>
                    <path
                      d="M65.7,111.043l-.714-9A1.125,1.125,0,0,0,63.871,101H62.459V103.1a.469.469,0,1,1-.937,0V101H57.211V103.1a.469.469,0,1,1-.937,0V101H54.862a1.125,1.125,0,0,0-1.117,1.033l-.715,9.006a2.605,2.605,0,0,0,2.6,2.8H63.1a2.605,2.605,0,0,0,2.6-2.806Zm-4.224-4.585-2.424,2.424a.468.468,0,0,1-.663,0l-1.136-1.136a.469.469,0,0,1,.663-.663l.8.8,2.092-2.092a.469.469,0,1,1,.663.663Z"
                      transform="translate(-53.023 -101.005)" fill="currentColor"></path>
                  </g>
                </g>
                <g transform="translate(30.274 2)">
                  <g>
                    <path
                      d="M160.132,0a3.1,3.1,0,0,0-3.093,3.093v.063h.937V3.093a2.155,2.155,0,1,1,4.311,0v.063h.937V3.093A3.1,3.1,0,0,0,160.132,0Z"
                      transform="translate(-157.039)" fill="currentColor"></path>
                  </g>
                </g>
              </g>
            </svg>

            <span class="flex ml-2">{{ cart.getTotalItems }} Items</span></span><span
            class="bg-white dark:bg-primary-dark rounded w-full py-2 px-2 text-green-500 dark:text-white mt-3">{{
                formatPrice(cart.getSubTotal)
            }}</span>
        </label>
        <div class="flex px-4 items-center md:mr-4 md:ml-8 my-2 justify-between">
          <div class="sm:flex sm:space-x-4 items-center">
            <div class="flex space-x-2 items-center">
              <span class="rounded px-2 my-2 text-white dark:text-black font-bold overflow-visible"
                :class="restaurant.open_status ? 'bg-green-400 dark:bg-golden-yellow' : 'bg-red-500'">
                {{ restaurant.open_status ? "Open" : "Closed" }}
              </span>
              <span :class="restaurant.open_status ? 'bg-green-800 dark:bg-white' : 'bg-red-800'"
                class="animate-bounce inline-flex h-2 w-2 rounded opacity-75"></span>

              <a target="_blank" :href="addressMap" class="sm:hidden flex space-x-2 items-center dark:text-white">
                <span class="material-icons"></span>
                <span>{{ restaurant.address }}</span>
              </a>
            </div>


            <p class="text-xs m-0 sm:text-sm dark:text-white font-semibold">
              {{ restaurant.open_msg }}
            </p>

            <a target="_blank" :href="addressMap" class="hidden sm:flex space-x-2 items-center">
              <span class="material-icons dark:text-white">place</span>
              <span class="dark:text-white">{{ restaurant.address }}</span>
            </a>
          </div>
          <div class="flex gap-y-4 sm:gap-y-0 gap-x-4">
            <Facebook v-if="restaurant.facebook" :link="restaurant.facebook" />
            <Whatsapp v-if="restaurant.phone" :phone="restaurant.phone" />
            <Twitter v-if="restaurant.twitter" :link="restaurant.twitter" />
            <Instagram v-if="restaurant.instagram" :link="restaurant.instagram" />
          </div>
        </div>
        <div ref="category_slider" class="
            z-20
            bg-white
            dark:bg-primary-dark
            shadow-lg
            rounded-b
            rounded-t
            py-3
            sticky
            top-[72px]
            px-4          
            mx-auto                      
            max-w-7xl
            overflow-y-auto
            no-scrollbar
          ">
          <div v-if="restaurant.categories" class="
              justify-start
              mx-auto
              flex
              items-center
              md:gap-x-3
              gap-x-2 gap-y-2
            ">
            <div @click="resetCategory" class="
                p-2
                shrink-0
                cursor-pointer
                rounded
                lg:rounded-t-0
                hover:bg-green-200
                bg-green-300
                dark:bg-golden-yellow
                dark:text-black
              " :class="[
                active[0] ? 'bg-green-400 hover:bg-green-400' : 'bg-green-300',
              ]">
              All Category
            </div>
            <div @click="categoryFilter(category.id)" :class="[
              active[category.id]
                ? 'bg-green-400 hover:bg-green-400 disabled'
                : 'bg-green-300',
            ]" v-for="category in restaurant.categories" :key="category.id" class="
                p-2
                shrink-0
                cursor-pointer
                rounded
                lg:rounded-t-0
                hover:bg-green-200
                bg-green-300
                dark:bg-golden-yellow
                dark:text-black
              ">
              {{ category.name }}
            </div>
          </div>
        </div>

        <!-- <SideCart :cart="cart" :checkout="checkout" :formatPrice="formatPrice" :form="form" /> -->

        <ProductsList :prod="prod" :restaurant="restaurant" :toCart="toCart" />

        <CartModal v-if="cart.items.length" :checkout="checkout" :cart="cart" :formatPrice="formatPrice"
          :fromCart="fromCart" />
      </FrontEnd>
    </div>
    <div class="drawer-side">
      <label for="my-drawer-4" class="drawer-overlay"></label>
      <transition appear v-if="cart.items.length > 0" name="slide-fade">
        <aside class="
            hidden
            sm:block
            bg-white
            dark:bg-secondary-dark
            w-1/3
            float-right
            ml-5
            sticky
            top-20
            right-0
            static
            py-10
          " aria-label="Sidebar">
          <div class="py-4 px-3 rounded dark:bg-secondary-dark">
            <ul class="space-y-2 bg-green-50 dark:bg-secondary-dark rounded">
              <li>
                <div class="
                    text-md
                    md:text-xl
                    divide-solid divide-y
                    bg-green-300
                    dark:bg-golden-yellow
                    text-center
                    p-2
                    rounded-lg
                    text-base
                    font-bold
                  ">
                  <i class="pr-2 fa-solid fa-cart-shopping"></i>Cart ({{
                      cart.getTotalItems
                  }})
                </div>
              </li>
              <transition v-for="(item, index) in cart.items" :key="item.id" appear leave name="slide-fade">
                <li class="odd:bg-green-100 dark:odd:bg-primary-dark rounded-lg">
                  <div class="
                      flex
                      items-center
                      p-2
                      text-base
                      font-normal
                      text-gray-900
                      rounded-lg
                      dark:text-white
                    ">
                    <div class="font-bold flex-1 ml-3">
                      {{ item.name }}
                    </div>
                    <span>{{ item.price }} <strong>x</strong> </span>
                    <button @click="fromCart(item, item.variantId, index)" class="
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
                        dark:bg-golden-yellow dark:text-black
                      ">
                      {{ item.quantity }}
                    </button>
                  </div>
                </li>
              </transition>
              <li>
                <div class="flex flex-col space-y-4">
                  <div class="
                      px-4
                      font-medium
                      rounded
                      shadow-lg
                      bg-white
                      dark:bg-primary-dark
                      text-left
                      flex
                      flex-col
                      gap-y-2
                      justify-between
                      items-stary
                      p-3
                      text-base text-gray-900
                      rounded-lg
                      dark:text-white
                    ">
                    <div class="rounded">
                      <span class="text-sm dark:text-white">
                        Subtotal: {{ formatPrice(cart.getSubTotal) }}
                      </span>                      
                    </div>
                    <div v-if="cart.getTaxValue" class="text-sm">
                      {{ restaurant.config.tax_name }}: {{ formatPrice(cart.getTaxValue) }}  ({{ restaurant.config.tax }}%)
                    </div>
                    <div class="font-bold text-lg text-green-700 dark:text-white">
                      Total: {{ formatPrice(cart.getTotal) }}
                    </div>
                  </div>
                </div>
              </li>
            </ul>
            <!-- Checkout Options -->
            <form @submit.prevent="checkout">
              <p class="text-sm p-3 mt-4 dark:text-white font-medium" v-if="!cart.isAboveMinimum">Minimum order value is {{ formatPrice(cart.minimum_order) }}</p>
              <div class="p-3 mt-4 flex gap-x-4 justify-between float-right">
                <button :class="{
                  'opacity-25 hover:bg-green-500': (form.processing || !cart.isAboveMinimum),
                }" :disabled="form.processing || !cart.isAboveMinimum" class="
                    bg-green-500
                    dark:bg-golden-yellow
                    dark:text-black
                    px-4
                    py-2
                    rounded
                    shadow
                    hover:bg-green-700
                    text-white
                    font-bold
                  ">
                  Checkout
                </button>
              </div>
            </form>
          </div>
        </aside>
      </transition>

      <!-- Empty Cart -->
      <transition name="slide-fade" v-else>
        <aside class="
            hidden
            sm:block
            w-1/3
            float-right
            bg-grey-500
            dark:bg-primary-dark
            ml-5
            px-4
            sticky
            top-20
            right-0
            static
            py-10
          ">
          <div class="
              text-center
              font-bold
              shadow-md
              overflow-y-auto
              py-4
              px-3
              bg-green-50
              rounded
              dark:bg-golden-yellow
            ">
            <i class="pr-2 fa-solid fa-cart-shopping"></i>Cart Empty...
          </div>
          <div class="
              mt-4
              font-bold
              rounded
              shadow-lg
              bg-white
              dark:bg-secondary-dark
              text-center
              flex
              items-center
              p-3
              text-base text-gray-900
              rounded-lg
              dark:text-white
            ">
            Total:
            <span class="ml-2 text-green-700 dark:text-white">{{
                formatPrice(cart.getSubTotal)
            }}</span>
          </div>
        </aside>
      </transition>
    </div>
  </div>

  <!-- </FrontEnd> -->
</template>

<script>
import { Head, useForm, usePage } from "@inertiajs/inertia-vue3";
import { onMounted, ref, watch, provide } from "vue";
import { useCart } from "@/Stores/cart.js";
import FrontEnd from "@/Layouts/FrontEnd.vue";
import CartModal from "@/Components/CartModal.vue";
import useProducts from "@/Composables/products";
import Facebook from "@/Components/Social/Facebook.vue";
import Whatsapp from "@/Components/Social/Whatsapp.vue";
import Twitter from "@/Components/Social/Twitter.vue";
import Instagram from "@/Components/Social/Instagram.vue";
import ProductsList from "@/Components/Restorant/ProductsList.vue";
import HeadlessProductShow from "@/Components/Dialogs/HeadlessProductShow.vue"
import SideCart from "@/Components/Restorant/SideCart.vue";
import { useThrottleFn } from "@vueuse/core";
import FooterEnd from "@/Components/Footers/Footer.vue";
import { useThemeSwitcher } from "@/Composables/useThemeSwitcher";


export default {
  components: {
    FrontEnd,
    FooterEnd,
    CartModal,
    Head,
    Whatsapp,
    Facebook,
    Twitter,
    Instagram,
    ProductsList,
    SideCart,
    HeadlessProductShow

  },

  props: {
    restaurant: Object,
    products: Object,
  },

  setup(props) {
    const { filter, prod, active } = useProducts(props);
    const cart = useCart();
    const category_slider = ref();
    const form = useForm({});

    let addressMap = `http://maps.google.com/maps?z=12&t=m&q=loc:${props.restaurant.lat}+${props.restaurant.lng}`;
    const { currentTheme } = useThemeSwitcher()
    const productShow = ref(false);
    const dproduct = ref(prod[0]);

    watch(category_slider, (newvalue) => {
      console.log(newvalue);
    });
    const checkout = () => {
      form.get(route("orders.checkin", { restorant: props.restaurant.id }));
    };

    const categoryFilter = useThrottleFn(async (id) => {
      await filter(id);
    }, 250);

    //Mobile Cart Modal
    const isOpen = ref(false);

    //Currency Formatter
    let locale = usePage().props.value.app.locale;
    let currency = props.restaurant.config.currency;
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

    onMounted(() => {
      cart.getProps(props);
    });

    const resetCategory = () => {
      prod.value = props.products;
      console.log("prod.data");
      active.value = [];
    };

    const toCart = (product) => {
      if (!product?.variants?.length) {
        cart.addCart(product);
      } else {
        openModal(product.id)
      }
    }

    const fromCart = (p, variant_id, idx) => {
      console.log(p + " ||| " + variant_id)
      cart.removeFromCart(p, variant_id, idx);
    }

    const openModal = (id) => {
      dproduct.value = prod.value.find(p => p.id == id)
      productShow.value = !productShow.value
    }

    provide('data', {
      productShowOpen: productShow,
      product: dproduct
    })

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
      openModal,
      productShow,
      prod,
      currentTheme
    };
  },
};


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
