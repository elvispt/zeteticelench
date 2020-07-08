import Vue from "vue";
import store from './store';
import { router } from './router';
import ElementUI from 'element-ui';
import 'element-ui/lib/theme-chalk/index.css';
import locale from 'element-ui/lib/locale/lang/en';
import "./filters";
import I18n from "./vendor/I18n";
import { rtdbPlugin } from 'vuefire';
import MainNavigation from "./components/MainNavigation";
import axios from "axios";
import numeral from 'numeral';
import 'numeral/locales/pt-pt';

numeral.locale('pt-pt');

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;

/**
 * The following block of code may be used to automatically register your
 * Vue components. It will recursively scan this directory for the Vue
 * components and automatically register them with their "basename".
 *
 * Eg. ./components/ExampleComponent.vue -> <example-component></example-component>
 */

// const files = require.context('./', true, /\.vue$/i);
// files.keys().map(key => Vue.component(key.split('/').pop().split('.')[0], files(key).default));

// You only need to register components here that are injected into a Blade template
Vue.component('main-navigation', MainNavigation);

/**
 * Next, we will create a fresh Vue application instance and attach it to
 * the page. Then, you may begin adding components to this application
 * or customize the JavaScript scaffolding to fit your unique needs.
 */

Vue.use(ElementUI, { locale });
Vue.use(rtdbPlugin);
Vue.prototype.$I18n = new I18n;

const app = new Vue({
  store,
  router,
  el: '#app'
});
