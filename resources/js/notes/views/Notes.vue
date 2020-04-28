<template>
  <div id="notes">
    <navigation></navigation>
    <div class="row justify-content-center">
      <algolia-search
        @inputData="updateMessage"></algolia-search>
    </div>
    <div class="row">
      <div class="col-12 mt-3 no-gutter-xs">
        <notes-list
          :search-query="searchQuery"
          @inputData="updateMessage"
        ></notes-list>
      </div>
    </div>
  </div>
</template>

<script>
import Navigation from "../components/Navigation";
import AlgoliaSearch from "../components/AlgoliaSearch";
import NotesList from "../components/NotesList";

export default {
  name: "Notes",

  data() {
    return {
      searchQuery: '',
    };
  },

  components: {
    Navigation,
    AlgoliaSearch,
    NotesList,
  },

  methods: {
    updateMessage(value) {
      this.searchQuery = value;
    },
  },
}
</script>
