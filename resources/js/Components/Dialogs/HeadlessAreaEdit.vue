<template>
  <TransitionRoot appear :show="areaOpenEdit" as="template">
    <Dialog as="div" @close="closeModal" class="relative z-10 overflow-y-scroll">
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
              class="w-full max-w-3xl transform overflow-visible rounded-2xl bg-white text-left align-middle shadow-xl transition-all">
              <DialogTitle
                as="h3"
                class="bg-gray-300 text-lg pl-4 py-4 font-medium leading-6 text-gray-900"
              >
                Edit Delivery Area
              </DialogTitle>

              <div class="mt-4 px-6 pb-6">
                <form>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-2 gap-y-2">
                    <div>
                      <BreezeLabel for="name" value="Area Name" />
                      <input id="name" type="text" class="mt-2 border-gray-300 w-full
                      sm:w-2/3 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.name" required>
                    </div>
<!--
                    <div>
                      <BreezeLabel for="description" value="Description" />
                      <textarea id="description" class="mt-2 border-gray-300 focus:border-w-full indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.description" required></textarea>
                    </div> -->

                    <div>
                      <BreezeLabel for="price" value="Delivery Charge" />
                      <input id="price" type="number" class="mt-2 border-gray-300 w-full sm:w-2/3 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.delivery_fee" required>
                    </div>

                    <!-- <div>
                      <BreezeLabel for="Area Name" value="Area" />
                      <select class="mt-2" v-model="form.category_id" name="category_id" id="category_id">
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                          {{ category.name }}
                        </option>
                      </select>
                      <HeadlessList class="mt-2" />
                      <HeadlessCombo class="mt-2" />
                    </div> -->
                  </div>

                </form>
              </div>

              <div class="mt-4 p-4 float-right">
                <button
                  type="submit" :disabled="form.processing"
                  class="mr-3 inline-flex justify-center rounded-md border border-transparent bg-blue-100 px-4 py-2 text-sm font-medium text-blue-900 hover:bg-blue-200 focus:outline-none focus-visible:ring-2 focus-visible:ring-blue-500 focus-visible:ring-offset-2"
                  @click="submit"
                >
                  Create
                </button>
                <button
                  type="button"
                  class="inline-flex justify-center rounded-md border border-transparent bg-gray-200 px-4 py-2 text-sm font-medium text-gray-900 hover:bg-gray-300 focus:outline-none focus-visible:ring-2 focus-visible:ring-gray-500 focus-visible:ring-offset-2"
                  @click="closeModal"
                >
                  Cancel
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
import { ref, inject } from 'vue';
import { useForm, Link } from '@inertiajs/inertia-vue3';
import BreezeLabel from '@/Components/Label.vue';
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue';
import Swal from 'sweetalert2';

const { areaOpenEdit, dArea } = inject('data')

const form = useForm({
  name: dArea.value.name,
  delivery_fee: dArea.value.delivery_fee_int
})

function closeModal() {
  areaOpenEdit.value = false
}
function openModal() {
  areaOpenEdit.value = true
}


const submit = () => {
  form.patch(route('areas.update', { area: dArea.value.id }), {
    onSuccess: () => {
      form.reset()
      closeModal()
      Swal.fire({
        icon: 'success',
        title: 'Delivery Area Updated!',
        timer: 1500
      })
    }
  })
}

</script>
