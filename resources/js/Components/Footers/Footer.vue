<template>
  <footer class="bg-blueGray-200 dark:bg-primary-dark pt-8 pb-6">
    <div class="container mx-auto px-4">
      <div class="lg:flex justify-between text-center lg:text-left">
        <div class="px-4">
          <h4 class="text-3xl font-semibold dark:text-white mb-1">
            Ordering as easy as chatwith friend!
          </h4>
          <h5 class="text-lg mt-0 mb-2 text-blueGray-600 dark:text-white mb-2">
            Whatsapp ordering system.
          </h5>
          <div class="flex gap-y-4 sm:gap-y-0 gap-x-4 justify-center lg:justify-start mb-4">
            <Facebook v-if="restaurant.facebook" :link="restaurant.facebook" />
            <Whatsapp v-if="restaurant.phone" :phone="restaurant.phone" />
            <Twitter v-if="restaurant.twitter" :link="restaurant.twitter" />
            <Instagram
              v-if="restaurant.instagram"
              :link="restaurant.instagram"
            />
          </div>
        </div>
        <div class="px-4">
          <ul class="list-unstyled">
            <li>
              <Link
                class="
                  text-blueGray-600 dark:text-white dark:hover:text-blueGray-400
                  hover:text-blueGray-800
                  font-semibold
                  block
                  pb-2
                  text-sm
                "
                :href="route('terms')"
              >
                Terms & Conditions
              </Link>
            </li>
            <li>
              <a
                class="
                  text-blueGray-600 dark:text-white dark:hover:text-blueGray-400
                  hover:text-blueGray-800
                  font-semibold
                  block
                  pb-2
                  text-sm
                "
                href="https://creative-tim.com/privacy?ref=vn-footer"
              >
                Privacy Policy
              </a>
            </li>
          </ul>
        </div>
      </div>
      <hr class="my-6 border-blueGray-300" />
      <div
        class="flex flex-wrap items-center md:justify-between justify-center"
      >
        <div class="w-full md:w-4/12 px-4 mx-auto text-center">
          <div class="text-sm text-blueGray-500 font-semibold py-1">
            Copyright © {{ date }} {{ restaurant.name }}
                      
          </div>
        </div>
      </div>
    </div>
  </footer>
</template>


<script setup>
import { ref } from "vue";
import Facebook from "@/Components/Social/Facebook.vue";
import Whatsapp from "@/Components/Social/Whatsapp.vue";
import Twitter from "@/Components/Social/Twitter.vue";
import Instagram from "@/Components/Social/Instagram.vue";
import { Link } from "@inertiajs/inertia-vue3";
const date = ref(new Date().getFullYear());

const props = defineProps({
  restaurant: Object,
});
</script>
