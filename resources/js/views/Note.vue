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
          <span v-for="tag in note.tags"
                class="badge badge-secondary mr-1"
          >{{ tag }}</span>
        </div>
      </div>
    </div>

    <div class="row">
      <div class="col-12">
        <div class="mt-3">
          <a href="#"
             class="btn btn-primary"
          >Edit</a>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import Navigation from "../components/notes/Navigation";

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

      const response = await fetch(`/api/notes/${id}`);
      const json = await response.json();
      this.note = json.data;
      setTimeout(() => this.loading = false, 400);
    },
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
</style>
