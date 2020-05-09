import Vue from 'vue';
import Router from 'vue-router';
import HackerNews from "./views/HackerNews";

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
      path: '/saved',
      name: 'HackerNewsBookmarks',
      component: HackerNews,
    },
  ],
});
