import axios from "axios";
import _get from "lodash.get";

export const bookmarkPost = {
  data() {
    return {
      nBookmarks: null,
      notification: null,
    };
  },

  methods: {
    async bookmarkPost(post) {
      post.status.saving = true;
      const requestData = { 'postId': post.id };
      const addBookmark = !post.status.bookmarked;
      if (!addBookmark) {
        requestData._method = 'delete';
      }
      const response = await axios.post('/api/bookmarks', requestData);

      const success = _get(response, 'data.data.success', false);
      if (success) {
        post.status.bookmarked = !post.status.bookmarked;
        this.nBookmarks += addBookmark ? 1 : -1;
      }
      this.notifyUserOfBookmarkStatusChange(success, addBookmark, post);
    },
    notifyUserOfBookmarkStatusChange(success, addedBookmark, post) {
      let notificationOptions = {
        message: this.$I18n.trans('hackernews.add_failure'),
        type: 'error',
      };
      if (success) {
        if (addedBookmark) {
          notificationOptions = {
            message: this.$I18n.trans('hackernews.added_to_bookmarks', { title: post.title }),
            type: 'success',
          };
        } else {
          notificationOptions = {
            message: this.$I18n.trans('hackernews.remove_from_bookmarks', { title: post.title }),
            type: 'warning',
          };
        }
      }

      if (this.notification && !this.notification.closed) {
        this.notification.close();
      }
      this.notification = this.$notify(notificationOptions);
      setTimeout(() => post.status.saving = false, 400);
    },
  },
};
