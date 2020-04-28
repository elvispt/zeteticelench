<template>
  <div id="note-update">
    <navigation></navigation>

    <div class="row justify-content-center">
      <div class="col-sm no-gutter-xs">
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
            <div class="d-flex justify-content-between">
              <small class="form-text text-muted ml-3">
                <a
                  class="text-muted"
                  href="https://commonmark.org/help/"
                  tabindex=-1
                  target="_CommonMark">CommonMark</a>
              </small>
              <el-button
                circle
                size="small"
                type="info"
                @click="insertCodeBlockBackTicks"
              >```</el-button>
            </div>

            <div class="mt-3 ml-3">
              <p>Tags:</p>
              <el-checkbox-group v-model="selectedTags" size="small" class="d-inline-block">
                <el-checkbox-button
                  class="mr-1"
                  v-for="tag in tags"
                  v-bind:key="tag.id"
                  :label="tag.id"
                >{{ tag.name }}</el-checkbox-button >
              </el-checkbox-group>
              <div class="d-inline-block new-tag-group">
                <el-input
                  class="input-new-tag"
                  v-if="newTagInputVisible"
                  v-model="newTag"
                  ref="saveTagInput"
                  size="small"
                  @keyup.enter.native="addNewTag"
                  @blur="addNewTag"
                ></el-input>
                <el-button
                  v-else
                  type="info"
                  plain
                  class="button-new-tag"
                  size="small"
                  @click="showInput"
                >+ New Tag</el-button>
              </div>
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
import Navigation from "../components/Navigation";

export default {
  name: "NoteUpdate",

  components: {
    Navigation,
  },

  props: ['id'],

  data() {
    return {
      loading: true,
      newTagInputVisible: false,
      newTag: '',
      errors: [],
      success: false,
      note: {},
      tags: [
        {id: 1, name: 'x'}
      ],
      selectedTags: [],
      inputEl: null,
    };
  },

  methods: {
    insertCodeBlockBackTicks() {
      const textToInsert = "```";
      if (!this.inputEl) {
        this.inputEl = document.querySelector('#note-update textarea');
      }
      const inserted = document.execCommand("insertText",false, textToInsert);

      // Firefox fails with execCommand
      if (!inserted && typeof this.inputEl.setRangeText === "function") {
        const start = this.inputEl.selectionStart;
        this.inputEl.setRangeText(textToInsert)
        this.inputEl.selectionStart = this.inputEl.selectionEnd = start + textToInsert.length;

        // notify any listeners of change
        const event = document.createEvent("UIEvent");
        event.initEvent("input", true, false);
        this.inputEl.dispatchEvent(event);
      }
    },
    async addNewTag() {
      if (this.newTag) {
        this.errors = [];

        try {
          const response = await axios.post('/api/notetagcreate', {
            tag: this.newTag
          });
          const success = _get(response, 'data.data.success');
          const id = _get(response, 'data.data.id');
          if (success && id) {
            this.tags.push({id: id, 'name': this.newTag});
            this.newTagInputVisible = false;
            this.newTag = '';
          }
        } catch (err) {
          const msg = _get(err, 'response.data.errors.tag[0]');
          this.errors.push({ field: 'tagCreate', text: msg });
        }
      }
    },
    showInput() {
      this.newTagInputVisible = true;
      this.$nextTick(_ => {
        this.$refs.saveTagInput.$refs.input.focus();
      });
    },
    async fetchNote(id) {
      if (!id) {
        return false;
      }

      const response = await axios.get(`/api/notes/${id}?html=0`);
      this.note = _get(response, 'data.data', []);
      this.selectedTags = this.note.tags.map(tag => tag.id);
      setTimeout(() => this.loading = false, 400);
    },
    async fetchTags() {
      const response = await axios.get('/api/notes/tags');
      this.tags = _get(response, 'data.data', []);
    },
    async submitForm(event) {
      event.preventDefault();
      if (this.newTagInputVisible) {
        return false;
      }
      this.errors = [];
      if (!this.note.body) {
        this.errors.push({ field: 'body', text: "Note text is empty."});
        return;
      }

      try {
        const response = await axios.put(`/api/noteupdate/${this.note.id}`, {
          body: this.note.body,
          tags: this.selectedTags,
          _method: 'put',
        });
        if (_get(response, 'data.data.success')) {
          this.success = true;
          this.selectedTags = [];
          await this.$router.push({name: 'Note', params: {id: this.note.id}})
        } else {
          this.errors.push({ field: 'na', text: "Failed to update note."});
        }
      } catch (err) {
        this.errors.push({ field: 'submit', text: err.message });
      }
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
  .new-tag-group {
    font-size: 0;
  }
  .new-tag-group .input-new-tag, .new-tag-group .button-new-tag {
    vertical-align: middle;
    width: 120px;
  }
  #note-update >>> .el-checkbox-button--small .el-checkbox-button__inner {
    border-radius: 4px;
    border: 1px solid #DCDFE6;
  }
  #note-update >>> .el-checkbox-button.is-checked .el-checkbox-button__inner {
    border-color: #409EFF;
  }
</style>
