<template>
  <div id="view-dashboard" class="pt-4">
    <div class="row justify-content-center">

      <div class="col-sm-6 no-gutter-xs">
        <inspire></inspire>
        <system-info></system-info>
      </div>

      <div class="col-sm-6 no-gutter-xs">
        <weather></weather>
        <next-holidays></next-holidays>
      </div>

    </div>
  </div>
</template>

<script>
import Weather from "../components/Weather";
import SystemInfo from "../components/SystemInfo";
import Inspire from "../components/Inspire";
import NextHolidays from "../components/NextHolidays";

export default {
  name: "Dashboard",

  components: {
    Weather,
    SystemInfo,
    NextHolidays,
    Inspire,
  },

  data() {
    return {};
  },

  methods: {

  },

  created() {
  },
}
</script>
