<template>
  <nav id="main-navigation" class="navbar navbar-expand-md navbar-light navbar-laravel">
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
               href="/notes"
            >Notes</a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-right text-sm-left"
               href="/hn"
            >HackerNews</a>
          </li>

          <li class="nav-item">
            <a class="nav-link text-right text-sm-left"
               href="/users"
            >Users</a>
          </li>
        </ul>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          <li class="nav-item">
            <a class="nav-link text-right text-sm-left"
               href="#"
               @click="logout($event)"
            >Logout</a>
          </li>
        </ul>

      </div>
    </div>
  </nav>
</template>

<script>
import axios from "axios";

export default {
  name: "MainNavigation",

  data() {
    return {
      menuCollapsed: true,
    };
  },
  methods: {
    logout(event) {
      event.preventDefault();
      axios.post('/logout', {})
        .then(() => window.location.href = '/');
    },
  },
}
</script>
