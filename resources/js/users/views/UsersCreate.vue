<template>
  <div id="users-create">
    <div class="row">
      <div class="col-12 mt-3 no-gutter-xs">
        <el-form ref="refCreateUserForm" :model="user" :rules="rules">
          <el-form-item :label="$I18n.trans('users.name')" prop="name">
            <el-input v-model="user.name"></el-input>
          </el-form-item>
          <el-form-item :label="$I18n.trans('users.email')" prop="email">
            <el-input v-model="user.email" type="email" autocomplete="off"></el-input>
          </el-form-item>
          <el-form-item :label="$I18n.trans('users.password')" prop="password">
            <el-input v-model="user.password" type="password" autocomplete="off"></el-input>
          </el-form-item>
          <el-form-item>
            <el-button
              type="primary"
              @click="createUser('refCreateUserForm')"
            >{{ $I18n.trans('users.create') }}</el-button>
          </el-form-item>
        </el-form>
      </div>
    </div>
  </div>
</template>

<script>
import axios from "axios";
import _get from "lodash.get";
import {UsersRoute} from "../../router";

export default {
  name: "UsersCreate",

  data() {
    return {
      rules: {
        name: [
          {
            required: true,
            message: this.$I18n.trans('users.name_cannot_be_empty'),
            trigger: 'blur',
          },
          {
            min: 2,
            max: 255,
            message: this.$I18n.trans('users.min_2_max_255'),
            trigger: 'blur',
          },
        ],
        email: [
          {
            required: true,
            type: 'email',
            message: this.$I18n.trans('users.please_set_valid_email'),
            trigger: 'blur',
          },
        ],
        password: [
          {
            required: true,
            message: this.$I18n.trans('users.please_set_valid_password'),
            trigger: 'blur'
          },
          {
            min: 12,
            max: 100,
            message: this.$I18n.trans('users.please_set_valid_password'),
            trigger: 'blur',
          },
        ],
      },
      user: {
        name: '',
        email: '',
        password: '',
      },
    };
  },

  methods: {
    submitForm(formRef) {
      this.$refs[formRef].validate((valid) => {
        if (valid) {
          this.createUser();
          return true;
        } else {
          return false;
        }
      });
    },
    async createUser() {
      let response;

      try {
        response = await axios.post('/api/users/create', this.user);
      } catch (err) {
        console.error(err);
      }
      this.notifyActionSuccess(response)
    },
    notifyActionSuccess(response, successMessageKey = 'users.user_create', failureMessageKey = 'users.failed_to_create') {
      const status = _get(response, 'status');
      const success = _get(response, 'data.data.success', false);
      if (status === 200 && success) {
        this.$message.success(this.$I18n.trans(successMessageKey));
        this.$router.push(UsersRoute);
      } else {
        this.$message.error(this.$I18n.trans(failureMessageKey));
      }
    },
  },
}
</script>
