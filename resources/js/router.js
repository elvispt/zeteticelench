import Vue from 'vue';
import Router from 'vue-router';
import Dashboard from "./dashboard/views/Dashboard";
import Authenticate from "./views/Authenticate";

Vue.use(Router);

export const AuthenticateRoute = {
  path: '/authenticate',
  name: 'Authenticate',
  component: Authenticate,
};
export const DashboardRoute = {
  path: '/',
  name: 'Dashboard',
  component: Dashboard,
};

export const router = new Router({
  routes: [
    AuthenticateRoute,
    DashboardRoute,
  ],
});
