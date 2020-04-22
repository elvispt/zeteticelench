<template>
  <div class="card mb-3 shadow">
    <div class="card-body">
      <small><span v-if="!inspire">&nbsp;</span>{{ inspire }}</small>
    </div>
  </div>
</template>

<script>
import _get from "lodash.get";

export default {
  name: "Inspire",

  data() {
    return {
      inspire: null,
    };
  },

  created() {
    this.fetchInspire();
  },

  methods: {
    async fetchInspire() {
      const response = await axios.get('/api/inspire');
      this.inspire = _get(response, 'data.data');
    }
  },
}
</script>
