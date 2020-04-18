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

      const response = await fetch(`/api/notes/${id}?html=1`);
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
