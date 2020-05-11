import axios from "axios";
import _get from "lodash.get";

export const bookmarPost = {
  data() {
    return {
      nBookmarks: null,
      notification: null,
    };
  },

  methods: {
    async bookmarkPost(post) {
      const requestData = { 'postId': post.id };
      const addBookmark = !post.bookmarked;
      if (!addBookmark) {
        requestData._method = 'delete';
      }
      const response = await axios.post('/api/bookmarks', requestData);

      const success = _get(response, 'data.data.success', false);
      if (success) {
        post.bookmarked = !post.bookmarked;
        this.nBookmarks += addBookmark ? 1 : -1;
      }
      this.notifyUserOfBookmarkStatusChange(success, addBookmark, post);
    },
    notifyUserOfBookmarkStatusChange(success, addedBookmark, post) {
      let messageOptions = {
        message: `'Something went wrong when calling bookmarks.'`,
        type: 'error',
      };
      if (success) {
        if (addedBookmark) {
          messageOptions = {
            message: `"${post.title}" added to bookmarks!`,
            type: 'success',
          };
        } else {
          messageOptions = {
            message: `"${post.title}" removed from bookmarks!`,
            type: 'warning',
          };
        }
      }
      if (this.notification && !this.notification.closed) {
        this.notification.close();
      }
      this.notification = this.$message(messageOptions);
    },
  },
};
