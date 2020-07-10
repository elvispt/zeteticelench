<template>
  <div id="users-list">
    <div class="row">
      <div class="col-12 mt-3 no-gutter-xs">
        <el-table
          v-loading="loading"
          :data="usersList"
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
            prop="updatedAt"
            :label="$I18n.trans('users.updated_at')"
            :formatter="formatUpdatedAt"
          ></el-table-column>
          <el-table-column
            fixed="right"
            align="right"
            width="60"
            prop="updatedAt"
          >
            <template slot-scope="scope">
              <el-button
                @click="editDialogShow(scope.row)"
                type="text"
                size="small"
              >{{ $I18n.trans('users.edit') }}</el-button>
            </template>
          </el-table-column>
        </el-table>
      </div>
    </div>

    <!-- form -->
    <el-dialog
      :title="$I18n.trans('users.user_edit', {id: userToEdit.id || ''})"
      :visible.sync="dialogVisible"
    >
      <el-form :model="userToEdit"
               :rules="dialogFormRules"
               ref="formRef"
               @submit.native.prevent
               @submit="editDialogSubmit"
      >
        <el-form-item :label="$I18n.trans('users.name')" prop="name">
          <el-input
            v-model="userToEdit.name"
            :placeholder="$I18n.trans('users.name_cannot_be_empty')"
          ></el-input>
        </el-form-item>
        <el-form-item :label="$I18n.trans('users.password')" prop="password">
          <el-input
            type="password"
            autocomplete="off"
            v-model="userToEdit.password"
          ></el-input>
        </el-form-item>
        <el-form-item :label="$I18n.trans('users.email')">
          <el-input type="email" :value="userToEdit.email" disabled></el-input>
        </el-form-item>
      </el-form>
      <span slot="footer" class="dialog-footer">
        <el-button
          @click="closeDialog('formRef')"
        >{{ $I18n.trans('common.cancel') }}</el-button>
        <el-button
          type="danger"
          :disabled="userToEdit.id === currentUserId"
          @click="deleteUser()"
        >{{ $I18n.trans('users.delete') }}</el-button>
        <el-button
          type="primary"
          @click="editDialogSubmit('formRef')"
        >{{ $I18n.trans('common.confirm') }}</el-button>
      </span>
    </el-dialog>

  </div>
</template>

<script>
import { mapActions, mapGetters } from "vuex";

export default {
  name: "Users",

  data() {
    return {
      loading: true,
      userToEdit: {},
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
        password: [
          {
            min: 12,
            max: 100,
            message: this.$I18n.trans('users.please_set_valid_password'),
            trigger: 'blur',
          },
        ]
      },
    };
  },

  computed: mapGetters(['usersList', 'currentUserId']),

  methods: {
    ...mapActions(['fetchUsers', 'updateUser', 'destroyUser']),
    highlightCurrentUser({ row, rowIndex }) {
      return row.id === this.currentUserId ? 'table-success' : null;
    },
    formatDate(value) {
      return this.$options.filters.diffForHumans(value);
    },
    formatUpdatedAt(row, column) {
      return this.formatDate(row.updatedAt);
    },
    closeDialog(formRef) {
      this.dialogVisible = false;
      this.$refs[formRef].resetFields();
    },
    editDialogShow(user) {
      this.userToEdit = {
        id: user.id,
        name: user.name,
        email: user.email,
      };
      this.dialogVisible = true;
    },
    async editDialogSubmit(formRef) {
      const isValid = await this.validateDialogSubmit(formRef);
      if (isValid) {
        const updateData = {
          id: this.userToEdit.id,
          name: this.userToEdit.name,
        };
        if (this.userToEdit.password) {
          updateData.password = this.userToEdit.password;
        }
        const success = await this.updateUser(updateData);
        this.notifyActionSuccess(success);
      }
    },
    async validateDialogSubmit(formRef) {
      return new Promise((resolve, reject) => {
        this.$refs[formRef].validate((valid) => {
          return valid ? resolve(true) : reject(false);
        });
      });
    },
    notifyActionSuccess(success, successMessageKey = 'users.user_updated', failureMessageKey = 'users.failed_to_update') {
      if (success) {
        this.$message.success(this.$I18n.trans(successMessageKey));
        const user = this.usersList.find(user => user.id === this.userToEdit.id);
        if (user) {
          user.name = this.userToEdit.name.trim();
        }
        this.dialogVisible = false;
      } else {
        this.$message.error(this.$I18n.trans(failureMessageKey));
      }
    },
    async deleteUser() {
      let userConfirmsDeleteRequest = await this.askUserToConfirmDelete();

      if (userConfirmsDeleteRequest) {
        const success = await this.destroyUser(this.userToEdit.id);
        this.notifyActionSuccess(success, 'users.delete_success', 'users.failed_to_delete');
      }
    },
    async askUserToConfirmDelete() {
      let isConfirmed;
      try {
        isConfirmed = await this.$confirm(
          this.$I18n.trans('users.confirm_delete_request', { name: this.userToEdit.name }),
          this.$I18n.trans('common.please_confirm'),
          {
            confirmButtonText: this.$I18n.trans('users.delete'),
            cancelButtonText: this.$I18n.trans('common.cancel'),
            type: 'warning',
          }) === 'confirm';
      } catch (err) {
        isConfirmed = false;
      }
      return isConfirmed;
    },
  },

  created() {
    this.fetchUsers()
      .then(res => this.loading = false);
  },
}
</script>

<style scoped>
  #users-list >>> .el-table .success-row {
    background: #f0f9eb;
  }
  @media (max-width: 575px) {
    #users-list >>> .el-dialog {
      width: 100%;
    }
  }
</style>
