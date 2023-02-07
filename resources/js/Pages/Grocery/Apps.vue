<template>
  <Admin>
    <GroceryLayout>
      <div class="rounded-t bg-white mb-0 px-6 py-6">
        <div class="text-center flex justify-between">
          <h6 class="text-gray-700 text-xl font-bold">Apps</h6>
          <Link
            :href="
              route('grocerys.show', {
                grocery: $page.props.auth.grocery.slug,
              })
            "
            class="
              bg-emerald-500
              text-white
              active:bg-emerald-600
              font-bold
              uppercase
              text-xs
              px-4
              py-2
              rounded
              shadow
              hover:shadow-md
              outline-none
              focus:outline-none
              mr-1
              ease-linear
              transition-all
              duration-150
            "
            type="button"
          >
            View
          </Link>
        </div>
      </div>
      <div class="flex-auto px-4 lg:px-10 py-10 pt-0">
        <BreezeValidationErrors
          class="mb-4 bg-red-100 rounded my-4 py-2 px-4"
        />
        <form @submit.prevent="update">
          <div class="flex items-center mt-3 mb-6">
            <h6 class="text-blueGray-400 text-sm mr-4 font-bold uppercase">
              Google
            </h6>
            <GoogleIcon width="24" height="24" />
          </div>
          <div class="flex flex-wrap">
            <div class="w-full lg:w-12/12 px-4">
              <div class="relative w-full mb-3">
                <label
                  class="
                    block
                    uppercase
                    text-blueGray-600 text-xs
                    font-bold
                    mb-2
                  "
                  htmlFor="grid-password"
                >
                  Google Maps API Key
                </label>
                <input
                  v-model="form.google_maps_api_key"
                  type="text"
                  class="
                    border-1
                    px-3
                    py-3
                    placeholder-blueGray-300
                    text-blueGray-600
                    bg-white
                    rounded
                    text-sm
                    shadow
                    focus:outline-none focus:ring
                    w-full
                    ease-linear
                    transition-all
                    duration-150
                  "
                />
              </div>
            </div>
            <div class="w-full lg:w-12/12 px-4">
              <div class="relative w-full mb-3">
                <label
                  class="
                    block
                    uppercase
                    text-blueGray-600 text-xs
                    font-bold
                    mb-2
                  "
                  htmlFor="grid-password"
                >
                  Google Analytics Key
                </label>
                <input
                  v-model="form.google_analytics_key"
                  type="text"
                  class="
                    border-1
                    px-3
                    py-3
                    placeholder-blueGray-300
                    text-blueGray-600
                    bg-white
                    rounded
                    text-sm
                    shadow
                    focus:outline-none focus:ring
                    w-full
                    ease-linear
                    transition-all
                    duration-150
                  "
                />
              </div>
            </div>
          </div>
          <div class="flex items-center mt-3 mb-6">
            <h6 class="text-blueGray-400 text-sm mr-4 font-bold uppercase">
              Whatsapp
            </h6>
            <WhatsappIcon width="10" height="10" />
          </div>
          <div class="flex flex-wrap">
            <div class="w-full lg:w-12/12 px-4">
              <div class="relative w-full mb-3">
                <label
                  class="
                    block
                    uppercase
                    text-blueGray-600 text-xs
                    font-bold
                    mb-2
                  "
                  htmlFor="grid-password"
                >
                  Bulk Whatsapp API Key
                </label>
                <input
                  v-model="form.bulk_whatsapp_api_key"
                  type="text"
                  class="
                    border-1
                    px-3
                    py-3
                    placeholder-blueGray-300
                    text-blueGray-600
                    bg-white
                    rounded
                    text-sm
                    shadow
                    focus:outline-none focus:ring
                    w-full
                    ease-linear
                    transition-all
                    duration-150
                  "
                />
              </div>
            </div>
          </div>
          <div class="flex flex-wrap">
            <div class="w-full lg:w-12/12 px-4">
              <div class="relative w-full mb-3">
                <label
                  class="
                    block
                    uppercase
                    text-blueGray-600 text-xs
                    font-bold
                    mb-2
                  "
                  htmlFor="grid-password"
                >
                  Custom domain
                </label>
                <input
                  v-model="form.custom_domain_name"
                  type="text"
                  class="
                    border-1
                    px-3
                    py-3
                    placeholder-blueGray-300
                    text-blueGray-600
                    bg-white
                    rounded
                    text-sm
                    shadow
                    focus:outline-none focus:ring
                    w-full
                    ease-linear
                    transition-all
                    duration-150
                  "
                />
              </div>
            </div>
          </div>
          <div v-if="hasTaxConfig">
            <div class="flex items-center mt-3 mb-6">
              <h6 class="text-blueGray-400 text-sm mr-4 font-bold uppercase">
                Tax Config
              </h6>
              <span class="material-icons">percent</span>
            </div>
            <div class="flex flex-wrap">
              <div class="w-full lg:w-1/2 px-4">
                <div class="relative w-full mb-3">
                  <label
                    class="
                      block
                      uppercase
                      text-blueGray-600 text-xs
                      font-bold
                      mb-2
                    "
                    htmlFor="grid-password"
                  >
                    Tax name
                  </label>
                  <input
                    v-model="form.tax_name"
                    type="text"
                    class="
                      border-1
                      px-3
                      py-3
                      placeholder-blueGray-300
                      text-blueGray-600
                      bg-white
                      rounded
                      text-sm
                      shadow
                      focus:outline-none focus:ring
                      w-full
                      ease-linear
                      transition-all
                      duration-150
                    "
                  />
                </div>
              </div>
              <div class="w-full lg:w-1/2 px-4">
                <div class="relative w-full mb-3">
                  <label
                    class="
                      block
                      uppercase
                      text-blueGray-600 text-xs
                      font-bold
                      mb-2
                    "
                    htmlFor="grid-password"
                  >
                    Tax %
                  </label>
                  <input
                    v-model="form.tax"
                    type="number"
                    class="
                      border-1
                      px-3
                      py-3
                      placeholder-blueGray-300
                      text-blueGray-600
                      bg-white
                      rounded
                      text-sm
                      shadow
                      focus:outline-none focus:ring
                      w-full
                      ease-linear
                      transition-all
                      duration-150
                    "
                  />
                </div>
              </div>
            </div>
          </div>
          <hr class="mt-6 border-b-1 border-blueGray-300" />
          <button
            :class="{ 'opacity-25': form.processing || !form.isDirty }"
            :disabled="form.processing || !form.isDirty"
            class="
              px-4
              py-2
              mt-4
              rounded
              shadow
              bg-blue-500
              hover:bg-blue-600
              text-white
            "
          >
            Update
          </button>
        </form>
      </div>
    </GroceryLayout>
  </Admin>
