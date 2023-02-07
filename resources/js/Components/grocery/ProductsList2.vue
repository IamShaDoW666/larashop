<template>
  <div class="tab-content">
    <div class="flex flex-wrap  g-4">
      <div class="lg:w-1/2 pr-4 pl-4">
      <!-- <div class=""> -->
      
        
          <div class="px-2 py-2 sm:px-4" v-for="(product, index) in prod" :key="product.id">
            <div class="
                  shadow
                  md:transform md:transition md:duration-300 md:hover:scale-110
                  bg-blue-400
                  rounded-t
                ">
              <img :src="getImagePath(product.image_path, 'large')" class="shadow rounded-t object-cover h-48 w-full md:transform md:transition md:duration-300 md:hover:scale-110" />
            </div>
            <div class="pl-4 pb-2 pt-6 pr-2 bg-gray-300 dark:rounded-b dark:bg-golden-yellow shadow-md">
              <h1 class="truncate font-bold mb-2">{{ product.name }}</h1>
              <div class="flex items-end justify-between">
                <div>
                  <h1>{{ product.price }}</h1>
                </div>
                <div>
                  <button v-if="store.open_status" @click="toCart(product, product.variantId, index)" class="
                        sm:px-2 sm:py-2
                        px-1.5
                        py-1
                        text-lg
                        sm:text-xs
                        lg:text-xs
                        active:bg-green-200
                        hover:ring-blue-900
                        text-white
                        font-bold
                        rounded
                        bg-green-500
                        dark:bg-primary-dark
                        hover:bg-green-400
                        hover:dark:bg-secondary-dark
                      ">
                    {{ __('Add To Cart') }}
                  </button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
      <!-- </div> -->
    </div>
  
</template>

<script setup>
import useCommon from '@/utils/common';

const props = defineProps({
  prod: Object,
  store: Object,
  toCart: Function
})

const { getImagePath } = useCommon()
</script>