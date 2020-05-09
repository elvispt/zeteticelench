<template>
  <div id="hacker-news-top">
    <navigation></navigation>
    <div class="row">
      <div class="col-12 no-gutter-xs">
        <hn-posts
          :id-list="idList"
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

export default {
  name: "HackerNews",

  components: {
    Navigation,
    HnPosts,
  },

  data() {
    return {
      idList: [],
      limit: 20,
      routesMap: {
        HackerNewsTop: 'top',
        HackerNewsBest: 'best',
      },
    };
  },

  methods: {
    fetchStories(routeName) {
      const type = _get(this.routesMap, routeName, 'top');
      this.fetchIds(type);
    },
    fetchIds(type) {
      HnDB
        .child(`${type}stories`)
        .limitToFirst(this.limit)
        .on('value', snapshot => {
          this.idList = snapshot.val();
        });
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
