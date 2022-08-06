<template>
  <section id="hero"
    className="min-h-screen py-20 bg-center flex items-center dark:bg-secondary-dark bg-secondary-dark bg-no-repeat bg-cover lg:py-0 justify-center">
    <div className="max-w-3xl mx-auto" :class="currentTheme">
      <div className="text-center border-2">
        <div className="p-10 m-3 bg-white dark:bg-secondary-dark bg-opacity-90 ">
          <h1 className="uppercase text-brand text-emerald-500 dark:text-white text-2xl font-bold">
            Live order status
          </h1>
          <div class="mt-4 flex justify-between dark:text-white">
            <div>
              <span class="text-sm">Status: </span>
              <OrderStatusBadge :status="order.status" />
            </div>
            <div>
              <span class="text-sm">Order Type: </span>
              <OrderTypeBadge :type="order.order_type" />
            </div>
          </div>
          <p
            className="text-green background-brand text-2xl dark:text-white inline-block py-2.5 px-4 mt-4 mb-6 pricing-before">
            Amount to Pay: {{ order.total }}
          </p>
          <p class="text-black dark:text-golden-yellow">
            {{ order.status_text }}
          </p>
          <p className="pb-3 mt-8 mb-5 text-xl leading-8 text-center dark:text-white sub-title">
            Client Name: {{ order.customer_name }}
          </p>
          <p v-if="order.address" className="flex items-center justify-center gap-2 mb-4 dark:text-white">
            <BsEnvelope /> Address: {{ order.address }}
          </p>
          <p className="flex items-center justify-center gap-2 dark:text-white">
            <FaPhoneAlt />Phone Number: {{ order.customer_phone }}
          </p>
          <ul v-if="order.status != 'rejected'" class="steps my-4 w-full dark:text-white">
            <li :class="{
              'step-secondary':
                order.status == 'pending' ||
                order.status == 'accepted' ||
                order.status == 'prepared' ||
                order.status == 'delivered' ||
                order.status == 'closed',
            }" class="step">
              Pending
            </li>
            <li :class="{
              'step-secondary':
                order.status == 'accepted' ||
                order.status == 'prepared' ||
                order.status == 'delivered' ||
                order.status == 'closed',
            }" class="step">
              Accepted
            </li>
            <li :class="{
              'step-secondary':
                order.status == 'prepared' ||
                order.status == 'delivered' ||
                order.status == 'closed',
            }" class="step">
              Prepared
            </li>
            <li :class="{
              'step-secondary':
                order.status == 'delivered' || order.status == 'closed',
            }" class="step">
              Delivered
            </li>
          </ul>
        </div>
      </div>
    </div>
  </section>
</template>

<script setup>
import OrderStatusBadge from "@/Components/Badges/OrderStatusBadge.vue";
import OrderTypeBadge from "@/Components/Badges/OrderTypeBadge.vue";
import { useThemeSwitcher } from "@/Composables/useThemeSwitcher";
import { Inertia } from "@inertiajs/inertia";
import { usePage } from "@inertiajs/inertia-vue3";
import Echo from 'laravel-echo';
import Swal from "sweetalert2";
import { onMounted } from 'vue'



const Pusher = require('pusher-js');

let echo = new Echo({
  broadcaster: 'pusher',
  key: process.env.MIX_PUSHER_APP_KEY,
  cluster: process.env.MIX_PUSHER_APP_CLUSTER,
  forceTLS: true
});

// let audio = new Audio('https://soundbible.com/mp3/Phone%20Ringing-SoundBible.com-1579776269.mp3');
onMounted(() => {  
  echo.channel('order.' + props.restorant_id)
    .listen('UpdateOrder', (e) => {
      // audio.play();
      if (usePage().component.value == 'Order/Status') {
        Inertia.reload();
      }
      const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        // iconColor: 'white',
        // customClass: {
        //   popup: 'colored-toast'
        // },
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
          toast.addEventListener('mouseenter', Swal.stopTimer)
          toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
      })

      //Mutate Response
      // switch (e.order.order_type) {
      //   case 1:
      //     response.order_type = 'Delivery';
      //     break;
      //   case 2:
      //     response.order_type = 'Pickup';
      //     break;
      //   case 3:
      //     response.order_type = 'Dine-in';
      //     break;
      //   default:
      //     response.order_type = null
      // }

      Toast.fire({
        icon: 'success',
        title: 'Order updated!',
      })
    })
});
const { currentTheme } = useThemeSwitcher();
const props = defineProps({
  order: Object,
  restorant_id: Number
});

switch (props.order.status) {
  case "pending":
}
</script>