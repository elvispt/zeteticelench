<template>
  <div class="card mb-3 shadow">
    <div class="card-header">{{ langSystemInfo }}</div>

    <div class="card-body" v-loading="loading">
      <transition name="slide-fade" mode="out-in">
        <p class="alert-info" :key="up">
          {{ up | capitalize }} {{ langSince }} {{ upSince }}
        </p>
      </transition>

      <p v-bind:class="{ 'alert-success': nQueueWorkersRunning, 'alert-danger': !nQueueWorkersRunning }">
        {{ langNumberQueueWorkers }}: {{ nQueueWorkersRunning }}
      </p>

      <div class="pt-4">
        <table class="table table-sm">
          <caption>{{ langMemoryInfo }}</caption>
          <thead>
            <tr>
              <th>{{ langUsed }}</th>
              <th>{{ langFree }}</th>
              <th>{{ langTotal }}</th>
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
  export default {
    name: "SystemInfo",

    props: [
      'langSystemInfo',
      'langSince',
      'langNumberQueueWorkers',
      'langMemoryInfo',
      'langUsed',
      'langFree',
      'langTotal',
    ],

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
      fetchSystemInfo() {
        fetch('/api/system-info')
          .then(response => response.json())
          .then(response => {
            const data = response.data;
            this.memory.free = data.memory.free;
            this.memory.used = data.memory.used;
            this.memory.total = data.memory.total;
            this.nQueueWorkersRunning = data.nQueueWorkersRunning;
            this.up = data.up;
            this.upSince = data.upSince;
            setTimeout(() => this.loading = false, 500);
          })
          .catch(err => console.error(err))
        ;
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
