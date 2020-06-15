<template>
  <div id="notes-list">
    <ul class="list-group list-group-flush" v-loading="loading">
      <el-alert
        v-if="!notes.length"
        :title="$I18n.trans('notes.alert_failed_to_find_records')"
        type="info"
        center
        @close="close"
        :close-text="$I18n.trans('notes.alert_close_text')"
      ></el-alert>

      <li v-for="note in notes" class="list-group-item list-group-item-action p-2 p-sm-3">
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
import axios from "axios";
import _get from "lodash.get";
import {NotesShowRoute} from "../../router";

export default {
  name: "NotesList",

  props: ["searchQuery"],

  data() {
    return {
      notesShowRoute: NotesShowRoute,
      loading: true,
      notes: [],
    };
  },

  created() {
    this.fetchNotes(this.searchQuery)
      .then((result) => { this.loading = false });
  },

  watch: {
    searchQuery() {
      this.loading = true;
      this.fetchNotes(this.searchQuery)
        .then((result) => { this.loading = false });
    }
  },

  methods: {
    async fetchNotes(searchQuery) {
      const response = await axios.get(`/api/notes?query=${searchQuery}`);
      this.notes = _get(response, 'data.data', []);
      return true;
    },
    close() {
      this.$emit("inputData", '');
    },
  },
}
</script>
