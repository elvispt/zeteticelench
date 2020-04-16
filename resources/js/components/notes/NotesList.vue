<template>
  <div id="notes-list">
    <ul class="list-group list-group" v-loading="loading">
      <el-alert
        v-if="!notes.length"
        title="Could not find any records"
        type="info"
        center
        @close="close"
        close-text="Close here or hit the ESC key"
      ></el-alert>

      <li v-for="note in notes" class="list-group-item list-group-item-action p-2 p-sm-3">
        <router-link to="/" class="text-secondary">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{ note.title }}</h5>
            <small class="d-none d-sm-block">{{ note.updated_at | diffForHumans }}</small>
          </div>
        </router-link>
        <div>
          <span v-for="tag in note.tags" class="badge badge-secondary mr-1">{{ tag }}</span>
        </div>
      </li>
    </ul>
  </div>
</template>

<script>
import moment from 'moment';

export default {
  name: "NotesList",

  props: ["searchQuery"],

  data() {
    return {
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
      const request = await fetch(`/api/notes?query=${searchQuery}`);
      const response = await request.json();
      if (response && response.data && Array.isArray(response.data)) {
        this.notes = response.data;
      }
      return true;
    },
    close() {
      this.$emit("inputData", '');
    },
  },

  filters: {
    diffForHumans(value) {
      if (!value) {
        return '';
      }
      return moment(value, 'YYYY-MM-DD hh:mm:ss')
        .fromNow();
    },
  },
}
</script>
