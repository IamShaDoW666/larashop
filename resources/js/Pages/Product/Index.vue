<template>
  <Admin :headerStats="false" >
    <Head title="Products" />
      <HeadlessCategory />
      <HeadlessProduct />
      <HeadlessProductEdit v-if="productOpenEdit" />
      <HeadlessCategoryEdit :dCategory="dCategory" v-if="categoryOpenEdit" />
      <div class="-mt-2 md:mt-0 bg-gray-100">
        <div class="mb-3 float-right px-4">
          <button class="px-4 py-2 text-sm rounded shadow bg-blue-500 text-white hover:bg-blue-700"   @click="categoryOpen = true">
            Add Category
          </button>
        </div>
        <div class="w-full sm:mt-4 bg-gray-100 rounded-lg px-4 py-12">
          <BreezeValidationErrors class="mb-4" />
          <div v-for="category in restaurant.categories" :key="category.id">
            <div class="py-5 flex justify-between text-white my-2 px-4 font-bold bg-gray-800 shadow mb-4 rounded-md">
              <h1>{{ category.name }}</h1>
              <div class="flex items-center gap-x-2">
                <button class="rounded-full px-2 py-1 mr-3 shadow hover:bg-emerald-600 bg-green-400" @click="openProduct(category)">
                  <i class="fa-solid fa-plus"></i>
                </button>
                <button class="rounded-full px-2 py-1 mr-3 shadow hover:bg-blue-600 bg-green-400" @click="openCategoryEdit(category)">
                  <span class="text-sm md-18 material-icons">
                    edit
                  </span>
                </button>
                <form @submit.prevent="deleteCategory(category.id)">
                  <button type="submit" class="rounded-full px-2 py-1 mr-3 shadow hover:bg-red-600 bg-red-400">
                    <i class="fa-solid fa-ban"></i>
                  </button>
                </form>
              </div>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 lg:grid-cols-4 gap-y-8">
              <div class="px-4 py-2" v-for="(product, index) in category.products" :key="product.id">
                <div @click="openProductEdit(product, category)" class="shadow md:transform md:transition md:duration-300 md:hover:scale-110 rounded">
                  <img :src="product.imglarge" class="shadow rounded w-full h-full h-48 max-h-48">
                </div>
                <div class="-mt-1 flex items-end pl-4 pb-2 pt-6 pr-2 justify-between bg-gray-300 rounded-lg shadow-md">
                  <div>
                    <h1 class="font-bold">{{ product.name }}</h1>
                    <h1>{{ product.price }}</h1>
                  </div>
                </div>
              </div>
              <div class="px-4 py-2 w-full h-full rounded-lg shadow-md bg-gray-300">
              </div>
            </div>
          </div>
        </div>
      </div>
  </Admin>
</template>

<script setup>
import axios from "axios";
import { Head, useForm } from '@inertiajs/inertia-vue3';
import { onMounted, computed, ref, reactive, provide } from 'vue';
import { Inertia } from '@inertiajs/inertia';

import Admin from "@/Layouts/Admin.vue";
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import HeadlessCategory from '@/Components/Dialogs/HeadlessCategory.vue';
import HeadlessCategoryEdit from '@/Components/Dialogs/HeadlessCategoryEdit.vue';
import HeadlessProductEdit from '@/Components/Dialogs/HeadlessProductEdit.vue';
import HeadlessProduct from '@/Components/Dialogs/HeadlessProduct.vue';
// import HeadlessProductEdit from '@/Components/Dialogs/HeadlessProductEdit.vue';
import CardStats from "@/Components/Cards/CardStats.vue";
import Swal from 'sweetalert2';

const props = defineProps({
  restaurant: Object
})
const form = useForm({
  category: null
})

const categoryOpen = ref(false);
const categoryOpenEdit = ref(false);
const productOpenEdit = ref(false);
const productOpen = ref(false);
const dCategory = ref({});
const dProduct = ref({});

const openCategoryEdit = (category) => {
  dCategory.value = category
  categoryOpenEdit.value = true;
}

const openProductEdit = (product, category) => {
  dCategory.value = category
  dProduct.value = product
  productOpenEdit.value = true;
}

const openProduct = (category) => {
  dCategory.value = category
  productOpen.value = true
}


const deleteCategory = (id) => {
  Swal.fire({
    title: 'Are you sure?',
    text: 'All products will be deleted',
    showDenyButton: true,
    confirmButtonText: 'Yes',
    denyButtonText: 'No',
  }).then((result) => {
    if (result.isConfirmed) {
      form.delete(route('categories.destroy', { category: id }), {
        onSuccess: () => {
          Swal.fire({
            icon: 'success',
            title: 'Deleted Successfully!',
            timer: 1000
          })
        }
      })
    } else if (result.isDenied) {
      Swal.fire('Changes are not saved', '', 'info')
    }
  })
}


provide('data', {
  categories: props.restaurant.categories,
  categoryOpen,
  categoryOpenEdit, 
  productOpenEdit,
  productOpen,
  dCategory,
  dProduct,

});

</script>
