<template>
  <div id="view-dashboard" class="pt-4">
    <div class="row justify-content-center">

      <div class="col-sm-6 no-gutter-xs">
        <inspire></inspire>
        <system-info ref="refSystemInfo"></system-info>
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

  beforeRouteLeave(to, from, next) {
    // clear looped requests that are made from subcomponent
    clearInterval(this.$refs.refSystemInfo.systemInfoLoop);
    next();
  },
}
</script>
