<template>
  <div id="hacker-news-list">
    <div class="row">
      <div class="col-12 no-gutter-xs">
        <hn-posts
          v-on="$listeners"
          :id-list="idList"
        ></hn-posts>
      </div>
    </div>
  </div>
</template>

<script>
import Navigation from "../components/Navigation";
import HnPosts from "../components/HnPosts";
import {HnDB} from "../service/HnDB";
import _get from "lodash.get";
import axios from "axios";

export default {
  name: "HackerNewsList",

  components: {
    Navigation,
    HnPosts,
  },

  props: {
    type: {
      type: String,
      validator: function (value) {
        return ['top', 'best', 'bookmarks'].indexOf(value) !== -1;
      },
      default: 'top',
      required: true,
    }
  },

  data() {
    return {
      idList: [],
      limit: 100,
      types: {
        HackerNewsBookmarks: 'bookmarks',
      },
      numberOfBookmarks: null,
    };
  },

  methods: {
    fetchStories() {
      if (this.type === this.types.HackerNewsBookmarks) {
        this.fetchIdsBookmarkedFromBackend();
      } else {
        this.fetchIdsFromFirebase(this.type);
      }
    },
    fetchIdsFromFirebase(type) {
      HnDB
        .child(`${type}stories`)
        .limitToFirst(this.limit)
        .once('value', (snapshot, b) => {
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
    this.fetchStories();
  },

  watch: {
    $route(to, from) {
      this.fetchStories();
    },
  }
}
</script>
