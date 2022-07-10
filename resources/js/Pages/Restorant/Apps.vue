<template>
    <Admin>
        <RestaurantLayout>
            <div class="rounded-t bg-white mb-0 px-6 py-6">
                <div class="text-center flex justify-between">
                    <h6 class="text-gray-700 text-xl font-bold">Apps</h6>
                    <Link
                        :href="
                            route('restorants.show', {
                                restorant: $page.props.auth.restorant.slug,
                            })
                        "
                        class="bg-emerald-500 text-white active:bg-emerald-600 font-bold uppercase text-xs px-4 py-2 rounded shadow hover:shadow-md outline-none focus:outline-none mr-1 ease-linear transition-all duration-150"
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
                    <h6
                        class="text-blueGray-400 text-sm mt-3 mb-6 font-bold uppercase"
                    >
                        Webhooks
                    </h6>
                    <div class="flex flex-wrap">

                    </div>
                </form>
            </div>
        </RestaurantLayout>
    </Admin>
</template>

<script setup>
import Admin from "@/Layouts/Admin";
import RestaurantLayout from "@/Layouts/Restaurant.vue";
import BreezeValidationErrors from "@/Components/ValidationErrors.vue";
import { Link } from '@inertiajs/inertia-vue3';
</script>
