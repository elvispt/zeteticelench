<template>
  <div class="card mb-3 shadow">
    <div class="card-header">{{ $I18n.trans('system.info') }}</div>

    <div class="card-body" v-loading="loading">
      <transition name="slide-fade" mode="out-in">
        <p class="alert-info" :key="up">
          {{ up | capitalize }} {{ $I18n.trans('system.since') }} {{ upSince }}
        </p>
      </transition>

      <p v-bind:class="{ 'alert-success': nQueueWorkersRunning, 'alert-danger': !nQueueWorkersRunning }">
        {{ $I18n.trans('system.number_queue_workers') }}: {{ nQueueWorkersRunning }}
      </p>

      <div class="pt-4">
        <table class="table table-sm">
          <caption>{{ $I18n.trans('system.since') }}</caption>
          <thead>
            <tr>
              <th>{{ $I18n.trans('system.used') }}</th>
              <th>{{ $I18n.trans('system.free') }}</th>
              <th>{{ $I18n.trans('system.total') }}</th>
            </tr>
          </thead>
          <tbody>
            <transition name="slide-fade" mode="out-in">
              <tr :key="memory.used">
                <td><span v-if="!memory.used">&nbsp;</span>{{ memory.used }}</td>
                <td>{{ memory.free }}</td>
                <td>{{ memory.total }}</td>
              </tr>
            </transition>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import _get from "lodash.get";

export default {
  name: "SystemInfo",

  data() {
    return {
      loading: true,
      memory: {
        free: '',
        used: '',
        total: '',
      },
      nQueueWorkersRunning: 0,
      up: '',
      upSince: '',
    };
  },

  created() {
    this.fetchSystemInfo();
    // run every 10 seconds
    setInterval(this.fetchSystemInfo, 10000);
  },

  methods: {
    async fetchSystemInfo() {
      const response = await axios.get('/api/system-info');
      const data = _get(response, 'data.data', null);
      if (data) {
        this.memory.free = _get(data, 'memory.free');
        this.memory.used = _get(data, 'memory.used');
        this.memory.total = _get(data, 'memory.total');
        this.nQueueWorkersRunning = _get(data, 'nQueueWorkersRunning');
        this.up = _get(data, 'up');
        this.upSince = _get(data, 'upSince');
      }
      setTimeout(() => this.loading = false, 500);
    }
  },

  filters: {
    capitalize: value => {
      if (!value) {
        return;
      }
      value = value.toString();
      return value.charAt(0).toUpperCase() + value.slice(1);
    }
  },
}
</script>
<style scoped>
  .slide-fade-enter-active {
    transition: all .3s ease;
  }
  .slide-fade-leave-active {
    transition: all .5s cubic-bezier(1.0, 0.5, 0.8, 1.0);
  }
  .slide-fade-enter, .slide-fade-leave-to {
    background-color: #ffef0029;
  }
</style>
