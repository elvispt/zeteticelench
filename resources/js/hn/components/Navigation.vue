<template>
  <div id="navigation">
    <div class="row justify-content-center top-submenu">
      <div class="col-12 no-gutter-xs">
        <div class="btn-group d-flex mb-2">
          <router-link
            to="/"
            class="btn btn-group-sm w-100"
            v-bind:class="activeSubmenu('HackerNewsTop')"
          >Top</router-link>
          <router-link
            to="/best"
            class="btn btn-group-sm w-100"
            v-bind:class="activeSubmenu('HackerNewsBest')"
          >Best</router-link>
          <router-link
            to="/saved"
            class="btn btn-group-sm w-100"
            v-bind:class="activeSubmenu('HackerNewsSaved')"
          >Saved</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Navigation",

  methods: {
    activeSubmenu(routeName) {
      return this.$route.name === routeName ? 'btn-primary' : 'btn-secondary';
    },
  },
}
</script>
