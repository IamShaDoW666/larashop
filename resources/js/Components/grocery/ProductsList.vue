<template>
<div class="flex flex-wrap md:mt-2 md:mr-26 md:ml-26 lg:mr-32 lg:ml-32  content-center">
<div class="flex md:w-1/2 md:h-1/4 w-full" v-for="(product, index) in filteredProducts" :key="product.id">
    <div class="bg-blue-300 dark:bg-primary-dark h-24 m-2 w-full flex rounded" >
        <div class="flex justify-start w-4/5 gap-3 m-2 max-h-full flex items-stretch" >
            <img :src="getImagePath(product.image_path, 'large')" class="shadow rounded-t object-cover max-h-full md:transform md:transition md:duration-300 md:hover:scale-110" />
        <div class="flex flex-col">
          <div class="bg-blue-300 dark:bg-primary-dark dark:text-white truncate w-4/5 font-bold font-sans Noto Sans  h-12">{{ product.name }}</div> 
          <div class="bg-blue-300 dark:bg-primary-dark h-12 dark:text-white truncate w-4/5">very delicios chickne ckf</div>
    
        </div>
       
          </div>
          <div class="flex flex-col">
          <div class="flex w-1/5 m-2 font-bold font-sans Noto Sans max-h-full flex items-stretch dark:text-white">
            {{ product.price }}
          </div>
          <div class="flex w-1/5 m-2  max-h-full flex items-stretch">
            <button v-if="store.open_status" @click="toCart(product, product.variantId, index)" class="bg-blue-500 hover:bg-blue-700 py-2 px-2 text-white font-bold   rounded">
              
                {{ __('ADD') }}
            </button>
           </div>
          </div>
      </div>
    </div>
    </div>
    </template>
    <script setup>
    import useCommon from '@/utils/common';
    import { onMounted, ref, reactive, computed } from "vue";
    
    const props = defineProps({
      prod: Object,
      store: Object,
      toCart: Function,
      openModal: Function,
      filteredProducts: Object
    })
    
    const { getImagePath } = useCommon()
    </script>