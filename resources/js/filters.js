import Vue from "vue";
import moment from "moment";

/**
 * Receives a date and returns a string in the style of
 * "8 hours ago" or "1 year ago"
 */
Vue.filter("diffForHumans", value => {
  if (!value) {
    return;
  }
  return moment(value, 'YYYY-MM-DD hh:mm:ss')
    .fromNow();
});

/**
 * Receives an url and return the domain
 */
Vue.filter('domainFromUrl', value => {
  if (!value) {
    return;
  }
  const domain = new URL(value).hostname;

  return domain.replace("www.", "");
});
