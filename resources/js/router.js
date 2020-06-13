import Vue from 'vue';
import Router from 'vue-router';
import Dashboard from "./dashboard/views/Dashboard";
import Authenticate from "./views/Authenticate";
import Notes from "./notes/views/Notes";
import NotesCreate from "./notes/views/NotesCreate";
import NotesShow from "./notes/views/NotesShow";
import NotesUpdate from "./notes/views/NotesUpdate";
import NotFound from "./views/NotFound";
import HackerNews from "./hn/views/HackerNews";
import HackerNewsPost from "./hn/views/HackerNewsPost";
import Users from "./users/views/Users";

Vue.use(Router);

// Route definitions
export const AuthenticateRoute = {
  path: '/authenticate',
  name: 'Authenticate',
  component: Authenticate,
};

export const DashboardRoute = {
  path: '/dashboard',
  alias: '/',
  name: 'Dashboard',
  component: Dashboard,
};

//region Notes routes definition
export const NotesRoute = {
  path: '/notes',
  name: 'Notes',
  component: Notes,
};
export const NotesCreateRoute = {
  path: '/notes/new',
  name: 'NotesCreate',
  component: NotesCreate,
};
export const NotesShowRoute = {
  path: '/notes/:id',
  name: 'NotesShow',
  component: NotesShow,
  props: true,
};
export const NotesUpdateRoute = {
  path: '/notes/edit/:id',
  name: 'NotesUpdate',
  component: NotesUpdate,
  props: true,
};
//endregion

//region hacker news routes definitions
export const HackerNewsRoute = {
  path: '/hn/:type',
  name: 'HackerNews',
  component: HackerNews,
  props: true,
};
export const HackerNewsPostRoute = {
  path: '/hn/post/:id',
  name: 'HackerNewsPost',
  component: HackerNewsPost,
  props: true,
};
//endregion

// region user management routes definitions
export const UsersRoute = {
  path: '/users',
  name: 'Users',
  component: Users,
};
//endregion

//region 404 routes definitions
export const NotFoundRoute = {
  path: '/404',
  name: 'NotFound',
  component: NotFound,
  props: true,
}
const CatchAllRoute = {
  path: '*',
  redirect: '/404'
}
//endregion

// Router initialization
export const router = new Router({
  routes: [
    AuthenticateRoute,

    DashboardRoute,

    NotesRoute,
    NotesCreateRoute,
    NotesShowRoute,
    NotesUpdateRoute,

    HackerNewsRoute,
    HackerNewsPostRoute,

    UsersRoute,

    // These routes must be set last, since routes run based on order of definition
    NotFoundRoute,
    CatchAllRoute,
  ],
});
