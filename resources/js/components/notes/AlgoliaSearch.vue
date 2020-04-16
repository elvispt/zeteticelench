<template>
  <div class="col-12" id="algolia-search">
    <div class="justify-content-center form-inline">
      <label class="sr-only" for="query">SEARCH HERE</label>
      <input type="text"
             class="form-control w-50"
             id="query"
             name="query"
             v-model="searchQuery"
             @keyup.esc="clearSearch"
      >
      &nbsp;
      <img src="search-by-algolia.svg" alt="search by algolia">
    </div>
  </div>
</template>

<script>
import debounce from "lodash.debounce";

export default {
  name: "AlgoliaSearch",

  data() {
    return {
      searchQuery: '',
    }
  },

  watch: {
    searchQuery() {
      this.submit();
    }
  },

  methods: {
    submit: debounce(function () {
      this.$emit("inputData", this.searchQuery);
    }, 400),
    clearSearch() {
      this.searchQuery = '';
    },
  },
}
</script>
