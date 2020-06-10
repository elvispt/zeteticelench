<template>
  <div id="navigation">
    <div class="row justify-content-center top-submenu">
      <div class="col-12 no-gutter-xs">
        <div class="btn-group d-flex mb-2">
          <router-link
            :to="notesRoute"
            class="btn btn-group-sm w-100"
            :class="activeSubmenu('Notes')"
          >{{ $I18n.trans('notes.notes') }}</router-link>
          <router-link
            :to="notesCreateRoute"
            class="btn btn-group-sm w-100"
            :class="activeSubmenu('NotesCreate')"
          >{{ $I18n.trans('notes.new_note') }}</router-link>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
import {
  NotesCreateRoute,
  NotesRoute,
} from "../../router";

export default {
  name: "Navigation",

  data() {
    return {
      notesRoute: NotesRoute,
      notesCreateRoute: NotesCreateRoute,
    };
  },

  methods: {
    activeSubmenu(routeName) {
      return this.$route.name === routeName ? 'btn-primary' : 'btn-secondary';
    }
  },
}
</script>
