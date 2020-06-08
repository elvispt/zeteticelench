import Vue from "vue";
import { router, AuthenticateRoute } from './router';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import "./filters";
import I18n from "./vendor/I18n";
import MainNavigation from "./components/MainNavigation";
import axios from "axios";

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// You only need to register components that are injected into a Blade template
Vue.component('main-navigation', MainNavigation);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(ElementUI);
Vue.prototype.$I18n = new I18n;

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;
// redirect automatically when requests lose authorization
axios.interceptors.response.use(
  null,
  (err) => {
    if (err.response) {
      if (err.response.status === 401 || err.response.status === 419) {
        app.$router.push(AuthenticateRoute);
      }
    } else {
      console.error(`Unknown error: ${err}`);
    }
  }
);

const app = new Vue({
  router,
  el: '#app'
});
