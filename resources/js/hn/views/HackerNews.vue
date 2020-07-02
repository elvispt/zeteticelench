<template>
  <div id="hacker-news">
    <navigation
      :number-of-bookmarks="numberOfBookmarks"
    ></navigation>
    <router-view @nBookmarksChangedEvent="updateNumberOfBookmarks"></router-view>
  </div>
</template>

<script>
import Navigation from "../components/Navigation";

export default {
  name: "HackerNews",

  components: {
    Navigation,
  },

  data() {
    return {
      numberOfBookmarks: null,
    };
  },

  methods: {
    updateNumberOfBookmarks(value) {
      this.numberOfBookmarks = value;
    },
  },
}
</script>
