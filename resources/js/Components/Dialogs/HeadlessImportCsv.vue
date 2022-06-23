<template>
    <TransitionRoot appear :show="importOpen" as="template">
        <Dialog as="div" @close="closeModal" class="relative z-10 overflow-y-scroll">
            <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0" enter-to="opacity-100"
                leave="duration-200 ease-in" leave-from="opacity-100" leave-to="opacity-0">
                <div class="fixed inset-0 bg-black bg-opacity-25" />
            </TransitionChild>

            <div class="fixed inset-0 overflow-y-scroll">
                <div class="flex min-h-full items-center justify-center p-4 text-center">
                    <TransitionChild as="template" enter="duration-300 ease-out" enter-from="opacity-0 scale-95"
                        enter-to="opacity-100 scale-100" leave="duration-200 ease-in" leave-from="opacity-100 scale-100"
                        leave-to="opacity-0 scale-95">
                        <DialogPanel
                            class="w-full max-w-3xl transform overflow-hidden rounded-2xl bg-white text-left align-middle shadow-xl transition-all">
                            <DialogTitle as="h3"
                                class="bg-gray-300 text-lg pl-4 py-4 font-medium leading-6 text-gray-900">
                                Import products from .csv file
                            </DialogTitle>

                            <form @submit.prevent="submit">
                                <div class="mt-4 px-6 pb-6">
                                    <div class="w-1/2 px-4 mb-5 mt-4">
                                        <input id="image" ref="fileInput" type="file" class="mt-1 block w-full"
                                            @input="pickFile">
                                    </div>
                                </div>

                                <div class="mt-4 p-4 float-right">
                                    <button type="submit"
                                        class="mr-3 inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                                       @click="submit" >
                                        Create
                                    </button>
                                    <button type="button"
                                        class="inline-flex justify-center rounded-md border border-transparent bg-gray-200 px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2"
                                        @click="closeModal">
                                        Cancel
                                    </button>
                                </div>
                            </form>
                        </DialogPanel>
                    </TransitionChild>
                </div>
            </div>
        </Dialog>
    </TransitionRoot>
</template>

<script setup>
import { ref, inject, reactive } from 'vue';
import {
    TransitionRoot,
    TransitionChild,
    Dialog,
    DialogPanel,
    DialogTitle,
} from '@headlessui/vue';
import Swal from 'sweetalert2';
import { useForm, usePage } from '@inertiajs/inertia-vue3';

const form = useForm({
    csv: null,
    restorant_id: usePage().props.value.auth.restorant.id
})

const { importOpen } = inject('data')
const fileInput = ref();
const pickFile = () => {
    form.csv = fileInput.value.files[0];
}
function closeModal() {
    importOpen.value = false
}
function openModal() {
    importOpen.value = true
}

const submit = () => {
    form.post(route('owner.products.import'), {
        onSuccess: () => {
            closeModal();
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
