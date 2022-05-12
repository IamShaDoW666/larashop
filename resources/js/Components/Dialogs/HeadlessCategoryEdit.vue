<template>
  <TransitionRoot appear :show="categoryOpenEdit" as="template">
    <Dialog as="div" @close="closeModal" class="relative z-10">
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
        <div class="flex min-h-full items-center justify-center p-4 text-center">
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
              class="w-full max-w-md transform overflow-hidden rounded-2xl bg-white text-left align-middle shadow-xl transition-all">
              <DialogTitle
                as="h3"
                class="bg-gray-300 text-lg pl-4 py-4 font-medium leading-6 text-gray-900"
              >
                Edit Category
              </DialogTitle>

              <form @submit.prevent="submit">
                <div class="mt-4 px-6 pb-6">
                  <BreezeLabel for="name" value="Category Name" />
                  <input type="text" class="mt-4 border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="nForm.name" >
                </div>

                <div class="mt-4 p-4 float-right">
                  <button
                  type="submit"
                  class="mr-3 inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  >
                  Update
                </button>
                <button
                type="button"
                class="inline-flex justify-center rounded-md border border-transparent bg-gray-200 px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2"
                @click="closeModal"
                >
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
import { ref, reactive, inject, onMounted } from 'vue';
import { useForm, Link } from '@inertiajs/inertia-vue3';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue';
import Swal from 'sweetalert2';

const { dCategory, categoryOpenEdit } = inject('data');

const nForm = useForm({
  name: dCategory.value.name

})

function closeModal() {
  categoryOpenEdit.value = false
}
function openModal() {
  categoryOpenEdit.value = true
}


const submit = () => {
  if (nForm.name == '') {
    closeModal()
    Swal.fire({
      icon: 'warning',
      title: 'Name is required',
      timer: 1000,
      position: 'top'
    })
  } else {
    nForm.patch(route('categories.update', { category: dCategory.value.id }), {
      onSuccess: () => {
        closeModal()
        Swal.fire({
          icon: 'success',
          title: "Category Updated!",
          timer: 2000,
          // position: 'top'
        })
      }
    })
  }
}

</script>
