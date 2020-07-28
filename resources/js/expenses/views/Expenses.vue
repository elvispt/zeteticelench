<template>
  <div id="expenses">
    <navigation></navigation>
    <router-view></router-view>
  </div>
</template>

<script>
import Navigation from "../components/Navigation";

export default {
  name: "Expenses",

  components: {
    Navigation,
  },
}
</script>
