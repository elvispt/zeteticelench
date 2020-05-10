<template>
  <div id="hacker-news-post">
    <navigation></navigation>
    <div class="row">
      <div class="col-12 no-gutter-xs">

      </div>
    </div>
  </div>
</template>

<script>
import Navigation from "../components/Navigation";
import HnDb from "../HnDB";
import _get from "lodash.get";
import moment from "moment";

export default {
  name: "HackerNewsPost",

  components: {
    Navigation,
  },

  props: {
    id: { type: Number, required: true },
  },

  data() {
    return {
      post: {
        id: null,
        title: null,
        score: null,
        time: null,
        url: null,
        type: null,
        nComments: null,
        bookmarked: null,
        // array of first level comment ids
        kids: [],
        // array of objects with each item with structure equal to parent
        comments: [],
      },
    }
  },

  methods: {

  },

  created() {

  },
}
</script>

<style scoped>

</style>
