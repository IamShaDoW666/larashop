<template>

  <Head title="Dashboard" />

  <div class="py-12">
    <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
      <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
        <button @click="sendMsg" class="butn ml-8 hover:scale-110 transition-all duration-200">Click</button>
      </div>
    </div>
  </div>
</template>

<script setup>
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { reactive, onMounted } from 'vue';
import { Head } from '@inertiajs/inertia-vue3';
let msg = { "messaging_product": "whatsapp", "to": "917902708908", "type": "template", "template": { "name": "hello_universe", "language": { "code": "en_US" } } }

const sendMsg = () => {
  axios.post('https://graph.facebook.com/v13.0/105742368896999/messages', {
    headers: {
      'Authorization': `Bearer EAAQDkBsO7QsBAOW5ZBHv0myOrRsy6ujVLWAF0CezZCZBqsEWsZB9JMRt3d4HvIZCEL4AZAcndUQOrAtHo9hwHDZCA78NEgawe7FMrJWjefrfJHqvy2GDmjLsvD5pRITBZB8WI36Sw1PRspnAU1LHyZA63o14N4jRlMbpI9M9cMpWjYey9KlZBGNRONZCRLWEFRE7JplCQfrRfdmRAZDZD`,
      'Content-Type': 'application/json'
    },
    "messaging_product": "whatsapp",
    "to": "917902708908",
    "type": "template",
    "template": {
      "name": "hello_universe",
      "language": {
        "code": "en"
      }
    }
  }).then((res) => console.log(res)).catch((err) => console.log(err))
}


</script>

<style scoped>
.loader {
  border: 16px solid #f3f3f3;
  /* Light grey */
  border-top: 16px solid #3498db;
  /* Blue */
  border-radius: 50%;
  width: 120px;
  height: 120px;
  animation: spin 2s linear infinite;
}

@keyframes spin {
  0% {
    transform: rotate(0deg);
  }

  100% {
    transform: rotate(360deg);
  }
}
</style>
