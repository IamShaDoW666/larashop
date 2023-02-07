<template>
  <Head title="Products" />
  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Products
      </h2>
    </template>
    <div class="justify-center flex items-center flex-wrap md:gap-x-3 gap-x-2 gap-y-2">
      <div @click="resetCategory" class="p-4 cursor-pointer rounded lg:rounded-t-0 hover:bg-gray-200 bg-gray-300"
      :class="[active[0] ? 'bg-gray-400 hover:bg-gray-400' : 'bg-gray-300']">
      All Category
    </div>
    <div @click="categoryFilter(category.id)" :class="[active[category.id] ? 'bg-gray-400 hover:bg-gray-400 disabled' : 'bg-gray-300']" v-for="category in categories" :key="category.id" class="p-4 cursor-pointer rounded lg:rounded-t-0 hover:bg-gray-200 bg-gray-300">
      {{ category.name }}
    </div>
  </div>
  <aside class="hidden sm:block w-64 float-right ml-3 sticky top-20 right-0 static" aria-label="Sidebar">
    <div class="overflow-y-auto py-4 px-3 bg-gray-50 rounded dark:bg-gray-800">
      <ul class="space-y-2">
        <li>
          <div class="divide-solid divide-y bg-gray-300 text-center p-2 rounded-lg text-base font-bold"><i class="pr-2 fa-solid fa-cart-shopping"></i>Cart ({{ total }})</div>
        </li>
        <li v-for="item in items" :key="item.id" class="odd:bg-gray-100 rounded-lg">
          <div class="flex items-center p-2 text-base font-normal text-gray-900 rounded-lg dark:text-white">
            <div class="font-bold flex-1 ml-3 whitespace-nowrap">
              {{ item.name }}
            </div>
            <span>${{ item.price }} <strong>x</strong> </span>
            <button @click="fromCart(item.id)" class="inline-flex justify-center items-center p-3 ml-3 w-3 h-3 hover:ring-2 text-sm font-medium text-blue-600 bg-blue-200 rounded-full dark:bg-blue-900 dark:text-blue-200">
              {{ item.quantity }}
            </button>
          </div>
        </li>
        <li>
          <div class="font-bold rounded shadow-lg bg-white text-center flex items-center p-3 text-base text-gray-900 rounded-lg dark:text-white">
            Subtotal: <span class="ml-2 text-green-700">${{ subTotal.toFixed(2) }}</span>
          </div>
        </li>
      </ul>
    </div>
  </aside>
  <div class="py-10">
    <div class="max-w-7xl  sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg shadow-lg">
        <div class="p-6 bg-white border-b border-gray-200">
          <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-y-8">
            <div class="px-4 py-2" v-for="product in prod" :key="product.id">
              <div class="shadow md:transform md:transition md:duration-300 md:hover:scale-110 rounded">
                <img src="https://picsum.photos/200/200" class="shadow rounded w-full h-full">
              </div>
              <div class="-mt-1 flex items-center pl-4 pb-2 pt-6 pr-2 justify-between bg-gray-300 rounded-lg shadow-md">
                <div>
                  <h1 class="font-bold">{{ product.name }}</h1>
                  <h1>${{ product.price }}</h1>
                </div>
                <div>
                  <button @click="toCart(product.id)" class="px-2 py-2 active:bg-blue-200 hover:ring-blue-900 hover:ring hover:ring-2 rounded bg-blue-300 hover:bg-blue-400">Add To Cart</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <div data-modal-toggle="small-modal" class="flex justify-between mx-4 hover:bg-blue-300 shadow sm:hidden bg-blue-400 rounded sticky p-4 mb-4 bottom-2">
    <div class="font-bold">
      <i class="pr-2 fa-solid fa-cart-shopping"></i>Cart({{ total }})
    </div>
    <div class="font-bold text-black">
      ${{ subTotal.toFixed(2) }}
    </div>
  </div>
  <CartModal class="sm:hidden mx-3" :fromCart="fromCart" :items="items" :subTotal="subTotal" :total="total" />
</BreezeAuthenticatedLayout>
</template>

<script>
import { Head } from '@inertiajs/inertia-vue3';
import { onMounted, computed, ref, reactive, toRefs } from 'vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import CartModal from '@/Components/CartModal.vue';
import useProducts from '@/Composables/products';
import useStore from '@/Composables/store';
import { Inertia } from '@inertiajs/inertia';


export default {
  components: {
    BreezeAuthenticatedLayout,
    CartModal,
    Head
  },

  props: {
    categories: Object,
    products: Object,
    Grocery: Object

  },

  setup(props) {

    const { filter, prod, active } = useProducts(props);
    const { total, addToCart, items, removeFromCart, subTotal, getTotal } = useStore(props);

    const categoryFilter = async (id) => {
      await filter(id)
    }

    const resetCategory = () => {
      prod.value = props.products;
      console.log(prod.data)
      active.value = []

    }

    const toCart = (id) => {
      addToCart(id)
      getTotal()

    }

    // onMounted(getTotal)

    const fromCart = (id) => {
      console.log(id)
      removeFromCart(id)
      getTotal()

    }


    return {
      categoryFilter,
      resetCategory,
      active,
      total,
      items,
      toCart,
      fromCart,
      subTotal,
      prod

    }
  }

}

</script>
