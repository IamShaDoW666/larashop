<template>

  <Head title="Debug" />
  <BreezeAuthenticatedLayout>
    <template #header>
      <h2 class="font-semibold text-xl text-gray-800 leading-tight">
        Debug
      </h2>
    </template>
    <div class="py-12">
      <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <div class="bg-white overflow-visible shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <div class="flex flex-col gap-x-4">
              <div class="flex px-3 mb-4 justify-between">
                <h1>Day</h1>
                <h1>Opening Time</h1>
                <h1>Closing Time</h1>
              </div>
              <form @submit.prevent="submit">
                <div class="flex mb-3 justify-between">
                  <div class="px-3 flex justify-between">
                    <span>Monday: </span>
                    <input type="checkbox" name="monday" id="monday">
                  </div>
                  <div class="px-3">
                    <input type="time" name="m_from" v-model="form.m_from">
                  </div>
                  <div class="px-3">
                    <input type="time" name="m_to" v-model="form.m_to">
                  </div>
                </div>
                <div class="flex mb-3 justify-between gap-x-2">
                  <div class="px-3">
                    <span>Tuesday: </span>
                    <input type="checkbox" name="tuesday" id="tuesday">
                  </div>
                  <div class="px-3">
                    <input type="time" name="t_from" v-model="form.t_from">
                  </div>
                  <div class="px-3">
                    <input type="time" name="t_to" v-model="form.t_to">
                  </div>
                </div>
                <div class="flex mb-3 justify-between gap-x-2">
                  <div class="px-3">
                    <span>Wednesday: </span>
                    <input type="checkbox" name="wednesday" id="monday">
                  </div>
                  <div class="px-3">
                    <input type="time" name="w_from" v-model="form.w_from">
                  </div>
                  <div class="px-3">
                    <input type="time" name="w_to" v-model="form.w_to">
                  </div>
                </div>
                <div class="flex mb-3 justify-between gap-x-2">
                  <div class="px-3">
                    <span>Thursday: </span>
                    <input type="checkbox" name="thursday" id="thursday">
                  </div>
                  <div class="px-3">
                    <input type="time" name="th_from" v-model="form.th_from">
                  </div>
                  <div class="px-3">
                    <input type="time" name="th_to" v-model="form.th_to">
                  </div>
                </div>
                <div class="flex mb-3 justify-between gap-x-2">
                  <div class="px-3">
                    <span>Friday: </span>
                    <input type="checkbox" name="friday" id="friday">
                  </div>
                  <div class="px-3">
                    <input type="time" name="f_from" v-model="form.f_from">
                  </div>
                  <div class="px-3">
                    <input type="time" name="f_to" v-model="form.f_to">
                  </div>
                </div>
                <div class="flex mb-3 justify-between gap-x-2">
                  <div class="px-3">
                    <span>Saturday: </span>
                    <input type="checkbox" name="saturday" id="saturday">
                  </div>
                  <div class="px-3">
                    <input type="time" name="s_from" v-model="form.s_from">
                  </div>
                  <div class="px-3">
                    <input type="time" name="s_to" v-model="form.s_to">
                  </div>
                </div>
                <div class="flex mb-3 justify-between gap-x-2">
                  <div class="px-3">
                    <span>Sunday: </span>
                    <input type="checkbox" name="sunday" id="sunday">
                  </div>
                  <div class="px-3">
                    <input type="time" name="su_from" v-model="form.su_from">
                  </div>
                  <div class="px-3">
                    <input type="time" name="su_to" v-model="form.su_to">
                  </div>
                </div>
                <button type="submit" class="btn">Submit</button>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script setup>
import { Head, useForm, usePage } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import VueTimepicker from 'vue3-timepicker/src/VueTimepicker.vue'
import { onMounted, ref } from 'vue';
import axios from 'axios';
const hours = ref({});
onMounted(async () => {
  let response = await axios.get('/api/hours')
  hours.value = response.data
})

// const form = useForm({
//   m_from: '',
//   m_to: '',
//   t_from: '',
//   t_to: '',
//   w_from: '',
//   w_to: '',
//   th_from: '',
//   th_to: '',
//   f_from: '',
//   f_to: '',
//   s_from: '',
//   s_to: '',
//   su_from: '',
//   su_to: '',
// })

const form = useForm({
  m_from: hours.value.m_from,
  m_to: hours.value.m_to,
  t_from: hours.value.t_from,
  t_to: hours.value.t_to,
  w_from: hours.value.w_from,
  w_to: hours.value.w_to,
  th_from: hours.value.th_from,
  th_to: hours.value.th_to,
  f_from: hours.value.f_from,
  f_to: hours.value.f_to,
  s_from: hours.value.s_from,
  s_to: hours.value.s_to,
  su_from: hours.value.su_from,
  su_to: hours.value.su_to,
})

const submit = async () => {
  form.transform((data) => ({
    ...data,

  })).post(route('debug.post', {restorant: 1}))
}

</script>