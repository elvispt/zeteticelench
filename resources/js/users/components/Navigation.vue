<template>
  <div id="navigation">
    <div class="row justify-content-center top-submenu">
      <div class="col-12 no-gutter-xs">
        <div class="btn-group d-flex mb-2">
          <router-link
            :to="usersRoute"
            class="btn btn-group-sm w-100"
            v-bind:class="activeSubmenu('top')"
          >{{ $I18n.trans('users.users') }}</router-link>
          <router-link
            :to="usersRoute"
            class="btn btn-group-sm w-100"
            v-bind:class="activeSubmenu('best')"
          >{{ $I18n.trans('users.new-user') }}</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { UsersRoute } from "../../router";

export default {
  name: "Navigation",

  data() {
    return {
      usersRoute: UsersRoute,
    };
  },

  methods: {
    activeSubmenu(typeParam) {
      return this.$route === typeParam ? 'btn-primary' : 'btn-secondary';
    },
  },
}
</script>
