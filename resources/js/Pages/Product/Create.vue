<template>
  <Head title="Add Products" />
  <BreezeAuthenticatedLayout>
    <div class="py-4 mt-4 grid flex justify-center items-center">
      <form @submit.prevent="submit">
          <div>
              <BreezeLabel for="name" value="Product Name" />
              <BreezeInput id="name" type="name" class="mt-1 block w-full" v-model="form.name" required  />
          </div>

          <div class="mt-4">
              <BreezeLabel for="description" value="Description" />
              <textarea id="description" type="description" class="mt-1 block w-full" v-model="form.description" required autocomplete="current-description"></textarea>
          </div>

          <div>
            <BreezeLabel for="name" value="Product Price" />
            <BreezeInput id="name" type="number" class="mt-1 block w-full" v-model="form.price" required  />
          </div>

          <div class="mt-4">
            <select name="category" v-model="form.category_id" id="category_id">
              <option v-for="category in categories"  :key="category.id" :value="category.id">{{ category.name }}</option>
            </select>
          </div>

          <div class="flex items-center justify-end mt-4">
              <BreezeButton @click="createProduct" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                  Create Product
              </BreezeButton>
          </div>
      </form>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, Link, useForm } from '@inertiajs/inertia-vue3';
import BreezeButton from '@/Components/Button.vue';
import BreezeCheckbox from '@/Components/Checkbox.vue';
import BreezeGuestLayout from '@/Layouts/Guest.vue';
import BreezeInput from '@/Components/Input.vue';
import BreezeLabel from '@/Components/Label.vue';
import BreezeValidationErrors from '@/Components/ValidationErrors.vue';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
export default {
  components: {
    BreezeAuthenticatedLayout,
    BreezeButton,
    BreezeCheckbox,
    BreezeGuestLayout,
    BreezeLabel,
    BreezeValidationErrors,
    BreezeInput,

    Head
  },

  props: {
    categories: Object
  },

  setup(props) {
    const form = useForm({
      name: '',
      price: 0,
      description: '',
      category_id: 0,
      product_image: null
    });

    const createProduct = () => {
      form.post(route('products.store'), {
          onFinish: () => alert('Product Added!'),
      });
    }

    return {
      form,
      createProduct
    }
  }

}
</script>
