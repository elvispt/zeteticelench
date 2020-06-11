<template>
  <div id="navigation">
    <div class="row justify-content-center top-submenu">
      <div class="col-12 no-gutter-xs">
        <div class="btn-group d-flex mb-2">
          <router-link
            :to="hackerNewsRouteTop"
            class="btn btn-group-sm w-100"
            v-bind:class="activeSubmenu('top')"
          >{{ $I18n.trans('hackernews.top') }}</router-link>
          <router-link
            :to="hackerNewsRouteBest"
            class="btn btn-group-sm w-100"
            v-bind:class="activeSubmenu('best')"
          >{{ $I18n.trans('hackernews.best') }}</router-link>
          <router-link
            :to="hackerNewsRouteBookmarks"
            class="btn btn-group-sm w-100"
            v-bind:class="activeSubmenu('bookmarks')"
          >{{ $I18n.trans('hackernews.bookmarks') }} <span class="badge badge-light">{{ numberOfBookmarks }}</span></router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {HackerNewsRoute} from "../../router";

export default {
  name: "Navigation",

  props: {
    numberOfBookmarks: { type: Number|null, required: true },
  },

  data() {
    return {
      hackerNewsRouteTop: Object.assign({}, HackerNewsRoute, { params: { type: 'top' }}),
      hackerNewsRouteBest: Object.assign({}, HackerNewsRoute, { params: { type: 'best' }}),
      hackerNewsRouteBookmarks: Object.assign({}, HackerNewsRoute, { params: { type: 'bookmarks' }}),
    };
  },

  methods: {
    activeSubmenu(typeParam) {
      return this.$route.params.type === typeParam ? 'btn-primary' : 'btn-secondary';
    },
  },
}
</script>
