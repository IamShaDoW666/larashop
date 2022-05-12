<template>
  <TransitionRoot appear :show="productOpen" as="template">
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
              class="w-full max-w-3xl transform overflow-hidden rounded-2xl bg-white text-left align-middle shadow-xl transition-all">
              <DialogTitle
                as="h3"
                class="bg-gray-300 text-lg pl-4 py-4 font-medium leading-6 text-gray-900"
              >
                Add Product
              </DialogTitle>

              <div class="mt-4 px-6 pb-6">
                <form @submit.prevent="resetPreview">
                  <div class="w-1/2 px-4 mb-5 mt-4">
                    <input id="image" ref="fileInput" type="file" class="mt-1 block w-full" @input="pickFile">
                  </div>
                  <div v-if="previewImage"
                  class="imagePreviewWrapper mb-3"
                  :style="{ 'background-image': `url(${previewImage})` }"
                  @click="selectImage">
                  </div>
                  <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-2 gap-y-2">
                    <div>
                      <BreezeLabel for="name" value="Product Name" />
                      <input id="name" type="text" class="mt-2 border-gray-300 w-full
                      sm:w-2/3 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.name" required>
                    </div>

                    <div>
                      <BreezeLabel for="description" value="Description" />
                      <textarea id="description" class="mt-2 border-gray-300 focus:border-w-full indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.description" required></textarea>
                    </div>

                    <div>
                      <BreezeLabel for="price" value="Price" />
                      <input id="price" type="number" class="mt-2 border-gray-300 w-full sm:w-2/3 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm" v-model="form.price" required>
                    </div>

                    <div>
                      <BreezeLabel for="category" value="Category" />
                      <!-- <select class="mt-2" v-model="form.category_id" name="category_id" id="category_id">
                        <option v-for="category in categories" :key="category.id" :value="category.id">
                          {{ category.name }}
                        </option>
                      </select> -->
                      <HeadlessList class="mt-2" />
                    </div>
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
import { ref, inject, provide, onMounted, watch } from 'vue';
import { useForm, Link } from '@inertiajs/inertia-vue3';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import HeadlessList from '@/Components/Dropdowns/HeadlessList.vue';
import {
  TransitionRoot,
  TransitionChild,
  Dialog,
  DialogPanel,
  DialogTitle,
} from '@headlessui/vue';
import Swal from 'sweetalert2';

const { productOpen } = inject('data')
const emit = defineEmits(['input'])
const form = useForm({
  name: '',
  description: '',
  price: '',
  product_image: null,
  category: {}

})


provide('form', {
  form
})

const fileInput = ref();
const previewImage = ref();

function closeModal() {
  productOpen.value = false
}
function openModal() {
  productOpen.value = true
}

const pickFile = () => {
  form.product_image = fileInput.value.files[0];
  if (fileInput.value.files[0]) {
    const reader = new FileReader
    reader.onload = e => {
      previewImage.value = e.target.result
    }
    reader.readAsDataURL(fileInput.value.files[0])
    emit('input', fileInput.value.files[0])
  }
}

const submit = () => {
  if (!form.name || !form.price || !form.description) {
    closeModal()
    Swal.fire({
      icon: 'warning',
      title: 'All fields are required',
      timer: 1000,
      position: 'top'
    }).then(openModal())
  } else {
    form.post(route('products.store'), {
      onSuccess: () => {
        form.reset()
        previewImage.value = null
        closeModal()
        Swal.fire({
          icon: 'success',
          title: "Product Added!",
          timer: 2000,
          position: 'top'
        })
      }
    })
  }
}

</script>

<style scoped>
.imagePreviewWrapper {
  display: block;
  width: 200px;
  height: 200px;
  cursor: pointer;
  background-size: cover;
  background-position: center center;
}
</style>
