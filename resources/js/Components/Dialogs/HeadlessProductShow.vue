<template>
  <TransitionRoot appear :show="productShowOpen" as="template">
    <Dialog
      as="div"
      @close="closeModal"
      class="z-20 overflow-y-scroll"
      :class="currentTheme"
    >
      <TransitionChild
        as="template"
        enter="duration-300 ease-out"
        enter-from="opacity-0"
        enter-to="opacity-100"
        leave="duration-200 ease-in"
        leave-from="opacity-100"
        leave-to="opacity-0"
      >
        <div class="fixed inset-0 bg-black bg-opacity-25" />
      </TransitionChild>

      <div class="fixed inset-0 overflow-y-scroll">
        <div
          class="flex min-h-full items-center justify-center p-4 text-center"
        >
          <TransitionChild
            as="template"
            enter="duration-300 ease-out"
            enter-from="opacity-0 scale-95"
            enter-to="opacity-100 scale-100"
            leave="duration-200 ease-in"
            leave-from="opacity-100 scale-100"
            leave-to="opacity-0 scale-95"
          >
            <DialogPanel
              class="
                w-full
                max-w-3xl
                dark:bg-secondary-dark
                transform
                overflow-visible
                rounded-2xl
                bg-white
                text-left
                align-middle
                shadow-xl
                transition-all
              "
            >
              <div
                class="
                  mt-4
                  px-6
                  pb-6
                  lg:flex
                  gap-x-8
                  justify-between
                  items-start                                    
                "
              >
                <!-- <div
                  class="imagePreviewWrapper shrink-0 w-[300px] h-[200px] sm:h-[200px] sm:w-[400px] lg:h-[200px] lg:w-[200px] mb-3 rounded mx-auto lg:mx-0"
                  :style="{
                    'background-image': url(getImagePath(product.imagePath, 'large')),
                  }"
                /> -->
                <img :alt="product.name" :src="getImagePath(product.image_path, 'large')" class="shrink-0 w-[300px] h-[200px] sm:h-[200px] sm:w-[400px] lg:h-[200px] lg:w-[200px] mb-3 rounded mx-auto lg:mx-0 object-cover" />
                <div class="p-2 mt-4 lg:mt-0 flex-1 max-w-2xl dark:text-white">
                  <h1 class="text-center text-2xl sm:text-3xl p-0.5 font-bold">
                    {{ product.name }}
                  </h1>
                  <p
                    class="
                      mt-4
                      p-3
                      break-all                      
                      border-2
                      rounded-lg
                      bg-gray-100
                      dark:text-black
                      text-left
                    "
                  >
                    {{ product.description }}
                  </p>
                  <div class="mt-3 flex justify-between gap-x-2">
                    <h3
                      class="
                        px-2
                        self-start
                        rounded
                        grow-0
                        py-0.5
                        dark:text-white
                        shadow
                        font-bold
                        text-white
                      "
                    >
                      {{ product.price }}
                    </h3>
                    <!----<div
                                            class="text-md md:text-xl divide-solid divide-y bg-green-300 text-center p-2 rounded-lg text-base font-bold">
                                            <i class="pr-2 fa-solid fa-cart-shopping"></i>{{ cart.getItemQty(product.id)
                                            }}
                                        </div>-->
                  </div>
                  <div v-if="product.variants.length" class="flex flex-wrap gap-x-2 sm:gap-x-5">
                    <div
                      v-for="variant in product.variants"
                      :key="variant.id"
                      class="form-control"
                    >
                      <label class="label cursor-pointer">
                        <div class="flex sm:flex-row flex-col items-center">
                          <h1 class="label-text mr-2 dark:text-white">
                            {{ variant.name }}
                          </h1>
                          <h1
                            class="
                              px-2
                              py-1
                              rounded
                              bg-emerald-500
                              my-2
                              dark:bg-golden-yellow dark:text-black
                              text-white
                              font-bold
                              text-sm
                              mr-2
                            "
                          >
                            {{ variant.price }}
                          </h1>
                        </div>
                        <input
                          type="radio"
                          :id="variant.id"
                          v-model="p_variant"
                          :value="variant.id"
                          name="variant"
                          class="
                            radio
                            checked:bg-slate-500
                            dark:bg-golden-yellow
                          "
                        />
                      </label>
                    </div>
                  </div>
                </div>
              </div>

              <div class="mt-4 p-4 float-right">
                <button
                  :disabled="!checkVariant"
                  type="submit"
                  @click="toCart(product)"
                  class="
                    mr-3
                    active:bg-emerald-500
                    dark:bg-golden-yellow
                    inline-flex
                    justify-center
                    rounded-md
                    border border-transparent
                    bg-emerald-100
                    px-4
                    py-2
                    text-sm
                    font-medium
                    dark:text-black
                    text-emerald-900
                    hover:bg-emerald-200
                    focus:outline-none
                    focus-visible:ring-2
                    focus-visible:ring-emerald-500
                    focus-visible:ring-offset-2
                  "
                >
                  {{ __('Add to Cart') }}
                </button>
                <button
                  type="button"
                  class="
                    inline-flex
                    justify-center
                    rounded-md
                    border border-transparent
                    bg-gray-200
                    dark:bg-golden-yellow
                    px-4
                    py-2
                    text-sm
                    font-medium
                    text-gray-900
                    hover:bg-gray-300
                    focus:outline-none
                    focus-visible:ring-2
                    focus-visible:ring-gray-500
                    focus-visible:ring-offset-2
                  "
                  @click="closeModal()"
                >
                  {{ __('Close') }}
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
import { ref, inject, computed } from "vue";
import { useCart } from "@/Stores/cart";
import { useThemeSwitcher } from "@/Composables/useThemeSwitcher";
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from "@headlessui/vue";
import useCommon from "@/utils/common";

const { currentTheme } = useThemeSwitcher();
const { getImagePath } = useCommon();

const cart = useCart();
const p_variant = ref();
const checkVariant = computed(() => {
  if (!product.value.variants.length) {
    return true;
  } else {
    return p_variant.value ? true : false;
  }
});

function closeModal() {
  p_variant.value = null;
  productShowOpen.value = false;
}

const toCart = (product) => {
  cart.addCart(product, p_variant.value);
};

const { productShowOpen, product } = inject("data");
</script>

<style scoped>
.imagePreviewWrapper {
  display: block;
  cursor: pointer;
  background-size: cover;
  background-position: center center;
}
</style>
