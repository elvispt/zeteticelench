<template>
  <div class="card shadow mb-3">
    <div class="card-header">{{ langNextHoliday }}</div>
    <div class="card-body" v-loading="loading">
      <div v-for="holiday in nextHolidays">
        <p>
          <span class="badge badge-dark">#</span>
          {{ holiday.name }},
          {{ holiday.date | diffForHumans }}
          at {{ holiday.date }}
          <small>{{ holiday.type }}</small>
        </p>
        <p>
          <span v-if="!holiday.description">&nbsp;</span>
          <small>{{ holiday.description }}</small>
        </p>
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
      loading: true,
      nextHolidays: [
        { name: '', date: '', type: '', description: '' },
        { name: '', date: '', type: '', description: '' },
        { name: '', date: '', type: '', description: '' },
      ],
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
          this.loading = false;
        }
        return true;
      },
  },

  filters: {
    diffForHumans(value) {
      if (!value) {
        return '';
      }
      return moment(value, 'YYYY-MM-DD')
        .fromNow();
    },
  },

  created() {
    this.fetchNextHolidays();
  },
}
</script>
