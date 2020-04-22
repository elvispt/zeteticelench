<template>
  <div class="note">
    <navigation></navigation>

    <div class="row justify-content-center" v-loading="loading">
      <div class="col-12">
        <div class="mt-3 " v-if="!note.id">
          <p class="loader-text pb-2 pt-3">&nbsp;</p>
          <p class="loader-text">&nbsp;</p>
          <p class="loader-text">&nbsp;</p>
          <p class="loader-text loader-text--1x3 d-inline-block">&nbsp; &nbsp;</p>
        </div>
        <div class="mt-3" v-html="note.body"></div>
        <div>
          <el-tag
            v-for="tag in note.tags"
            v-bind:key="tag.id"
            size="big"
          >{{ tag.name }}</el-tag>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="mt-3">
          <router-link
            :to="`/edit/${note.id}`"
            class="btn btn-primary"
          >Edit</router-link>
          <button
            @click="confirmDelete(note.id)"
            class="btn btn-danger ml-3"
          >Delete Note</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Navigation from "../components/notes/Navigation";
import _get from "lodash.get";
import "highlight.js/styles/darkula.css";

export default {
  name: "Note",

  components: {
    Navigation,
  },

  props: ["id"],

  data() {
    return {
      loading: true,
      note: {},
    };
  },

  created() {
    this.fetchNote(this.id);
  },

  methods: {
    async fetchNote(id) {
      if (!id) {
        return false;
      }

      const response = await axios.get(`/api/notes/${id}?html=1`);
      this.note = _get(response, 'data.data');
      setTimeout(() => this.loading = false, 400);
    },
    confirmDelete: function (noteId) {
      this.$confirm(`This will permanently delete the note (${noteId}). Continue?`, 'Warning', {
        confirmButtonText: 'Delete',
        cancelButtonText: 'Cancel',
        type: "warning",
        center: true,
      }).then(() => {
        this.deleteNote(noteId)
          .then(result => {
            if (result) {
              this.$message({
                type: 'success',
                message: `Note (${noteId}) was deleted.`,
                center: true,
              });
              setTimeout(() => this.$router.push({name: 'Notes'}), 400);
            }
          })
          .catch(err => {
            this.$message({
              type: 'warning',
              message: `Failed to delete note (${noteId}).`,
              center: true,
            });
          })
      }).catch(() => {
        this.$message({
          type: 'info',
          message: 'Delete canceled.',
          center: true,
        });
      });
    },
    async deleteNote(noteId) {
      const response = await axios.delete(`/api/notedestroy/${noteId}`, {
        _method: 'delete'
      });
      const success = _get(response, 'data.data.success', false);
      if (success) {
        return success;
      }
      throw `Delete failed`;
    }
  },
}
</script>

<style scoped>
.loader-text {
  background: #808080;
  border-radius: 2px;
}
.loader-text--1x3 {
  width: 33%;
}
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
