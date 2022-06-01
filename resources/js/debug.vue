<div class="relative flex
   flex-col items-center min-w-0 text-center pt-32 break-words min-h-screen w-full mb-6 shadow-lg rounded-lg bg-blueGray-100 border-0" v-else>
  <div class="sm:flex justify-center text-3xl font-bold">
    You don't own a restaurant...
    <i class="fa-solid fa-triangle-exclamation ml-4 mr-2"></i>
  </div>
  <div class="flex justify-center mt-12">
    <Link :href="route('restorant.create')" as="button" class="px-4 py-2 rounded shadow bg-gray-50 active:bg-gray-300 hover:text-white hover:bg-gray-800 transition duration-200">
      Register your restaurant
    </Link>
  </div>
</div>
