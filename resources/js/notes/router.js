import Vue from 'vue';
import Router from 'vue-router';
import Notes from "../views/Notes";
import Note from "../views/Note"
import NoteCreate from "../views/NoteCreate";

Vue.use(Router);

export default new Router({
  routes: [
    {
      path: '/',
      name: 'Notes',
      component: Notes,
    },
    {
      path: '/new',
      name: 'NoteCreate',
      component: NoteCreate,
    },
    {
      path: '/:id',
      name: 'Note',
      component: Note,
      props: true,
    },
  ],
});
