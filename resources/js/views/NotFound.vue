<template>
  <div id="NotFound" class="pt-4">
    <h1 class="text-center text-capitalize">404 - page not found</h1>
    <h5 class="text-center text-black-50 mt-4">{{ message }}</h5>
    <div class="px-5 pt-3 text-center">
      <router-link
        :to="dashboardRoute"
        class="btn btn-lg btn-link"
      >Home</router-link>
      <router-link
        v-for="link in linksTo"
        :key="link.route.name"
        :to="link.route"
        class="btn btn-lg btn-link"
      >{{ route.linkText }}</router-link>
    </div>
  </div>
</template>

<script>
import { DashboardRoute } from "../router";

export default {
  name: "NotFound",

  props: {
    message: {
      type: String,
      required: false,
      default: 'We could not find what you where looking for!'
    },
    linksTo: {
      type: Array,
      required: false,
    },
  },

  data() {
    return {
      dashboardRoute: DashboardRoute,
    };
  },
}
</script>
