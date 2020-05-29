<template>
  <div class="card mb-3 shadow">
    <div class="card-body">
      <small><span v-if="!inspire">{{ fallback }}</span>{{ inspire }}</small>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import _get from "lodash.get";

export default {
  name: "Inspire",

  data() {
    return {
      inspire: null,
      fallbackLines: [
        "The hardest part of building software is deciding what to build.",
        "Everything not specified will be specified by the programmer, on the fly.",
        "Design is also specification.",
        "Everything that is public-facing defines the significant part of the business logic.",
        "The open office plan is the best way to destroy productivity.",
        "Don’t multitask. Focus on one task at a time.",
        "There is work time and there is personal time. Don’t mix the two.",
        "Everyone writes bad code except for you. /s",
      ],
    };
  },

  computed: {
    fallback() {
      return this.fallbackLines[Math.floor(Math.random() * this.fallbackLines.length)];
    },
  },

  created() {
    this.fetchInspire();
  },

  methods: {
    async fetchInspire() {
      const response = await axios.get('/api/inspire');
      this.inspire = _get(response, 'data.data');
    },
  },
}
</script>
