<template>
  <div class="col-12" id="algolia-search">
    <div class="justify-content-center form-inline">
      <label class="sr-only" for="query">Search here</label>
      <input type="text"
             class="form-control w-50"
             id="query"
             name="query"
             v-model="searchQuery"
             @keyup.esc="clearSearch"
             placeholder="2 chars minimum"
      >
      &nbsp;
      <picture>
        <source srcset="search-by-algolia.svg" media="(min-width: 800px)">
        <img src="algolia-blue-mark.svg" alt="search by algolia" style="max-height: 30px;">
      </picture>
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
      if (this.searchQuery.length === 0 || this.searchQuery.length > 1) {
        this.submit();
      }
    }
  },

  methods: {
    submit: debounce(function() {
      this.$emit("inputData", this.searchQuery)
    }, 400),
    clearSearch() {
      this.searchQuery = '';
      this.submit();
    },
  },
}
</script>
