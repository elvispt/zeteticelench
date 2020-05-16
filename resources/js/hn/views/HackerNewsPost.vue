<template>
  <div id="hacker-news-post">
    <navigation
      :number-of-bookmarks="numberOfBookmarks"
    ></navigation>
    <div class="row">
      <div class="col-12 no-gutter-xs" v-loading="loading">
        <p class="lead loader-text loader-text-top d-block w-100" v-if="loading">&nbsp;</p>
        <p class="lead" v-if="post.title">
          {{ post.title }}
          <a
            v-if="post.url"
            :href="post.url"
            class="text-body"
            target="_blank"
          >
            <small class="text-muted">({{ post.url | domainFromUrl }}) [↗]</small>
          </a>
        </p>
        <p v-if="post.text" v-html="post.text"></p>

        <div class="loader-text loader-text-top d-block w-100" v-if="loading">&nbsp;</div>
        <div v-if="post.title" v-loading="post.status.saving">
          <small class="text-muted">{{ post.score }} points</small>
          <span class="text-muted">|</span>
          <small class="text-muted">{{ post.nComments }} comments</small>
          <span class="text-muted">|</span>
          <small class="text-muted">{{ post.time | diffForHumans }}</small>
          <span class="text-muted">|</span>
          <small class="text-muted">by {{ post.by }}</small>
          <span class="text-muted">|</span>
          <span class="bookmark-story pointer text-primary"
                @click="bookmarkPost(post)"
          >{{ post.status.bookmarked ? "⚫" : "⚪️"}}️</span>
        </div>
      </div>
    </div>
    <div class="row" v-if="post.comments.length">
      <div class="col-12 no-gutter-xs" v-loading="loadingComments">
        <hn-comment
          v-for="com in post.comments"
          v-bind:key="com.id"
          :comment="com"
          :handle-collapse-toggle="handleCollapseToggle"
        ></hn-comment>
      </div>
    </div>
  </div>
</template>

<script>
import Navigation from "../components/Navigation";
import HnComment from "../components/HnComment";
import {bookmarPost} from "../mixins/bookmarkPost";
import {HnDB} from "../service/HnDB";
import _get from "lodash.get";
import moment from "moment";
import axios from "axios";
import * as Sentry from '@sentry/browser';

export default {
  name: "HackerNewsPost",

  mixins: [bookmarPost],

  components: {
    Navigation,
    HnComment,
  },

  props: {
    id: { type: String, required: true },
  },

  data() {
    return {
      loading: true,
      loadingComments: true,
      collapsedCommentsKey: 'collapsedCommentsHackerNewsPost',
      collapsedComments: [],
      post: {
        id: null,
        by: null,
        title: null,
        text: null,
        score: null,
        time: null,
        url: null,
        type: null,
        nComments: null,
        status: {
          bookmarked: null,
          saving: null,
        },
        // array of first level comment ids
        kids: [],
        // array of objects with each item with structure equal to parent
        comments: [
          {
            id: null,
            by: null,
            kids: [],
            parent: null,
            text: null,
            time: null,
            comments: [],
          }
        ],
      },
      numberOfBookmarks: null,
    }
  },

  methods: {
    fetchPost(id) {
      if (!id) {
        return;
      }
      this.fetchCollapsedComments();
      HnDB
        .child(`item/${id}`)
        .once('value', snapshot => {
          const postData = snapshot.val();

          this.post.id = _get(postData, 'id');
          this.post.by = _get(postData, 'by');
          this.post.title = _get(postData, 'title');
          this.post.text = _get(postData, 'text');
          this.post.score = _get(postData, 'score');
          this.post.time = moment
            .unix(_get(postData, 'time', 0))
            .format('YYYY-MM-DD HH:mm:ss')
          ;
          this.post.url = _get(postData, 'url');
          this.post.type = _get(postData, 'type');
          this.post.nComments = _get(postData, 'descendants');
          this.post.bookmarked = null;
          this.post.kids = _get(postData, 'kids', []);
          this.post.comments = [];
          this.setBookmarkStatus(this.post);
          this.fetchComments(this.post);
          this.loading = false;
        });
    },

    fetchComments(parent) {
      if (parent.kids.length) {
        parent.kids.map(id => {
          this.fetchComment(id).then(commentData => {
            const kids = _get(commentData, 'kids', []);
            const id = _get(commentData, 'id');
            const comment = {
              id,
              deleted: _get(commentData, 'deleted'),
              by: _get(commentData, 'by'),
              kids: kids,
              text: _get(commentData, 'text'),
              time: moment
                .unix(_get(commentData, 'time', 0))
                .format('YYYY-MM-DD HH:mm:ss'),
              comments: [],
              collapsed: this.collapsedComments.includes(id),
            };
            this.fetchComments(comment);
            parent.comments.push(comment);
            this.loadingComments = false;
          });
        });
      }
    },

    fetchComment(id) {
      return new Promise((resolve, reject) => {
        HnDB
          .child(`item/${id}`)
          .once('value', snapshot => {
            const commentData = snapshot.val();
            resolve(commentData);
          });
      });
    },

    async setBookmarkStatus(post) {
      const response = await axios.get("/api/bookmarks");
      const ids = _get(response, 'data.data', []);
      this.numberOfBookmarks = ids.length;
      post.status.bookmarked = ids.includes(post.id);
    },

    /**
     * Fetches the list of item ids that are collapsed from localStorage
     */
    fetchCollapsedComments() {
      const json = localStorage.getItem(this.collapsedCommentsKey);
      let commentIds;
      try {
        commentIds = JSON.parse(json);
      } catch (e) {
        Sentry.captureMessage(e);
      }
      commentIds = Array.isArray(commentIds) ? commentIds : [];
      this.collapsedComments = commentIds;
    },

    /**
     * Stores list of item ids of collapsed element to localStorage
     */
    setCollapsedComments() {
      const json = JSON.stringify(this.collapsedComments);
      localStorage.setItem(this.collapsedCommentsKey, json);
    },

    /**
     * Toggles the collapse property of the comment and
     * adds/removes from list of collapsedComments
     *
     * @param comment The comment item object
     */
    handleCollapseToggle(comment) {
      comment.collapsed = !comment.collapsed;
      if (comment.collapsed) {
        // add to collapsed comments list
        this.collapsedComments.push(comment.id);
      } else {
        // remove from collapsed comments list
        this.collapsedComments = this.collapsedComments.filter(id => id !== comment.id);
      }
      this.setCollapsedComments();
    }
  },

  created() {
    this.fetchPost(this.id);
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
</style>
