<template>
  <div id="notes-listing">
    <div class="row justify-content-center">
      <algolia-search></algolia-search>
    </div>
    <div class="row">
      <div class="col-12 mt-3 no-gutter-xs">
        <notes-list></notes-list>
      </div>
    </div>
  </div>
</template>

<script>
import AlgoliaSearch from "../components/AlgoliaSearch";
import NotesList from "../components/NotesList";

export default {
  name: "NotesListing",

  components: {
    AlgoliaSearch,
    NotesList,
  },
}
</script>
