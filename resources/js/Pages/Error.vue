<template>
  <div class="relative flex items-top justify-center min-h-screen bg-gray-100 dark:bg-gray-900 sm:items-center sm:pt-0">
      <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
          <div class="flex items-center pt-8 sm:justify-start sm:pt-0">
              <div class="px-4 text-lg text-gray-500 border-r border-gray-400 tracking-wider">
                  {{ title }}
              </div>

              <div class="ml-4 text-lg text-gray-500 uppercase tracking-wider">
                  {{ message ? message : description }}
              </div>
          </div>
      </div>
  </div>
</template>

<script>
export default {
  props: {
    status: Number,
    message: String
  },
  computed: {
    title() {
      return {
        503: '503',
        500: '500',
        404: '404',
        403: '403',
      }[this.status]
    },
    description() {
      return {
        503: 'Service Unavailable',
        500: 'Internal Server Error',
        404: 'Page Not Found',
        403: 'Forbidden',
      }[this.status]
    },
  },
}
</script>
