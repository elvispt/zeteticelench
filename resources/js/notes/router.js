import Vue from 'vue';
import Router from 'vue-router';
import Notes from "../views/Notes.vue";

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Notes',
      component: Notes,
    }
  ],
});
