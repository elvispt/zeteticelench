import Vue from 'vue';
import Router from 'vue-router';
import Notes from "../views/Notes";
import Note from "../views/Note"
import NoteCreate from "../views/NoteCreate";
import NoteUpdate from "../views/NoteUpdate";

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
      path: '/edit/:id',
      name: 'NoteUpdate',
      component: NoteUpdate,
      props: true,
    },
    {
      path: '/:id',
      name: 'Note',
      component: Note,
      props: true,
    },
  ],
});
