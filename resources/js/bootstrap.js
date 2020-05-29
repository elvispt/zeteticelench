import * as Sentry from '@sentry/browser';
import axios from "axios";

Sentry.init({ dsn: 'https://50142ad267aa4c7c9dab6ed21262d2ab@sentry.io/1504143' });

/**
 * We'll load the axios HTTP library which allows us to easily issue requests
 * to our Laravel back-end. This library automatically handles sending the
 * CSRF token as a header based on the value of the "XSRF" token cookie.
 */

axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
axios.defaults.withCredentials = true;

/**
 * Next we will register the CSRF Token as a common header with Axios so that
 * all outgoing HTTP requests automatically have it attached. This is just
 * a simple convenience so we don't have to attach every token manually.
 */

let token = document.head.querySelector('meta[name="csrf-token"]');

// use on login page
//axios.get('/sanctum/csrf-cookie');

if (token) {
    axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
    axios.interceptors.response.use(
      null,
      (err) => {
        if (err.response) {
          if (err.response.status === 401 || err.response.status === 419) {
            window.location.replace('/login');
          }
        } else {
          Sentry.captureMessage(err);
          console.error(`Unknown error: ${err}`);
        }
      }
    )
} else {
    const msg = "CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token";
    Sentry.captureMessage(msg);
    console.error(msg);
}
