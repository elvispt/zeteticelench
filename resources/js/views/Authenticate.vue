<template>
  <div id="view-authenticate" class="pt-4">
    <div class="row justify-content-center">
      <div class="col-md-8">
        <div class="card shadow">
          <div class="card-header">Login</div>

          <div class="card-body">
            <form method="POST" @submit="attemptLogin($event)">
              <div class="form-group row">
                <label for="email" class="col-md-4 col-form-label text-md-right">E-Mail Address</label>

                <div class="col-md-6">
                  <input id="email"
                         inputmode="email"
                         type="email"
                         v-model="user.email"
                         class="form-control"
                         name="email" required autocomplete="email"
                         autofocus>
                </div>
              </div>

              <div class="form-group row">
                <label for="password" class="col-md-4 col-form-label text-md-right">Password</label>

                <div class="col-md-6">
                  <input id="password" type="password"
                         v-model="user.password"
                         class="form-control" name="password"
                         required autocomplete="current-password">
                </div>
              </div>

              <div class="form-group row">
                <div class="col-md-6 offset-md-4">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" name="remember"
                           id="remember" checked>

                    <label class="form-check-label" for="remember">Remember Me</label>
                  </div>
                </div>
              </div>

              <div class="form-group row mb-0">
                <div class="col-md-8 offset-md-4">
                  <button type="submit" class="btn btn-primary">Login</button>
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
        email: 'dev@mail.com',
        password: '123',
      },
      errorMessage: null,
    };
  },

  methods: {
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
        this.$message.error(_get(response, 'data.errors.email.0'));
      } else if (status === loginSuccessStatusCode || status === 204) {
        this.$message.success('Login successful');
        await this.$router.push(DashboardRoute);
      }
    }
  },
}
</script>
