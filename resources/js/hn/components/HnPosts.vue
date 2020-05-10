<template>
  <ul id="hn-posts" class="list-group" v-loading="loading">
    <li v-if="loading" class="list-group-item list-group-item-action flex-column align-items-start" v-for="dummy in Array(10).fill(null)">
      <div class="d-flex w-100 justify-content-between">
        <span class="loader-text loader-text-top d-block w-100">&nbsp;</span>
      </div>
      <div class="d-none d-md-block">
        <span class="loader-text loader-text-bottom loader-text--1x3 d-inline-block">
          <small>&nbsp;</small>
        </span>
      </div>
    </li>
    <transition-group name="slide-fade" mode="out-in">
    <li v-for="(post, index) in posts"
        v-bind:key="post.id"
        class="list-group-item list-group-item-action flex-column align-items-start"
        :data-index="index + 1"
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
    </transition-group>
  </ul>
</template>

<script>
import {HnDB} from "../HnDB";
import _get from "lodash.get";
import moment from "moment";
import axios from "axios";

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
          this.attachBookmarked();
          this.loading = false;
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
      this.posts = this.posts.map(post => {
        post.bookmarked = ids.includes(post.id);
        return post;
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
  .loader-text {
    background: #808080;
    border-radius: 2px;
  }
  .loader-text--1x3 {
    width: 33%;
  }
  .loader-text--1x2 {
    width: 50%;
  }
  .loader-text-top {
    height: 22px;
    margin-bottom: 6px;
  }
  .loader-text-bottom {
    height: 18px;
  }

  .slide-fade-enter-active {
    transition: all .3s ease;
  }
  .slide-fade-leave-active {
    transition: all .5s cubic-bezier(1.0, 0.5, 0.8, 1.0);
  }
  .slide-fade-enter, .slide-fade-leave-to {
    background-color: #ffef0029;
  }
</style>
