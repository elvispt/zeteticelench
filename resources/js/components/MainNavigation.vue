<template>
  <nav v-if="showMenu" id="main-navigation" class="navbar navbar-expand-md navbar-light navbar-laravel">
    <div class="container">
      <a class="navbar-brand" href="/">Zetetic Elench</a>
      <button class="navbar-toggler" type="button" @click="menuCollapsed = !menuCollapsed">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="navbar-collapse"
           :class="{ 'collapse': menuCollapsed }"
      >
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
          <li class="nav-item">
            <a class="nav-link text-right text-sm-left"
               :class="{ 'text-primary': isNoteRoute }"
               href="/notes"
            >{{ $I18n.trans('notes.notes') }}</a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-right text-sm-left"
               :class="{ 'text-primary': isHackerNewsRoute }"
               href="/hn"
            >{{ $I18n.trans('hackernews.hackernews') }}</a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-right text-sm-left"
               :class="{ 'text-primary': isUsersRoute }"
               href="/users"
            >{{ $I18n.trans('users.users') }}</a>
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
import { AuthenticateRoute } from "../router";

export default {
  name: "MainNavigation",

  data() {
    return {
      showMenu: true,
      menuCollapsed: true,
      isNoteRoute: false,
      isHackerNewsRoute: false,
      isUsersRoute: false,
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

  created() {
    this.appRoutes = this.$router.options.routes.map(route => route.name);

    this.isNoteRoute = this.appRoutes.includes('Notes');
    this.isHackerNewsRoute = this.appRoutes.includes('HackerNewsTop');
  },

  mounted() {
    this.toggleMenuVisibility(this.$route);
  },
}
</script>
