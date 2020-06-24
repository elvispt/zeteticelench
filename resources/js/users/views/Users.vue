<template>
  <div id="users">
    <navigation></navigation>
    <router-view></router-view>
  </div>
</template>

<script>
import Navigation from "../components/Navigation";

export default {
  name: "Users",

  components: {
    Navigation,
  },
}
</script>
