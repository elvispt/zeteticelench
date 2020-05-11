import Vue from 'vue';
import Router from 'vue-router';
import HackerNews from "./views/HackerNews";
import HackerNewsPost from "./views/HackerNewsPost";

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: 'HackerNewsTop',
      component: HackerNews,
    },
    {
      path: '/best',
      name: 'HackerNewsBest',
      component: HackerNews,
    },
    {
      path: '/bookmark',
      name: 'HackerNewsBookmarks',
      component: HackerNews,
    },
    {
      path: '/post/:id',
      name: 'HackerNewsPost',
      component: HackerNewsPost,
      props: true,
    }
  ],
});
