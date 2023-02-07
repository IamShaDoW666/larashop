<template>
  <Admin :headerStats="true">
    <Head title="Dashboard" />
  </Admin>
</template>
<script>

import { Head, Link} from '@inertiajs/inertia-vue3';
import Admin from "@/Layouts/Admin.vue";

export default {
  name: "dashboard-page",
  components: {
    Head,
    Link,
    Admin,
  },
};
</script>
