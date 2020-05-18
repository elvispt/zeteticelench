<template>
  <ul id="hn-posts" class="list-group" v-loading="loading">
    <li v-if="loading" class="list-group-item list-group-item-action flex-column align-items-start" v-for="dummy in Array(firstBatchPosition).fill(null)">
      <div class="d-flex w-100 justify-content-between">
        <span class="loader-text loader-text-top d-block w-100">&nbsp;</span>
      </div>
      <div class="d-none d-md-block">
        <span class="loader-text loader-text-bottom loader-text--1x3 d-inline-block">
          <small>&nbsp;</small>
        </span>
      </div>
    </li>

    <li v-for="(post, index) in posts"
        v-bind:key="post.id"
        class="list-group-item list-group-item-action flex-column align-items-start"
        :data-index="index + 1"
    >
      <div class="d-flex w-100 justify-content-between">
        <span>
          <router-link
            :to="`/post/${post.id}`"
            class="text-body"
          >{{ post.title }}</router-link>
          <a
            v-if="post.url"
            :href="post.url"
            class="text-body"
            target="_blank"
          >
            <small class="text-muted">({{ post.url | domainFromUrl }})</small>
          </a>
        </span>
        <span class="d-block d-md-none" v-loading="post.status.saving">
          <span class="bookmark-story pointer text-primary"
             @click="bookmarkPost(post)"
          >{{ post.status.bookmarked ? "⚫" : "⚪️"}}️</span>
        </span>
        <span class="badge d-none d-md-block" :title="post.time">{{ post.time | diffForHumans }}</span>
      </div>
      <div class="d-none d-md-block" v-loading="post.status.saving">
        <small class="text-muted">{{ $I18n.trans('hackernews.points', { points: post.score || '' }) }}</small>
        |
        <small>{{ $I18n.trans('hackernews.comments', { comments: post.nComments || '' }) }}</small>
        |
        <span class="bookmark-story pointer text-primary"
           @click="bookmarkPost(post)"
        >{{ post.status.bookmarked ? "⚫" : "⚪️" }}</span>
      </div>
    </li>

  </ul>
</template>

<script>
import { bookmarPost } from "../mixins/bookmarkPost";
import {HnDB} from "../service/HnDB";
import _get from "lodash.get";
import moment from "moment";
import axios from "axios";

export default {
  name: "HNPosts",

  mixins: [bookmarPost],

  props: {
    idList: { type: Array, default: [], required: true },
  },

  data() {
    return {
      loading: true,
      posts: [],
      nBookmarks: null,
      firstBatchPosition: 10,
    };
  },

  methods: {
    /**
     * Loads the items in two batches to show something to the user earlier
     * insted of waiting for the entire list to load.
     * @param idList
     */
    fetchItems(idList) {
      let firstBatchPosition = this.firstBatchPosition;
      if (idList.length < firstBatchPosition) {
        firstBatchPosition = Math.floor(idList.length / 2);
      }
      let firstBatch = idList.slice(0, firstBatchPosition);
      let secondBatch = idList.slice(firstBatchPosition);

      Promise.all(firstBatch.map(id => this.fetchItem(id)))
        .then(stories => {
          this.posts = stories;
          this.attachBookmarked();
          this.loading = false;
        });

      this.$nextTick(() => {
        Promise.all(secondBatch.map(id => this.fetchItem(id)))
          .then(stories => {
            this.posts.push(...stories);
            this.attachBookmarked();
          });
      });
    },

    fetchItem(id) {
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
              nComments: _get(postData, 'descendants'),
              kids: _get(postData, 'kids', []),
              status: {
                bookmarked: false,
                saving: false,
              },
            };
            resolve(item);
          });
        HnDB.onDisconnect(function (a, b) {
          this.$alert('Firebase connection lost', 'Lost connection', {
            confirmButtonText: 'OK',
          });
          console.log(a, b);
        });
      });
    },

    async attachBookmarked() {
      const response = await axios.get("/api/bookmarks");
      const ids = _get(response, 'data.data', []);
      this.nBookmarks = ids.length;
      this.posts = this.posts.map(post => {
        post.status.bookmarked = ids.includes(post.id);
        return post;
      });
    },
  },

  watch: {
    idList(newIdList, oldIdList) {
      this.loading = true;
      setTimeout(() => this.fetchItems(newIdList), 400);
    },
    nBookmarks(newValue, oldValue) {
      this.$emit("nBookmarksChangedEvent", newValue);
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
  .loader-text {
    background: #808080;
    border-radius: 2px;
  }
  .loader-text--1x3 {
    width: 33%;
  }
  .loader-text-top {
    height: 22px;
    margin-bottom: 6px;
  }
  .loader-text-bottom {
    height: 18px;
  }
</style>
