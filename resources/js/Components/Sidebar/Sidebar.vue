<template>
  <nav
    class="md:left-0 md:block md:fixed md:top-0 md:bottom-0 md:overflow-y-auto md:flex-row md:flex-nowrap md:overflow-hidden shadow-xl bg-white flex flex-wrap items-center justify-between relative md:w-64 z-10 py-4 px-6">
    <div
      class="md:flex-col md:items-stretch md:min-h-full md:flex-nowrap px-0 flex flex-wrap items-center justify-between w-full mx-auto">
      <!-- Toggler -->
      <button
        class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
        type="button" v-on:click="toggleCollapseShow('bg-white m-2 py-3 px-6')">
        <i class="fas fa-bars"></i>
      </button>
      <!-- Brand -->
      <Link :href="route('grocerys.show', { grocery: $page.props.auth.grocery.slug ?? 'nothn' })"
        class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0">
      {{ $page.props.auth.grocery.name }}
      </Link>
      <!-- User -->
      <ul class="md:hidden items-center flex flex-wrap list-none">
        <li class="inline-block relative">
          <user-dropdown />
        </li>
      </ul>
      <!-- Collapse -->
      <div
        class="md:flex md:flex-col md:items-stretch md:opacity-100 md:relative md:mt-4 md:shadow-none shadow absolute top-0 left-0 right-0 z-40 overflow-y-auto overflow-x-hidden h-auto items-center flex-1 rounded"
        v-bind:class="collapseShow">
        <!-- Collapse header -->
        <div class="md:min-w-full md:hidden block pb-4 mb-4 border-b border-solid border-blueGray-200">
          <div class="flex flex-wrap">
            <div class="w-6/12">
              <Link :href="route('grocerys.show', { grocery: $page.props.auth.grocery.slug ?? 'Nothing' })"
                class="md:block text-left md:pb-2 text-blueGray-600 mr-0 inline-block whitespace-nowrap text-sm uppercase font-bold p-4 px-0">
              {{ $page.props.auth.grocery.name }}
              </Link>
            </div>
            <div class="w-6/12 flex justify-end">
              <button type="button"
                class="cursor-pointer text-black opacity-50 md:hidden px-3 py-1 text-xl leading-none bg-transparent rounded border border-solid border-transparent"
                v-on:click="toggleCollapseShow('hidden')">
                <i class="fas fa-times"></i>
              </button>
            </div>
          </div>
        </div>
        <!-- Heading -->
        <h6 class="md:min-w-full text-blueGray-500 text-xs uppercase font-bold block pt-1 pb-4 no-underline">
          {{ __('Admin') }}
        </h6>
        <!-- Navigation -->

        <ul class="md:flex-col md:min-w-full flex flex-col space-y-4 list-none">
          <li v-if="$page.props.impersonate" :class="{ 'text-black font-bold': route().current('admin.dashboard') }"
            class="items-center hover:text-gray-500">
            <div>
              <button @click="stopImpersonate">
              <i class="fas fa-tv mr-2 text-sm"></i>
              {{ __('Go back') }}
              </button>
            </div>
          </li>
          <li :class="{ 'text-black font-bold': route().current('admin.dashboard') }"
            class="items-center hover:text-gray-500">
            <div>
              <Link :href="route('admin.dashboard')">
              <i class="fas fa-tv mr-2 text-sm"></i>
              {{ __('Dashboard') }}
              </Link>
            </div>
          </li>

          <li :class="{ 'text-black font-bold': route().current('admin.settings') }"
            class="items-center hover:text-gray-500">
            <div>
              <Link :href="route('admin.settings')" preserve-scroll>
              <i class="fas fa-tools mr-2 text-sm"></i>
              {{ __('Settings') }}
              </Link>
            </div>
          </li>

          <li :class="{ 'text-black font-bold': route().current('owner.grocery.index') }"
            class="items-center hover:text-gray-500">
            <div>
              <Link :href="route('owner.grocery.index')" preserve-scroll>
              <i class="mr-2 fa-solid fa-store"></i>
             {{ __(' store') }}
              </Link>
            </div>
          </li>

          <li :class="{ 'text-black font-bold': route().current('products.index') }"
            class="items-center hover:text-gray-500">
            <div>
              <Link :href="route('products.index')" preserve-scroll>
              <i class="fa-solid fa-cart-arrow-down"></i>
              {{ __('Items') }}
              </Link>
            </div>
          </li>

          <li :class="{ 'text-black font-bold': route().current('admin.orders.index') }"
            class="items-center hover:text-gray-500">
            <div>
              <Link :href="route('admin.orders.index')" preserve-scroll>
              <i class="material-icons mr-2 text-sm">list</i>
             {{ __('Orders') }}
              </Link>
            </div>
          </li>

          <li :class="{ 'text-black font-bold': route().current('areas.index') }"
            class="items-center hover:text-gray-500">
            <div>
              <Link :href="route('areas.index')" preserve-scroll>
              <i class="fa-solid fa-truck mr-2 text-sm"></i>
              {{ __('Delivery Areas') }}
              </Link>
            </div>
          </li>
          <li :class="{ 'text-black font-bold': route().current('tables.index') }"
            class="items-center hover:text-gray-500">
            <div>
              <Link :href="route('tables.index')" preserve-scroll>
              <i class="fa-solid fa-truck mr-2 text-sm"></i>
              {{ __('Table') }}
              </Link>
            </div>
          </li>

          <li :class="{ 'text-black font-bold': route().current('owner.grocery.share') }"
            class="items-center hover:text-gray-500">
            <div>
              <Link :href="route('owner.grocery.share')" preserve-scroll>
              <i class="material-icons mr-2 text-sm">mobile_screen_share</i>
              {{ __('Share') }}
              </Link>
            </div>
          </li>

          <li :class="{ 'text-black font-bold': route().current('owner.grocery.working-hours') }"
            class="items-center hover:text-gray-500">
            <div>
              <Link :href="route('owner.grocery.working-hours')" preserve-scroll>
              <i class="material-icons mr-2 text-sm">schedule</i>
              {{ __('Working Hours') }}
              </Link>
            </div>
          </li>

          <li :class="{ 'text-black font-bold': route().current('owner.grocery.plan.show') }"
            class="items-center hover:text-gray-500">
            <div>
              <Link :href="route('owner.grocery.plan.show')" preserve-scroll>
              <i class="material-icons mr-2 text-sm">sticky_note_2</i>
              {{ __('Plan') }}
              </Link>
            </div>
          </li>

          <li :class="{ 'text-black font-bold': route().current('owner.grocery.location') }"
            class="items-center hover:text-gray-500">
            <div>
              <Link :href="route('owner.grocery.location')" preserve-scroll>
              <i class="material-icons mr-2 text-sm">place</i>
              {{ __('Location') }}
              </Link>
            </div>
          </li>

          <!-- <li class="items-center hover:text-gray-500">
    <div>
      <a>
        <i class="fas fa-map-marked mr-2 text-sm"></i>
        Maps
      </a>
    </div>
  </li> -->
        </ul>
        <!-- Divider -->
        <hr class="my-4 md:min-w-full" />
        <!-- Heading -->

        <!-- Navigation -->
      </div>
    </div>
  </nav>
</template>

<script>
import UserDropdown from "@/Components/Dropdowns/UserDropdown.vue";
import { Link } from "@inertiajs/inertia-vue3";
import { Inertia } from "@inertiajs/inertia";
export default {
  data() {
    return {
      collapseShow: "hidden",
    };
  },
  methods: {
    toggleCollapseShow: function (classes) {
      this.collapseShow = classes;
    },

    stopImpersonate: function () {
      Inertia.post(route('stopimpersonate'))
    }
  },
  components: {
    UserDropdown,
    Link,
  },
};
</script>
