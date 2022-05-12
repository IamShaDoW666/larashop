<template>
  <Admin :headerStats="true">
    <Head title="Restaurant" />
    <div class="w-full px-4">
      <Restorant :restorant="restorant" />
    </div>
  </Admin>
</template>

<script>
import Restorant from "@/Components/Restorant/Index.vue";
import CardProfile from "@/Components/Cards/CardProfile.vue";
import Admin from "@/Layouts/Admin.vue";
import { Head, Link} from '@inertiajs/inertia-vue3';
export default {
  components: {
    Restorant,
    Head,
    Link,
    CardProfile,
    Admin,
  },

  props: {
    restorant: Object
  }

};
</script>
