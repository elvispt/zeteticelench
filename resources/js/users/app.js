import "../bootstrap";
import Vue from "vue";
import I18n from "../vendor/I18n";
import MainNavigation from "../components/MainNavigation";

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

Vue.prototype.$I18n = new I18n;

new Vue({
  el: '#app'
});