</template>

<script setup>
import Admin from "@/Layouts/Admin";
import GroceryLayout from "@/Layouts/Grocery.vue";
import GoogleIcon from "@/Components/Social/Icons/GoogleIcon";
import WhatsappIcon from "@/Components/Social/Icons/WhatsappIcon";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Link, useForm, usePage } from "@inertiajs/inertia-vue3";
import Swal from "sweetalert2";
let grocery = usePage().props.value.auth.grocery;
let conf = grocery.config;
const props = defineProps({
  hasTaxConfig: Boolean,
});

const form = useForm({
  tax: usePage().props.value.auth.grocery.config.tax,
  tax_name: usePage().props.value.auth.grocery.config.tax_name ?? "Tax",
  google_maps_api_key: conf.google_maps_api_key ?? "",
  bulk_whatsapp_api_key: conf.bulk_whatsapp_api_key ?? "",
  custom_domain_name: conf.custom_domain_name ?? "",

  google_analytics_key: "",
});

const update = () => {
  form.patch(
    route("owner.grocery.apps.update", {
      grocery: usePage().props.value.auth.grocery.id,
    }),
    {
      onSuccess: () => {
        Swal.fire({
          title: "Updated Successfully!",
          icon: "success",
          timeout: 2000,
        });
      },
    }
  );
};
</script>
