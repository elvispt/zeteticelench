<template>
  <div class="card mb-3 shadow">
    <div class="card-body">
      <small>{{ inspire }}</small>
    </div>
  </div>
</template>

<script>
  export default {
    name: "Inspire",

    data() {
      return {
        inspire: ' ',
      };
    },

    created() {
      this.fetchInspire();
    },

    methods: {
      fetchInspire() {
        fetch('api/inspire')
          .then(response => response.json())
          .then(data => {
            if (!data) {
              return
            }
            this.inspire = data.data;
          })
          .catch(err => console.error(err))
        ;
      }
    },

  }
</script>
