<template>
  <div id="notes-list">
    <ul class="list-group list-group-flush" v-loading="loading">
      <el-alert
        v-if="!notesList.length"
        :title="$I18n.trans('notes.alert_failed_to_find_records')"
        type="info"
        center
        @close="close"
        :close-text="$I18n.trans('notes.alert_close_text')"
      ></el-alert>

      <li v-for="note in notesList" class="list-group-item list-group-item-action p-2 p-sm-3" :key="note.id">
        <router-link
          :to="{name: notesShowRoute.name, params: { id: note.id }}"
          class="text-secondary">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{ note.title }}</h5>
            <small class="d-none d-sm-block">{{ note.updated_at | diffForHumans }}</small>
          </div>
        </router-link>
        <div>
          <el-tag
            class="mr-1 mb-1"
            v-for="tag in note.tags"
            v-bind:key="tag.id"
            size="small"
          >{{ tag.name }}</el-tag>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import { NotesShowRoute } from "../../router";

export default {
  name: "NotesList",

  data() {
    return {
      notesShowRoute: NotesShowRoute,
      loading: true,
    };
  },

  computed: mapGetters(['notesList']),

  methods: {
    ...mapActions(['fetchNotesList', 'updateSearchQuery']),
    close() {
      this.updateSearchQuery('');
      this.loading = true;
      this.fetchNotesList()
        .then((result) => { this.loading = false });
    },
  },

  created() {
    this.fetchNotesList()
      .then((result) => { this.loading = false });
  },
}
</script>
