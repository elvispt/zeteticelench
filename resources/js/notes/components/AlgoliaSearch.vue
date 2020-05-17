<template>
  <div class="col-12 no-gutter-xs" id="algolia-search">
    <div class="justify-content-center form-inline d-flex">
      <label class="sr-only" for="query">{{ $I18n.trans('notes.search') }}</label>
      <input type="text"
             class="form-control flex-grow-1"
             id="query"
             name="query"
             v-model="searchQuery"
             @keyup.esc="clearSearch"
             :placeholder="$I18n.trans('notes.min_2_chars')"
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

<style scoped>
  .form-control {
    width: auto;
  }
</style>
