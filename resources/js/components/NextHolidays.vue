<template>
  <div class="card shadow mb-3">
    <div class="card-header">{{ langNextHoliday }}</div>
    <div class="card-body">
      <div v-for="holiday in nextHolidays">
        <p>
          <span class="badge badge-dark">#</span>
          {{ holiday.name }},
          {{ holiday.date | diffForHumans }}
          at {{ holiday.date }}
          <small>{{ holiday.type }}</small>
        </p>
        <p><small>{{ holiday.description }}</small></p>
      </div>
    </div>

  </div>
</template>

<script>
import moment from 'moment';

export default {
  name: "NextHolidays",

  props: [
    'langNextHoliday',
  ],

  data() {
    return {
      nextHolidays: [],
    };
  },

  methods: {
      async fetchNextHolidays() {
        const response = await fetch('/api/next-holidays');
        const json = await response.json();
        const data = json.data || [];
        if (data.length) {
          this.nextHolidays = data.map(holiday => {
            return {
              'name': holiday.name,
              'description': holiday.description,
              'date': holiday.date.iso,
              'type': Array.isArray(holiday.type) ? holiday.type[0] : '',
            };
          });
        }
        return true;
      },
  },

  filters: {
    diffForHumans(value) {
      return moment(value, 'YYYY-MM-DD')
        .fromNow();
    },
  },

  created() {
    this.fetchNextHolidays();
  },
}
</script>
