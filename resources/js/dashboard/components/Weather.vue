<template>
  <div id="weather" v-loading="loading">
    <div class="card mb-3 shadow">
      <div class="card-body d-flex flex-wrap">
        <div class="align-self-center">
          <a href="https://openweathermap.org/city/2267827" target="_blank">
            <img v-bind:src="weather.icon" :alt="weather.description">
          </a>
        </div>
        <div class="divider align-items-stretch mx-2"></div>
        <div class="align-self-center ml-2">
          {{ weather.description | capitalize }}
        </div>
        <div class="divider align-items-stretch mx-2"></div>
        <div class="align-self-center">
          {{ weather.temp }} &#8451;
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import _get from "lodash.get";
import moment from "moment";

export default {
  name: "Weather",

  data() {
    return {
      loading: true,
      weather: {
        icon: '',
        description: '',
      },
    };
  },

  methods: {
    async fetchWeather() {
      const localStorageKey = 'openweather--currentweather';

      let stored;
      let storedString = localStorage.getItem(localStorageKey);
      try {
        stored = JSON.parse(storedString);
      } catch (err) {
        stored = null;
      }
      if (!stored || !stored.data || (stored.saved + 600000) < Date.now()) {
        stored = {
          data: {},
          saved: Date.now(),
        };
        const response = await fetch('http://api.openweathermap.org/data/2.5/weather?q=Funchal,PT&appid=fe66d26d5b01501290be42a4809bbc4e&units=metric&lang=pt');
        stored.data = await response.json();
        localStorage.setItem(localStorageKey, JSON.stringify(stored));
      }

      const iconCode = _get(stored, 'data.weather[0].icon');
      this.weather.icon = `http://openweathermap.org/img/wn/${iconCode}.png`;
      this.weather.temp = _get(stored, 'data.main.temp');
      this.weather.description = _get(stored, 'data.weather[0].description');

      setTimeout(() => this.loading = false, 500);
    },
  },

  filters: {
    capitalize(value) {
      if (!value) {
        return;
      }
      let str = value.toString();
      return str.charAt(0).toUpperCase() + str.slice(1);
    },
    localTimeFromUnixTimestamp(value) {
      if (!value) {
        return;
      }
      return moment.unix(value).format('HH:mm');
    }
  },

  created() {
    this.fetchWeather();
    setInterval(this.fetchWeather, 600000);
  },
}
</script>

<style scoped>
.divider {
  border-left: 1px solid #ccc;
}
</style>
