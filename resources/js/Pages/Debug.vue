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
        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
          <div class="p-6 bg-white border-b border-gray-200">
            <GooglePay />
          </div>
        </div>
      </div>
    </div>
  </BreezeAuthenticatedLayout>
</template>

<script>
import { Head, useForm, Link } from '@inertiajs/inertia-vue3';
import BreezeAuthenticatedLayout from '@/Layouts/Authenticated.vue';
import { GooglePlayButton } from 'vue-google-pay';
import GooglePay from '@/Components/GooglePay.vue';
export default {
  components: {
    Head,
    Link,
    BreezeAuthenticatedLayout,
    GooglePlayButton ,
    GooglePay
  },

  data() {
    return {
      environment: 'TEST',
      buttonColor: 'white',
      allowedCardNetworks: [
        'AMEX',
        'DISCOVER',
        'INTERAC',
        'JCB',
        'MASTERCARD',
        'VISA'
      ],
      allowedCardAuthMethods: ['PAN_ONLY', 'CRYPTOGRAM_3DS'],
      merchantInfo: {
        merchantName: 'Example Merchant',
        merchantId: '0123456789'
      },
      transactionInfo: {
        totalPriceStatus: 'FINAL',
        totalPrice: '1.00',
        currencyCode: 'USD',
        countryCode: 'US'
      },
      tokenizationSpecification: {
        type: 'PAYMENT_GATEWAY',
        parameters: {
          gateway: 'example',
          gatewayMerchantId: 'exampleGatewayMerchantId'
        }
      }
    }
  },
  methods: {
    payed(paymentData) {
      // process payment
    },
    cancelled() {
      // handle cancel event
    }
  }

}


</script>
