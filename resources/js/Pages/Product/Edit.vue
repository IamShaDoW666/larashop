<template>
    <Admin :headerStats="false">
        <HeadlessVariant />
        <HeadlessVariantEdit v-if="variantEditOpen" />
        <div
            class="relative flex mt-2 sm:mt-4 flex-col min-w-0 break-words w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0">
            <div class="rounded-t bg-slate-50 mb-0 px-6 py-6">
                <div class="text-center flex justify-between">
                    <h6 class="text-gray-700 text-xl font-bold">Edit Product</h6>
                    <!-- <button @click="areaOpen = true" class="px-4 py-2 text-sm rounded shadow bg-blue-500 text-white hover:bg-blue-700">Create</button> -->
                </div>
            </div>
            <div class="bg-blueGray-100 mt-4 px-6 pb-6">
                <form @submit.prevent="submit">
                    <div class="w-1/2 px-4 mb-5 mt-4">
                        <input id="image" ref="fileInput" type="file" class="mt-1 block w-full" @input="pickFile">
                    </div>
                    <div v-if="previewImage" class="imagePreviewWrapper mb-3"
                        :style="{ 'background-image': `url(${previewImage})` }" @click="selectImage">
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-x-2 gap-y-2">
                        <div>
                            <BreezeLabel for="name" value="Product Name" />
                            <input id="name" type="text"
                                class="mt-2 border-gray-300 w-full
                      sm:w-2/3 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                v-model="form.name" required>
                        </div>

                        <div>
                            <BreezeLabel for="description" value="Description" />
                            <textarea id="description"
                                class="mt-2 border-gray-300 focus:border-w-full indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                v-model="form.description" required></textarea>
                        </div>

                        <div>
                            <BreezeLabel for="price" value="Price" />
                            <input id="price" type="text"
                                class="mt-2 border-gray-300 w-full sm:w-2/3 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 rounded-md shadow-sm"
                                v-model="form.price" required>
                        </div>

                        <div>
                            <BreezeLabel for="category" value="Category" />
                            <HeadlessList :cat="cat" :cats="categories" class="mt-2 z-10" />
                        </div>
                    </div>
                    <div class="mt-4" v-if="product?.variants?.length">
                        <div class="flex justify-between">
                            <BreezeLabel for="variants" value="Variants" />
                            <button v-if="product?.variants?.length" type="button" @click="variantOpen = !variantOpen"
                                class="text-sm mt-4 px-4 py-2 bg-green-500 hover:bg-green-400 text-white font-bold rounded shadow">Add
                                Variant</button>
                        </div>
                        <div class="overflow-x-auto mt-4">
                            <table class="table w-full">
                                <!-- head -->
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th>Name</th>
                                        <th>Price</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <!-- row 1 -->
                                    <tr v-for="(variant, index) in product?.variants" :key="variant.id">
                                        <td>{{ index + 1 }}</td>
                                        <td>{{ variant.name }}</td>
                                        <td>{{ variant.price }}</td>
                                        <td>
                                            <button @click="editVariant(variant)" type="button"
                                                class="px-2 mr-2 py-0.5 rounded shadow bg-blue-400 hover:bg-blue-300 text-white font-bold text-sm">Edit</button>
                                            <button @click="deleteVariant(variant.id)" type="button"
                                                class="px-2 py-0.5 rounded shadow bg-red-400 hover:bg-red-300 text-white font-bold text-sm">Delete</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div v-else>
                        <button type="button" @click="variantOpen = !variantOpen"
                            class="text-sm mt-4 px-4 py-2 bg-green-500 hover:bg-green-400 text-white font-bold rounded shadow">Add
                            Variant</button>
                    </div>
                    <button type="submit"
                        class="float-right bg-blue-400 hover:bg-blue-300 text-white font-bold px-4 py-2 rounded shadow">Update</button>
                </form>
            </div>
        </div>
    </Admin>
</template>

<script setup>
import Admin from '@/Layouts/Admin.vue';
import { ref, provide, onMounted } from 'vue';
import { useForm, Link } from '@inertiajs/inertia-vue3';
import { Inertia } from '@inertiajs/inertia';
import BreezeLabel from '@/Components/Label.vue';
import HeadlessList from '@/Components/Dropdowns/HeadlessList.vue';
import HeadlessVariant from '@/Components/Dialogs/HeadlessVariant.vue';
import HeadlessVariantEdit from '@/Components/Dialogs/HeadlessVariantEdit.vue';
import Swal from 'sweetalert2';

const variantOpen = ref(false);
const variantEditOpen = ref(false);
const emit = defineEmits(['input'])
const previewImage = ref(`${props.product.image_path}_large.webp`)
const fileInput = ref();
const props = defineProps({
    product: Object,
    categories: Object
})
const cat = ref();
const dVariant = ref({});

onMounted(() => {
    cat.value = props.categories.find(category => category.id == props.product.category_id)
})

const form = useForm({
    name: props.product.name,
    description: props.product.description,
    price: props.product.price_int,
    category: cat.value,
    product_image: `${props.product.image_path}_large.webp`

})


provide('form', {
    form
})

provide('data', {
    dCategory: cat,
    dVariant,
    categories: props.categories,
    variantOpen,
    variantEditOpen,
    product: props.product
})

const editVariant = (variant) => {
    dVariant.value = variant
    variantEditOpen.value = !variantEditOpen.value
}

const deleteVariant = (id) => {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Variant will be deleted permanently',
        showDenyButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            Inertia.delete(route('variant.destroy', { variant: id }), {
                onSuccess: () => {
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted Successfully!'
                    })
                }
            })
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })
}

const deleteProduct = () => {
    Swal.fire({
        title: 'Are you sure?',
        text: 'Product will be deleted permanently',
        showDenyButton: true,
        confirmButtonText: 'Yes',
        denyButtonText: 'No',
    }).then((result) => {
        if (result.isConfirmed) {
            form.delete(route('products.destroy', { product: props.product.id }), {
                onSuccess: () => {
                    closeModal()
                    Swal.fire({
                        icon: 'success',
                        title: 'Deleted Successfully!'
                    })
                }
            })
        } else if (result.isDenied) {
            Swal.fire('Changes are not saved', '', 'info')
        }
    })
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
    if (form.name == '' || form.price == '' || form.description == '') {
        Swal.fire({
            icon: 'warning',
            title: 'All fields are required',
            timer: 1000,
            position: 'top'
        })
    } else {
        //Use manual Inertia.post to upload file
        Inertia.post(route('products.update', { product: props.product.id }),
            {
                name: form.name,
                description: form.description,
                price: form.price,
                category: form.category,
                product_image: form.product_image,

                _method: 'put',  //disguise as put method

            },

            {
                onSuccess: () => {
                    Swal.fire({
                        icon: 'success',
                        title: "Product Updated!",
                        timer: 2000,
                    })
                },

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