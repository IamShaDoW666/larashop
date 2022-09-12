<template>
    <div class="py-10">
        <div
            class="max-w-7xl mx-auto sm:px-2 lg:px-2 bg-white dark:bg-primary-dark overflow-hidden shadow-sm sm:rounded-lg shadow-lg"
        >
            <!-- <div class=""> -->
            <div
                class="p-1 bg-white dark:bg-primary-dark border-b border-gray-200"
            >
                <div
                    class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-y-4 sm:gap-y-8"
                >
                    <div
                        class="px-2 py-2 sm:px-4"
                        v-for="(product, index) in filteredProducts"
                        :key="product.id"
                    >
                        <div @click="openModal(product.id);"
                            class="shadow md:transform md:transition md:duration-300 md:hover:scale-110 bg-blue-400 rounded-t"
                        >
                            <img
                                :src="getImagePath(product.image_path, 'large')"
                                class="shadow rounded-t object-cover h-48 w-full"
                            />
                        </div>
                        <div
                            class="pl-4 pb-2 pt-6 pr-2 bg-gray-300 dark:rounded-b dark:bg-golden-yellow shadow-md"
                        >
                            <h1 class="truncate font-bold mb-2">
                                {{ product.name }}
                            </h1>
                            <div class="flex items-end justify-between">
                                <div>
                                    <h1>{{ product.price }}</h1>
                                </div>
                                <div>
                                    <button
                                        v-if="restaurant.open_status"
                                        @click="
                                            toCart(
                                                product,
                                                product.variantId,
                                                index
                                            )
                                        "
                                        class="sm:px-2 sm:py-2 px-1.5 py-1 text-lg sm:text-xs lg:text-xs active:bg-green-200 hover:ring-blue-900 text-white font-bold rounded bg-green-500 dark:bg-primary-dark hover:bg-green-400 hover:dark:bg-secondary-dark"
                                    >
                                        {{ __("Add To Cart") }}
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- </div> -->
        </div>
    </div>
</template>

<script setup>
import useCommon from "@/utils/common";
import { onMounted, ref, reactive, computed } from "vue";

const props = defineProps({
    prod: Object,
    restaurant: Object,
    toCart: Function,
    filteredProducts: Object,
    openModal: Function
});

const { getImagePath } = useCommon();
</script>
