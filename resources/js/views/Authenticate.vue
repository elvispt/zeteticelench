<template>
  <div id="view-authenticate" class="pt-4">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow">
          <div class="card-header">{{ $I18n.trans('auth.login') }}</div>

          <div class="card-body">
            <form method="POST" @submit="attemptLogin($event)" :model="user">
              <div class="form-group row">
                <label
                  for="email"
                  class="col-md-4 col-form-label text-md-right"
                >{{ $I18n.trans('auth.email') }}</label>

                <div class="col-md-6">
                  <input id="email"
                         inputmode="email"
                         type="email"
                         v-model="user.email"
                         class="form-control"
                         name="email"
                         autocomplete="email"
                         required
                         >
                </div>
              </div>

              <div class="form-group row">
                <label
                  for="password"
                  class="col-md-4 col-form-label text-md-right"
                >{{ $I18n.trans('auth.password') }}</label>

                <div class="col-md-6">
                  <input
                    id="password"
                    name="password"
                    type="password"
                    v-model="user.password"
                    class="form-control"
                    @change="passwordChanged"
                    autocomplete="current-password"
                    ref="pwf"
                    required
                    >
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                    <input
                      class="form-check-input"
                      type="checkbox"
                      name="remember"
                      id="remember"
                      checked
                    >
                    <label
                      class="form-check-label"
                      for="remember"
                    >{{ $I18n.trans('auth.remember_me') }}</label>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button
                    type="submit"
                    class="btn btn-primary"
                    :disabled="!user.email && !user.password"
                  >{{ $I18n.trans('auth.login') }}</button>
                </div>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import _get from "lodash.get";
import { DashboardRoute } from "../router";

export default {
  name: "Authenticate",

  data() {
    return {
      user: {
        email: '',
        password: '',
      },
      pollingPasswordFieldInterval: null,
      errorMessage: null,
    };
  },

  methods: {
    /**
     * Due to issue with autofill (from browser's password manager),
     * we have to poll changes to the password field since vue.js does
     * not detect the changes causing the password field to be sent
     * empty.
     */
    pollingPasswordField() {
      this.pollingPasswordFieldInterval = setInterval(() => {
        let event = document.createEvent('HTMLEvents');
        event.initEvent('change', false, true);
        this.$refs.pwf.dispatchEvent(event);
      }, 500);
    },
    passwordChanged() {
      this.user.password = this.$refs.pwf.value;
    },

    async attemptLogin(event) {
      event.preventDefault();

      await axios.post('/logout');
      await axios.get('/sanctum/csrf-cookie');
      await this.login();
    },
    async login() {
      const loginFailedStatusCode = 422;
      const loginSuccessStatusCode = 302;
      const config = {
        validateStatus: status => {
          return (status >= 200 && status < 300)
            || status === loginFailedStatusCode
            || status === loginSuccessStatusCode;
        }
      };

      const response = await axios.post('/login', this.user, config);
      const status = response.status;

      if (status === loginFailedStatusCode) {
        this.showsErrors(_get(response, 'data.errors'));
      } else if (status === loginSuccessStatusCode || status === 204) {
        clearInterval(this.pollingPasswordFieldInterval);
        this.$message.success('Login successful');
        await this.$router.push(DashboardRoute);
      }
    },
    showsErrors(errors) {
      let message = '';
      Object.keys(errors).forEach(key => {
        errors[key].forEach(msg => {
          message += msg + '<br/>';
        });
      });
      this.$message({
        type: 'error',
        dangerouslyUseHTMLString: true,
        message,
      });
    },
  },

  mounted() {
    this.pollingPasswordField();
  }
}
</script>
