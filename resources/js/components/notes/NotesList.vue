<template>
  <div id="notes-list">
    <ul class="list-group list-group-flush" v-loading="loading">
      <el-alert
        v-if="!notes.length"
        title="Could not find any records"
        type="info"
        center
        @close="close"
        close-text="Close here or hit the ESC key"
      ></el-alert>

      <li v-for="note in notes" class="list-group-item list-group-item-action p-2 p-sm-3">
        <router-link :to="`/${note.id}`" class="text-secondary">
          <div class="d-flex w-100 justify-content-between">
            <h5 class="mb-1">{{ note.title }}</h5>
            <small class="d-none d-sm-block">{{ note.updated_at | diffForHumans }}</small>
          </div>
        </router-link>
        <div>
          <el-tag
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
import moment from "moment";
import _get from "lodash.get";

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
      const response = await axios.get(`/api/notes?query=${searchQuery}`);
      this.notes = _get(response, 'data.data', []);
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

<style scoped>
.el-tag {
  border-top-right-radius: 0;
  border-bottom-right-radius: 0;
}
.el-tag + .el-tag {
  border-top-left-radius: 0;
  border-bottom-left-radius: 0;
  border-left: none;
}
.el-tag:last-child {
  border-top-right-radius: 4px;
  border-bottom-right-radius: 4px;
}
</style>
