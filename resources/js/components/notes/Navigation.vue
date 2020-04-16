<template>
  <div id="navigation">
    <div class="row justify-content-center top-submenu">
      <div class="col-12">
        <div class="btn-group d-flex mb-2">
          <router-link
            to="/"
            class="btn btn-group-sm w-100"
            v-bind:class="activeSubmenu('Notes')"
          >{{ translations.notes.notes }}</router-link>
          <router-link
            to="/"
            class="btn btn-group-sm w-100 @submenuactive('notesCreate')"
            v-bind:class="activeSubmenu('NotesCreate')"
          >{{ translations.notes['new-note'] }}</router-link>
          <router-link
            to="/"
            class="btn btn-group-sm w-100 @submenuactive('notesTags')"
            v-bind:class="activeSubmenu('NotesTags')"
          >{{ translations.notes.tags }}</router-link>
          <router-link
            to="/"
            class="btn btn-group-sm w-100 @submenuactive('notesTagsCreate')"
            v-bind:class="activeSubmenu('NotesTagsCreate')"
          >{{ translations.notes['new-tag'] }}</router-link>
        </div>
      </div>
    </div>

  </div>
</template>

<script>
export default {
  name: "Navigation",

  data() {
    return {
      translations: {
        notes: {},
      },
    };
  },

  created() {
    this.fetchTranslations('notes');
  },

  methods: {
    async fetchTranslations(group = '') {
      const request = await fetch(`/api/translations/?group=${group}`);
      let response = {};
      try {
        response = await request.json();
      } catch (err) {
        console.error(err);
      }
      this.translations[group] = response.data[group];
    },

    activeSubmenu(routeName) {
      return this.$route.name === routeName ? 'btn-primary' : 'btn-secondary';
    }
  },
}
</script>
