<template>
  <div class="card mb-3 shadow">
    <div class="card-header">{{ langRemoteJobs }}</div>
    <div class="card-body">
      <div class="list-group list-group-flush">
        <div v-for="job in jobs"
             class="list-group-item list-group-item-action">
          <div class="d-flex w-100 justify-content-between">
            <h6 class="mb-1 pointer"
                data-toggle="collapse"
                :data-target="'#collapse-'+ job.id"
            >{{ job.title }}</h6>
            <small class="text-muted">{{ job.time | diffForHumans | capitalize }}</small>
          </div>
          <div :id="'collapse-' + job.id" class="collapse mt-2 pl-2">
            <div>
              <a :href="job.url" target="_blank">{{ job.source }}</a>
            </div>
            <div v-html="job.howToApply"></div>
            <div v-if="job.companyUrl">
              <a :href="job.companyUrl">{{ job.companyUrl }}</a>
            </div>
            <div v-html="job.text"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import moment from "moment";

export default {
  name: "RemoteJobs",

  props: [
    "langRemoteJobs",
  ],

  data() {
    return {
      jobs: [],
    };
  },

  methods: {
    async fetchRemoteJobs() {
      const response = await fetch('/api/remote-jobs');
      const json = await response.json();
      this.jobs = json.data || [];
    },
  },

  filters: {
    diffForHumans(value) {
      return moment(value, 'YYYY-MM-DD')
        .fromNow();
    },
    capitalize(value) {
      let str = value.toString();
      return str.charAt(0).toUpperCase() + str.slice(1);
    },
  },

  created() {
    this.fetchRemoteJobs();
  }
}
</script>
