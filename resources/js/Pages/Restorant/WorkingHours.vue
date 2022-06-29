<template>
    <Admin :headerStats="false">

        <Head title="Products" />
        <div
            class="relative flex mt-2 sm:mt-4 flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
            <div class="rounded-t bg-slate-50 mb-0 px-6 py-6">
                <div class="text-center flex justify-between">
                    <h6 class="text-gray-700 text-xl font-bold">Working Hours</h6>
                </div>
            </div>

            <div class="overflow-x-auto bg-white">
                <form @submit.prevent="submit">
                    <table class="table table-compact w-full">
                        <thead>
                            <tr>
                                <th class="text-center" style="z-index: 0!important">Day</th>
                                <th>Opening Time</th>
                                <th>Closing Time</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <th class="text-center" style="z-index: 0!important">
                                    <span
                                        class="text-sm font-medium mr-2 px-3 py-0.5 rounded-full bg-green-200 text-green-800">
                                        Monday
                                    </span>
                                </th>
                                <td>
                                    <input class="rounded-lg" type="time" v-model="form.m_from">
                                </td>
                                <td>
                                    <input class="rounded-lg" type="time" v-model="form.m_to">
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" style="z-index: 0!important">
                                    <span
                                        class="text-sm font-medium mr-2 px-3 py-0.5 rounded-full bg-green-200 text-green-800">
                                        Tuesday
                                    </span>
                                </th>
                                <td>
                                    <input class="rounded-lg" type="time" v-model="form.t_from">
                                </td>
                                <td>
                                    <input class="rounded-lg" type="time" v-model="form.t_to">
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" style="z-index: 0!important">
                                    <span
                                        class="text-sm font-medium mr-2 px-3 py-0.5 rounded-full bg-green-200 text-green-800">
                                        Wednesday
                                    </span>
                                </th>
                                <td>
                                    <input class="rounded-lg" type="time" v-model="form.w_from">
                                </td>
                                <td>
                                    <input class="rounded-lg" type="time" v-model="form.w_to">
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" style="z-index: 0!important">
                                    <span
                                        class="text-sm font-medium mr-2 px-3 py-0.5 rounded-full bg-green-200 text-green-800">
                                        Thursday
                                    </span>
                                </th>
                                <td>
                                    <input class="rounded-lg" type="time" v-model="form.th_from">
                                </td>
                                <td>
                                    <input class="rounded-lg" type="time" v-model="form.th_to">
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" style="z-index: 0!important">
                                    <span
                                        class="text-sm font-medium mr-2 px-3 py-0.5 rounded-full bg-green-200 text-green-800">
                                        Friday
                                    </span>
                                </th>
                                <td>
                                    <input class="rounded-lg" type="time" v-model="form.f_from">
                                </td>
                                <td>
                                    <input class="rounded-lg" type="time" v-model="form.f_to">
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" style="z-index: 0!important">
                                    <span
                                        class="text-sm font-medium mr-2 px-3 py-0.5 rounded-full bg-green-200 text-green-800">
                                        Saturday
                                    </span>
                                </th>
                                <td>
                                    <input class="rounded-lg" type="time" v-model="form.s_from">
                                </td>
                                <td>
                                    <input class="rounded-lg" type="time" v-model="form.s_to">
                                </td>
                            </tr>
                            <tr>
                                <th class="text-center" style="z-index: 0!important">
                                    <span
                                        class="text-sm font-medium mr-2 px-3 py-0.5 rounded-full bg-green-200 text-green-800">
                                        Sunday
                                    </span>
                                </th>
                                <td>
                                    <input class="rounded-lg" type="time" v-model="form.su_from">
                                </td>
                                <td>
                                    <input class="rounded-lg" type="time" v-model="form.su_to">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit"
                        class="px-4 py-2 float-right mr-5 mb-4 rounded bg-blue-500 hover:bg-blue-400 text-white font-bold">
                        Update
                    </button>
                    <input class="rounded-lg" type="time" v-model="form.m_from">
                </form>
            </div>
        </div>
    </Admin>
</template>

<script setup>
import Admin from "@/Layouts/Admin.vue";
import { ref } from "vue";
import Swal from 'sweetalert2';
import { Head, usePage, useForm } from "@inertiajs/inertia-vue3";
const props = defineProps({
    hours: Object
})

const form = useForm({
    m_from: props.hours.m_from,
    m_to: props.hours.m_to,
    t_from: props.hours.t_from,
    t_to: props.hours.t_to,
    w_from: props.hours.w_from,
    w_to: props.hours.w_to,
    th_from: props.hours.th_from,
    th_to: props.hours.th_to,
    f_from: props.hours.f_from,
    f_to: props.hours.f_to,
    s_from: props.hours.s_from,
    s_to: props.hours.s_to,
    su_from: props.hours.su_from,
    su_to: props.hours.su_to,
})

const submit = async () => {
    form.transform((data) => ({
        ...data,

    })).post(route('owner.restorant.update-working-hours', { restorant: usePage().props.value.auth.restorant.id }), {
        preserveScroll: true,
        onSuccess: () => {
            const Toast = Swal.mixin({
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 1500,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer)
                    toast.addEventListener('mouseleave', Swal.resumeTimer)
                }
            })

            Toast.fire({
                icon: 'success',
                title: usePage().props.value.flash.message
            })
        }
    })
}

</script>