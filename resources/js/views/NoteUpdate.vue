<template>
  <div id="note-update">
    <navigation></navigation>

    <div class="row justify-content-center">
      <div class="col-sm">
        <div class="card shadow" v-loading="loading">
          <div class="p-1" v-if="errors.length">
            <el-alert v-for="error in errors" v-bind:key="error.field"
              :title="error.text"
              type="error"
            ></el-alert>
          </div>
          <form
            @submit="submitForm"
            method="post"
          >
            <div class="textarea-container">
              <textarea
                v-model.trim="note.body"
                name="body"
                class="form-control form-text m-0"
                cols="100"
                rows="15"
                placeholder="# Title of note"
              ></textarea>
            </div>
            <small class="form-text text-muted ml-3">
              <a
                class="text-muted"
                href="https://commonmark.org/help/"
                tabindex=-1
                target="_CommonMark">CommonMark</a>
            </small>

            <div class="mt-3 ml-3">
              <p>Tags:</p>
              <el-checkbox-group v-model="selectedTags" size="small">
                <el-checkbox-button
                  v-for="tag in tags"
                  v-bind:key="tag.id"
                  :label="tag.id"
                >{{ tag.name }}</el-checkbox-button >
              </el-checkbox-group>
            </div>

            <div class="px-3 pb-3 pt-3">
              <button
                type="submit"
                class="btn btn-primary"
              >Update Note</button>
              <el-alert
                v-if="success"
                class="mt-3"
                title="Note created!"
                type="success"
              ></el-alert>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _get from "lodash.get";
import Navigation from "../components/notes/Navigation";

export default {
  name: "NoteUpdate",

  components: {
    Navigation,
  },

  props: ['id'],

  data() {
    return {
      loading: true,
      errors: [],
      success: false,
      note: {},
      tags: [
        {id: 1, name: 'x'}
      ],
      selectedTags: [],
    };
  },

  methods: {
    async fetchNote(id) {
      if (!id) {
        return false;
      }

      const response = await fetch(`/api/notes/${id}?html=0`);
      const json = await response.json();
      this.note = json.data;
      this.selectedTags = this.note.tags.map(tag => tag.id);
      setTimeout(() => this.loading = false, 400);
    },
    async fetchTags() {
      const response = await fetch('/api/notes/tags');
      const json = await response.json();
      this.tags = _get(json, 'data', []);
    },
    submitForm(event) {
      event.preventDefault();
      this.errors = [];
      if (!this.note.body) {
        this.errors.push({ field: 'body', text: "Note text is empty."});
        return;
      }

      axios.put(`/api/noteupdate/${this.note.id}`, {
        body: this.note.body,
        tags: this.selectedTags,
        _method: 'put',
      })
        .then(response => {
          if (_get(response, 'data.data.success')) {
            this.success = true;
            this.selectedTags = [];
            this.$router.push({name: 'Note', params: {id: this.note.id}})
          } else {
            this.errors.push({ field: 'na', text: "Failed to update note."});
          }
        })
        .catch(err => {
          this.errors.push({ field: 'submit', text: err.message });
        });
    },
  },

  created() {
    this.fetchTags()
      .then(() => {
        this.fetchNote(this.id);
      });
  },
}
</script>

<style scoped>
  textarea {
    outline: 0;
    background: #f4f4f4;
    box-shadow: 1px 1px 0 #ccc;
    border-color: transparent;
    border-radius: 0;
  }
  textarea:focus {
    box-shadow: 1px 1px 0 #ccc;
    outline: 0;
    background: #f4f4f4;
    border-color: transparent;
  }
</style>
