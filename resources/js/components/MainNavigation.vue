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
          <li class="nav-item">
            <router-link
              class="nav-link text-right text-sm-left"
              :to="notesRoute"
            >{{ $I18n.trans('notes.notes') }}</router-link>
          </li>

          <li class="nav-item">
            <router-link
              class="nav-link text-right text-sm-left"
              :to="hackerNewsRoute"
            >{{ $I18n.trans('hackernews.hackernews') }}</router-link>
          </li>

          <li class="nav-item">
            <router-link
              class="nav-link text-right text-sm-left"
              :to="usersRoute"
            >{{ $I18n.trans('users.users') }}</router-link>
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
} from "../router";

export default {
  name: "MainNavigation",

  data() {
    return {
      notesRoute: NotesRoute,
      dashboardRoute: DashboardRoute,
      hackerNewsRoute: HackerNewsRoute,
      usersRoute: UsersRoute,
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
