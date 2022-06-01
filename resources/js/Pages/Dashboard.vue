<script>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { Head, Link } from '@inertiajs/inertia-vue3';
export default {
    components: {
      Head,
      BreezeAuthenticatedLayout,
      Link
    },

    props: {
      restorants: Object
    }
}

</script>

<template>
    <Head title="Dashboard" />

    <BreezeAuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                Dashboard
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 bg-white border-b border-gray-200">
                      <div class="grid grid-cols-2 sm:grid-cols-3 rounded bg-white p-2">
                        <div v-for="restorant in restorants">
                          <div class="px-2 rounded shadow">
                            <Link class="cursor-pointer" :href="route('restorants.show', { restorant: restorant.uuid })">
                              {{ restorant.name }}
                            </Link>
                          </div>
                        </div>
                      </div>
                    </div>
                </div>
            </div>
        </div>
    </BreezeAuthenticatedLayout>
</template>
