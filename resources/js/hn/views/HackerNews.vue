<template>
  <div id="hacker-news">
    <navigation
      :number-of-bookmarks="numberOfBookmarks"
    ></navigation>
    <div class="row">
      <div class="col-12 no-gutter-xs">
        <hn-posts
          :id-list="idList"
          @nBookmarksChangedEvent="updateNumberOfBookmarks"
        ></hn-posts>
      </div>
    </div>
  </div>
</template>

<script>
import Navigation from "../components/Navigation";
import HnPosts from "../components/HnPosts";
import {HnDB} from "../HnDB";
import _get from "lodash.get";
import axios from "axios";

export default {
  name: "HackerNews",

  components: {
    Navigation,
    HnPosts,
  },

  data() {
    return {
      idList: [],
      limit: 100,
      routesMap: {
        HackerNewsTop: 'top',
        HackerNewsBest: 'best',
        HackerNewsBookmarks: 'bookmarks',
      },
      numberOfBookmarks: null,
    };
  },

  methods: {
    fetchStories(routeName) {
      const type = _get(this.routesMap, routeName, 'top');
      if (type === this.routesMap.HackerNewsBookmarks) {
        this.fetchIdsBookmarkedFromBackend();
      } else {
        this.fetchIdsFromFirebase(type);
      }
    },
    fetchIdsFromFirebase(type) {
      HnDB
        .child(`${type}stories`)
        .limitToFirst(this.limit)
        .on('value', snapshot => {
          const val = snapshot.val();
          this.idList = Array.isArray(val) ? val : [];
        });
    },
    async fetchIdsBookmarkedFromBackend() {
      const response = await axios.get("/api/bookmarks");
      this.idList = _get(response, 'data.data', []);
    },
    updateNumberOfBookmarks(value) {
      this.numberOfBookmarks = value;
    },
  },

  created() {
    this.fetchStories(this.$route.name);
  },

  watch: {
    $route(to, from) {
      this.fetchStories(to.name);
    },
  }
}
</script>
