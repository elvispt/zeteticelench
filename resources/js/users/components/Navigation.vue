<template>
  <div id="navigation">
    <div class="row justify-content-center top-submenu">
      <div class="col-12 no-gutter-xs">
        <div class="btn-group d-flex mb-2">
          <router-link
            :to="usersRoute"
            class="btn btn-group-sm w-100 inner-nav btn-secondary"
          >{{ $I18n.trans('users.users') }}</router-link>
          <router-link
            :to="usersCreateRoute"
            class="btn btn-group-sm w-100 inner-nav btn-secondary"
          >{{ $I18n.trans('users.new-user') }}</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {
  UsersCreateRoute,
  UsersRoute
} from "../../router";

export default {
  name: "Navigation",

  data() {
    return {
      usersRoute: UsersRoute,
      usersCreateRoute: UsersCreateRoute,
    };
  },
}
</script>
