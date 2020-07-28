import Vue from 'vue';
import Router from 'vue-router';
import Authenticate from "./views/Authenticate";
import NotFound from "./views/NotFound";
import Dashboard from "./dashboard/views/Dashboard";
import Notes from "./notes/views/Notes";
import NotesListing from "./notes/views/NotesListing";
import NotesCreate from "./notes/views/NotesCreate";
import NotesShow from "./notes/views/NotesShow";
import NotesUpdate from "./notes/views/NotesUpdate";
import HackerNews from "./hn/views/HackerNews";
import HackerNewsList from "./hn/views/HackerNewsList";
import HackerNewsPost from "./hn/views/HackerNewsPost";
import Users from "./users/views/Users";
import UsersList from "./users/views/UsersList";
import UsersCreate from "./users/views/UsersCreate";
import Expenses from "./expenses/views/Expenses";
import ExpensesList from "./expenses/views/ExpensesList";
import ExpensesCreate from "./expenses/views/ExpensesCreate";
import { isUserAuthenticated } from "./helpers/user";

Vue.use(Router);

// Route definitions
export const AuthenticateRoute = {
  path: '/authenticate',
  name: 'Authenticate',
  component: Authenticate,
  meta: {
    requiresAuth: false,
  },
};

export const DashboardRoute = {
  path: '/dashboard',
  alias: '/',
  name: 'Dashboard',
  component: Dashboard,
  meta: {
    requiresAuth: true,
  },
};

//region Notes routes definition
export const NotesListRoute = {
  path: '',
  name: 'Notes',
  component: NotesListing,
  meta: {
    requiresAuth: true,
  },
};
export const NotesCreateRoute = {
  path: 'new',
  name: 'NotesCreate',
  component: NotesCreate,
  meta: {
    requiresAuth: true,
  },
};
export const NotesShowRoute = {
  path: ':id',
  name: 'NotesShow',
  component: NotesShow,
  props: true,
  meta: {
    requiresAuth: true,
  },
};
export const NotesUpdateRoute = {
  path: 'edit/:id',
  name: 'NotesUpdate',
  component: NotesUpdate,
  props: true,
  meta: {
    requiresAuth: true,
  },
};
export const NotesRoute = {
  path: '/notes',
  component: Notes,
  children: [
    NotesListRoute,
    NotesCreateRoute,
    NotesShowRoute,
    NotesUpdateRoute,
  ],
};
//endregion

//region hacker news routes definitions
export const HackerNewsTopPostsRoute = {
  path: '',
  alias: 'top',
  name: 'HackerNewsTopPostsRoute',
  component: HackerNewsList,
  props: { type: 'top' },
  meta: {
    requiresAuth: true,
  },
}
export const HackerNewsBestPostsRoute = {
  path: 'best',
  name: 'HackerNewsBestPostsRoute',
  component: HackerNewsList,
  props: { type: 'best' },
  meta: {
    requiresAuth: true,
  },
}
export const HackerNewsBookmarkedPostsRoute = {
  path: 'bookmarks',
  name: 'HackerNewsBookmarkedPostsRoute',
  component: HackerNewsList,
  props: { type: 'bookmarks' },
  meta: {
    requiresAuth: true,
  },
}
export const HackerNewsPostRoute = {
  path: ':id',
  name: 'HackerNewsPost',
  component: HackerNewsPost,
  props: true,
  meta: {
    requiresAuth: true,
  },
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

//region user management routes definitions
export const UsersListRoute = {
  path: '',
  name: 'UsersList',
  component: UsersList,
  meta: {
    requiresAuth: true,
  },
};
export const UsersCreateRoute = {
  path: 'new',
  name: 'UsersCreate',
  component: UsersCreate,
  meta: {
    requiresAuth: true,
  },
};
export const UsersRoute = {
  path: '/users',
  component: Users,
  children: [
    UsersListRoute,
    UsersCreateRoute,
  ],
};
//endregion

//region expenses routes definitions
export const ExpensesListRoute = {
  path: '',
  name: 'ExpensesList',
  component: ExpensesList,
  meta: {
    requiresAuth: true,
  },
};
export const ExpensesCreateRoute = {
  path: 'new',
  name: 'ExpensesCreate',
  component: ExpensesCreate,
  meta: {
    requiresAuth: true,
  },
};
export const ExpensesRoute = {
  path: '/expenses',
  component: Expenses,
  children: [
    ExpensesListRoute,
    ExpensesCreateRoute,
  ],
};
//endregion

//region 404 routes definitions
export const NotFoundRoute = {
  path: '/404',
  name: 'NotFound',
  component: NotFound,
  props: true,
  meta: {
    requiresAuth: true,
  },
}
const CatchAllRoute = {
  path: '*',
  redirect: '/404',
  meta: {
    requiresAuth: true,
  },
}
//endregion

// Router initialization
export const router = new Router({
  routes: [
    AuthenticateRoute,
    DashboardRoute,
    NotesRoute,
    HackerNewsRoute,
    UsersRoute,
    ExpensesRoute,
    // These routes must be set last, since routes run based on order of definition
    NotFoundRoute,
    CatchAllRoute,
  ],
});

router.beforeEach(async (to, from, next) => {
  const requiresAuth = to.matched.some(record => record.meta.requiresAuth);
  if (!requiresAuth) {
    next();
    return;
  }

  const isAuthenticated = await isUserAuthenticated();
  if (isAuthenticated) {
    if (to.name === AuthenticateRoute.name) {
      next(DashboardRoute);
    }
    next();
    return;
  }
  next(AuthenticateRoute);
});
