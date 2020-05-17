<template>
  <div id="navigation">
    <div class="row justify-content-center top-submenu">
      <div class="col-12 no-gutter-xs">
        <div class="btn-group d-flex mb-2">
          <router-link
            to="/"
            class="btn btn-group-sm w-100"
            v-bind:class="activeSubmenu('HackerNewsTop')"
          >{{ $I18n.trans('hackernews.top') }}</router-link>
          <router-link
            to="/best"
            class="btn btn-group-sm w-100"
            v-bind:class="activeSubmenu('HackerNewsBest')"
          >{{ $I18n.trans('hackernews.best') }}</router-link>
          <router-link
            to="/bookmark"
            class="btn btn-group-sm w-100"
            v-bind:class="activeSubmenu('HackerNewsBookmarks')"
          >{{ $I18n.trans('hackernews.bookmarks') }} <span class="badge badge-light">{{ numberOfBookmarks }}</span></router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
export default {
  name: "Navigation",

  props: {
    numberOfBookmarks: { type: Number|null, required: true },
  },

  methods: {
    activeSubmenu(routeName) {
      return this.$route.name === routeName ? 'btn-primary' : 'btn-secondary';
    },
  },
}
</script>
