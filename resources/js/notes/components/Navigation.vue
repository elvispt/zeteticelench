<template>
  <div id="navigation">
    <div class="row justify-content-center top-submenu">
      <div class="col-12 no-gutter-xs">
        <div class="btn-group d-flex mb-2">
          <router-link
            to="/"
            class="btn btn-group-sm w-100"
            :class="activeSubmenu('Notes')"
          >{{ $I18n.trans('notes.notes') }}</router-link>
          <router-link
            to="/new"
            class="btn btn-group-sm w-100"
            :class="activeSubmenu('NoteCreate')"
          >{{ $I18n.trans('notes.new_note') }}</router-link>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: "Navigation",

  methods: {
    activeSubmenu(routeName) {
      return this.$route.name === routeName ? 'btn-primary' : 'btn-secondary';
    }
  },
}
</script>
