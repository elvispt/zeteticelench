<template>
  <div id="navigation">
    <div class="row justify-content-center top-submenu">
      <div class="col-12 no-gutter-xs">
        <div class="btn-group d-flex mb-2">
          <router-link
            :to="notesRoute"
            class="btn btn-group-sm w-100 inner-nav btn-secondary"
          >{{ $I18n.trans('notes.notes') }}</router-link>
          <router-link
            :to="notesCreateRoute"
            class="btn btn-group-sm w-100 inner-nav btn-secondary"
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
}
</script>
