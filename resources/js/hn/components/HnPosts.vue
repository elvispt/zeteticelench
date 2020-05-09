<template>
  <ul id="hn-posts" class="list-group" v-loading="loading">
    <li v-for="post in posts"
        v-bind:key="post.id"
        class="list-group-item list-group-item-action flex-column align-items-start"
    >
      <div class="d-flex w-100 justify-content-between">
        <span>
          <a href="#"
             class="text-body"
          >{{ post.title }}</a>
          <a v-if="post.url" :href="post.url" class="text-body"
          target="_blank"
          >
            <small class="text-muted">({{ post.url | domainFromUrl }})</small>
          </a>
        </span>
        <span class="d-block d-md-none">
          <a href="#"
             class="bookmark-story"
          >{{ post.bookmarked ? "⚫" : "⚪️"}}️</a>
        </span>
        <span class="badge d-none d-md-block">{{ post.time | diffForHumans }}</span>
      </div>
      <div class="d-none d-md-block">
        <small class="text-muted">{{ post.score }} points</small>
        |
        <small>{{ post.descendants }} comments</small>
        |
        <a href="#"
           :data-story-id="post.id"
           :data-bookmarked="post.bookmarked ? 'true' : 'false'"
           class="bookmark-story"
        >{{ post.bookmarked ? "⚫" : "⚪️" }}</a>
      </div>
    </li>
  </ul>
</template>

<script>
import {HnDB} from "../HnDB";
import _get from "lodash.get";
import moment from "moment";

export default {
  name: "HNPosts",

  props: {
    idList: { type: Array, default: [], required: true },
  },

  data() {
    return {
      loading: true,
      posts: [],
    };
  },

  methods: {
    fetchItems (idList) {
      Promise.all(idList.map(id => this.fetchItem(id)))
        .then(stories => {
          this.posts = stories;
          this.loading = false;

          // do request here to backend to findout which stories are bookmarked
          // this.idList
        })
    },

    fetchItem (id) {
      return new Promise((resolve, reject) => {
        HnDB
          .child(`item/${id}`)
          .on('value', snapshot => {
            const postData = snapshot.val();

            const item = {
              id: _get(postData, 'id'),
              title: _get(postData, 'title'),
              score: _get(postData, 'score'),
              time: moment
                .unix(_get(postData, 'time', 0))
                .format('YYYY-MM-DD HH:mm:ss'),
              url: _get(postData, 'url'),
              type: _get(postData, 'type'),
              descendants: _get(postData, 'descendants'),
              bookmarked: false,
            };
            resolve(item);
          });
        HnDB.onDisconnect(function (a, b) {
          console.log("disconnected", a, b);
        });
      });
    },
  },

  watch: {
    idList(newIdList, oldIdList) {
      this.loading = true;
      this.fetchItems(newIdList);
    },
  },
}
</script>

<style scoped>
  .bookmark-story {
    position: relative;
    top: 2px;
    text-decoration: none;
  }
</style>
