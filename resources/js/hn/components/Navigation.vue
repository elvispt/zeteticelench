<template>
  <div id="navigation">
    <div class="row justify-content-center top-submenu">
      <div class="col-12 no-gutter-xs">
        <div class="btn-group d-flex mb-2">
          <router-link
            :to="hackerNewsTopPostsRoute"
            class="btn btn-group-sm w-100 btn-secondary"
          >{{ $I18n.trans('hackernews.top') }}</router-link>
          <router-link
            :to="hackerNewsBestPostsRoute"
            class="btn btn-group-sm w-100 btn-secondary"
          >{{ $I18n.trans('hackernews.best') }}</router-link>
          <router-link
            :to="hackerNewsBookmarkedPostsRoute"
            class="btn btn-group-sm w-100 btn-secondary"
          >{{ $I18n.trans('hackernews.bookmarks') }} <span class="badge badge-light">{{ numberOfBookmarks }}</span></router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {
  HackerNewsTopPostsRoute,
  HackerNewsBestPostsRoute,
  HackerNewsBookmarkedPostsRoute,
} from "../../router";

export default {
  name: "Navigation",

  props: {
    numberOfBookmarks: { type: Number|null, required: true },
  },

  data() {
    return {
      hackerNewsTopPostsRoute: HackerNewsTopPostsRoute,
      hackerNewsBestPostsRoute: HackerNewsBestPostsRoute,
      hackerNewsBookmarkedPostsRoute: HackerNewsBookmarkedPostsRoute,
    };
  },
}
</script>

<style scoped>
  .router-link-exact-active {
    color: #fff;
    background-color: #3490dc;
    border-color: #3490dc;
  }
  .router-link-exact-active:focus, .router-link-exact-active:hover {
    color: #fff;
    background-color: #227dc7;
    border-color: #2176bd;
  }
</style>
