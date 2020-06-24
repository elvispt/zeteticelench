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
import UsersCreate from "./users/views/UsersCreate";
import HackerNewsList from "./hn/views/HackerNewsList";

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
export const HackerNewsTopPostsRoute = {
  path: '',
  alias: 'top',
  name: 'HackerNewsTopPostsRoute',
  component: HackerNewsList,
  props: { type: 'top' },
}
export const HackerNewsBestPostsRoute = {
  path: 'best',
  name: 'HackerNewsBestPostsRoute',
  component: HackerNewsList,
  props: { type: 'best' },
}
export const HackerNewsBookmarkedPostsRoute = {
  path: 'bookmarks',
  name: 'HackerNewsBookmarkedPostsRoute',
  component: HackerNewsList,
  props: { type: 'bookmarks' },
}
export const HackerNewsPostRoute = {
  path: '/:id',
  name: 'HackerNewsPost',
  component: HackerNewsPost,
  props: true,
};
export const HackerNewsRoute = {
  path: '/hn',
  component: HackerNews,
  children: [
    HackerNewsTopPostsRoute,
    HackerNewsBestPostsRoute,
    HackerNewsBookmarkedPostsRoute,
    HackerNewsPostRoute,
  ],
};
//endregion

// region user management routes definitions
export const UsersRoute = {
  path: '/users',
  name: 'Users',
  component: Users,
};
export const UsersCreateRoute = {
  path: '/users/new',
  name: 'UsersCreate',
  component: UsersCreate,
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

    UsersRoute,
    UsersCreateRoute,

    // These routes must be set last, since routes run based on order of definition
    NotFoundRoute,
    CatchAllRoute,
  ],
});
