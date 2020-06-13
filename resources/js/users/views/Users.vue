<template>
  <div id="users">
    <navigation></navigation>
    <el-table
      v-loading="loading"
      :data="users"
      style="width: 100%"
      :row-class-name="highlightCurrentUser"
      :empty-text="$I18n.trans('users.failed_to_obtain_user_list')"
    >
      <el-table-column
        prop="id"
        label="#"
      ></el-table-column>
      <el-table-column
        prop="name"
        :label="$I18n.trans('users.name')"
      ></el-table-column>
      <el-table-column
        prop="email"
        :label="$I18n.trans('users.email')"
      ></el-table-column>
      <el-table-column
        prop="createdAt"
        :label="$I18n.trans('users.created_at')"
        :formatter="formatCreatedAt"
      ></el-table-column>
      <el-table-column
        prop="updatedAt"
        :label="$I18n.trans('users.updated_at')"
        :formatter="formatUpdatedAt"
      ></el-table-column>
      <el-table-column
        fixed="right"
        align="right"
        width="80"
        prop="updatedAt"
      >
        <template slot-scope="scope">
          <el-button
            @click="editDialogShow(scope.row)"
            type="text"
            size="small"
          >{{ $I18n.trans('users.edit_name') }}</el-button>
        </template>
      </el-table-column>
    </el-table>

    <!-- form -->
    <el-dialog
      :title="$I18n.trans('users.edit_name')"
      :visible.sync="dialogVisible"
    >
      <el-form :model="userToEdit"
               :rules="dialogFormRules"
               ref="formRef"
               @submit.native.prevent
               @submit="editDialogSubmit"
      >
        <el-form-item :label="$I18n.trans('users.name')" prop="name">
          <el-input v-model="userToEdit.name"></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button
          @click="dialogVisible = false"
        >{{ $I18n.trans('common.cancel') }}</el-button>
        <el-button
          type="primary"
          @click="editDialogSubmit('formRef')"
        >{{ $I18n.trans('common.confirm') }}</el-button>
      </span>
    </el-dialog>

  </div>
</template>

<script>
import axios from "axios";
import _get from "lodash.get";
import Navigation from "../components/Navigation";

export default {
  name: "Users",

  components: {
    Navigation,
  },

  data() {
    return {
      loading: true,
      users: [],
      userToEdit: {},
      currentUserId: null,
      dialogVisible: false,
      dialogFormRules: {
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
      },
    };
  },

  methods: {
    async fetchUsers() {
      const response = await axios.get('/api/users');
      this.users = _get(response, 'data.data.users', []);
      this.currentUserId = _get(response, 'data.data.currentUserId', []);
      this.loading = false;
    },
    highlightCurrentUser({ row, rowIndex }) {
      return row.id === this.currentUserId ? 'table-success' : null;
    },
    formatDate(value) {
      return this.$options.filters.diffForHumans(value);
    },
    formatCreatedAt(row, column) {
      return this.formatDate(row.createdAt);
    },
    formatUpdatedAt(row, column) {
      return this.formatDate(row.updatedAt);
    },
    editDialogShow(user) {
      this.userToEdit = {
        id: user.id,
        name: user.name,
      };
      this.dialogVisible = true;
    },
    editDialogSubmit(formRef) {
      this.$refs[formRef].validate((valid) => {
        if (valid) {
          this.updateUser();
          return true;
        } else {
          return false;
        }
      });
    },
    async updateUser() {
      let response;
      try {
        response = await axios.put('/api/users/update', this.userToEdit);
      } catch (err) {
        console.error(err);
        this.$message.error(this.$I18n.trans('users.failed_to_update'));
        return;
      }
      this.notifyUser(response);
    },
    notifyUser(response) {
      const status = _get(response, 'status');
      const success = _get(response, 'data.data.success', false);
      if (status === 200 && success) {
        this.$message.success(this.$I18n.trans('users.user_updated'));
        const user = this.users.find(user => user.id === this.userToEdit.id);
        user.name = this.userToEdit.name.trim();
        this.dialogVisible = false;
      } else {
        this.$message.error(this.$I18n.trans('users.failed_to_update'));
      }
    },
  },

  created() {
    this.fetchUsers();
  },
}
</script>

<style scoped>
  #users >>> .el-table .success-row {
    background: #f0f9eb;
  }
</style>
