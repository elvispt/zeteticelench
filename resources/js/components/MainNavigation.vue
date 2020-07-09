<template>
  <nav v-if="showMenu" id="main-navigation" class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
      <router-link
        class="navbar-brand"
        exact
        :to="dashboardRoute"
      >Zetetic Elench</router-link>
      <button class="navbar-toggler" type="button" @click="menuCollapsed = !menuCollapsed">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse"
           :class="{ 'collapse': menuCollapsed }"
      >
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
          <li v-for="menuOpt in menuOptions" class="nav-item">
            <router-link
              class="nav-link text-right text-sm-left"
              :to="menuOpt.route"
            >{{ menuOpt.text }}</router-link>
          </li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-right text-sm-left"
               href="#"
               @click="logout($event)"
            >{{ $I18n.trans('users.logout') }}</a>
          </li>
        </ul>

      </div>
    </div>
  </nav>
</template>

<script>
import axios from "axios";
import {
  AuthenticateRoute,
  DashboardRoute,
  HackerNewsRoute,
  NotesRoute,
  UsersRoute,
  ExpensesRoute,
} from "../router";
import { clearLocalUser } from "../helpers/user";

export default {
  name: "MainNavigation",

  data() {
    return {
      dashboardRoute: DashboardRoute,
      menuOptions: [
        { route: NotesRoute, text: this.$I18n.trans('notes.notes') },
        { route: HackerNewsRoute, text: this.$I18n.trans('hackernews.hackernews') },
        { route: ExpensesRoute, text: this.$I18n.trans('expenses.expenses') },
        { route: UsersRoute, text: this.$I18n.trans('users.users') },
      ],
      showMenu: true,
      menuCollapsed: true,
      appRoutes: [],
    };
  },
  methods: {
    logout(event) {
      event.preventDefault();
      // send to spa auth page
      axios.post('/logout', {})
        .then(() => {
          clearLocalUser();
          this.showMenu = false;
          this.$router.push(AuthenticateRoute);
          this.showMenu = false;
        });
    },
    toggleMenuVisibility(newRoute) {
      this.showMenu = AuthenticateRoute.name !== newRoute.name;
    },
  },

  watch: {
    $route: function routeWatch(newRoute, oldRoute) {
      this.toggleMenuVisibility(newRoute);
    },
  },

  mounted() {
    this.toggleMenuVisibility(this.$route);
  },
}
</script>

<style scoped lang="scss">
  #main-navigation .router-link-active {
    color: #3490dc;
  }
</style>
