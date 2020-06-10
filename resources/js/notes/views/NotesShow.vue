<template>
  <div class="note">
    <navigation></navigation>

    <div class="row justify-content-center" v-loading="loading">
      <div class="col-12 no-gutter-xs">
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
            class="mr-1 mb-1"
          >{{ tag.name }}</el-tag>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="mt-3">
          <router-link
            v-if="note.id"
            :to="Object.assign(notesUpdateRoute, {params: { id: note.id }})"
            class="btn btn-primary"
          >{{ $I18n.trans('notes.edit') }}</router-link>
          <button
            @click="confirmDelete(note.id)"
            class="btn btn-danger ml-3"
          >{{ $I18n.trans('notes.delete') }}</button>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import _get from "lodash.get";
import "highlight.js/styles/darkula.css";
import Navigation from "../components/Navigation";
import {
  NotesRoute,
  NotesUpdateRoute,
  NotFoundRoute
} from "../../router";

export default {
  name: "NotesShow",

  components: {
    Navigation,
  },

  props: ["id"],

  data() {
    return {
      loading: true,
      note: {},
      notesUpdateRoute: NotesUpdateRoute,
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
      let response;

      try {
        response = await axios.get(`/api/notes/${id}?html=1`);
      } catch (err) {
        if (err.response.status === 404) {
          await this.$router.push(Object.assign(NotFoundRoute, {
            params: {
              message: `Note could not be found.`,
              linksTo: [
                {
                  route: NotesRoute,
                  linkText: 'Notes'
                },
              ],
            }})
          );
          return;
        }
      }

      this.note = _get(response, 'data.data');
      setTimeout(() => this.loading = false, 400);
    },
    async confirmDelete(noteId) {
      const askConfirmation = this.$I18n.trans('notes.confirmation_ask_delete', { id: noteId });
      const confirmationDeleteSuccess = this.$I18n.trans('notes.confirmation_success_deleted', { id: noteId });
      const confirmButtonText = this.$I18n.trans('notes.delete');
      const cancelButtonText = this.$I18n.trans('notes.cancel');

      this.$confirm(askConfirmation, 'Warning', {
        confirmButtonText,
        cancelButtonText,
        type: "warning",
        center: true,
      }).then(() => {
        this.deleteNote(noteId)
          .then(result => {
            if (result) {
              this.$message({
                type: 'success',
                message: confirmationDeleteSuccess,
                center: true,
              });
              setTimeout(() => this.$router.push(NotesRoute), 400);
            }
          })
          .catch(err => {
            this.$message({
              type: 'warning',
              message: this.$I18n.trans('notes.failed_delete', { id: noteId }),
              center: true,
            });
          })
      }).catch(() => {
        this.$message({
          type: 'info',
          message: this.$I18n.trans('notes.delete_canceled', { id: noteId }),
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
.note >>> .footnotes {
  font-size: 0.8rem;
}
.note >>> .footnotes p {
  margin-bottom: 0.5rem;
}
.note >>> table.table th[align="left"] {
  text-align: left;
}
.note >>> table.table th[align="center"] {
  text-align: center;
}
.note >>> table.table th[align="right"] {
  text-align: right;
}
</style>
