<template>
  <div id="notes">
    <navigation></navigation>
    <router-view></router-view>
  </div>
</template>

<script>
import Navigation from "../components/Navigation";

export default {
  name: "Notes",

  components: {
    Navigation,
  },
}
</script>
