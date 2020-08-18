<template>
  <div class="expenses-add">
    <div class="row">
      <div class="col-12 mt-3 no-gutter-xs">
        <el-form
          :model="expense"
          :rules="rules"
          ref="refExpenseForm"
        >
          <el-form-item :label="$I18n.trans('expenses.what')" prop="description">
            <el-input
              v-model="expense.description"
              clearable
            ></el-input>
          </el-form-item>
          <el-form-item :label="$I18n.trans('expenses.amount')" prop="amount">
            <el-input
              type="number"
              inputmode="decimal"
              decimal="true"
              v-model.number="expense.amount"
              clearable
              min="0"
              step="0.01"
            ></el-input>
          </el-form-item>
          <el-form-item :label="$I18n.trans('expenses.at')" prop="transactionDate">
            <el-date-picker
              v-model="expense.transactionDate"
              type="datetime"
              format="d MMM yyyy @ HH:mm"
              value-format="yyyy-MM-dd HH:mm:ss"
              :picker-options="datetimePickerOptions"
            ></el-date-picker>
          </el-form-item>
          <div class="text-right">
          <el-form-item>
            <el-button
              @click="goBackToListing('refExpenseForm')"
            >{{ $I18n.trans('common.cancel') }}</el-button>
            <el-button
              type="danger"
            >{{ $I18n.trans('common.delete') }}</el-button>
            <el-button
              type="primary"
              @click="onSubmit('refExpenseForm')"
            >{{ $I18n.trans('common.update') }}</el-button>
          </el-form-item>
          </div>
        </el-form>
      </div>
    </div>
  </div>
</template>

<script>
import { mapActions, mapGetters } from 'vuex';
import {ExpensesRoute} from "../../router";

export default {
  name: "ExpensesUpdate",

  props: ["id"],

  computed: {
    ...mapGetters(['expense']),
  },

  data() {
    return {
      rules: {
        description: [
          {
            required: true,
            message: this.$I18n.trans('expenses.expense_description_required'),
            trigger: 'change',
          },
          {
            min: 2,
            max: 255,
            message: this.$I18n.trans('expenses.min_2_max_255'),
            trigger: 'change',
          },
        ],
        amount: [
          {
            required: true,
            message: this.$I18n.trans('expenses.amount_is_required'),
            trigger: 'change',
          },
          {
            type: 'regexp',
            pattern: '/^\\d*\\.?\\d*$/',
            message: this.$I18n.trans('expenses.please_set_valid_amount'),
            trigger: 'change',
          },
        ],
        transactionDate: [
          {
            required: true,
            message: this.$I18n.trans('expenses.expense_date_required'),
          },
        ],
      },
      datetimePickerOptions: {
        shortcuts: [
          {
            text: this.$I18n.trans('expenses.yesterday'),
            onClick(picker) {
              const date = new Date();
              date.setTime(date.getTime() - 86400000);
              picker.$emit('pick', date);
            }
          },
        ],
      },
    };
  },

  methods: {
    ...mapActions(['updateExpense', 'fetchExpense', 'clearCurrentExpense']),
    async onSubmit(ref) {
      this.$refs[ref].validate(async (valid) => {
        if (valid) {
          await this.updtExp();
          this.resetForm(ref);
          this.goBackToListing();
          return true;
        } else {
          return false;
        }
      });
    },
    async updtExp() {
      const success = await this.updateExpense({
        id: this.expense.id,
        amount: this.expense.amount,
        description: this.expense.description,
        transactionDate: this.expense.transactionDate,
      });
      let notification;
      if (success) {
        const message = this.$I18n.trans('expenses.success_expense_updated');
        notification = this.$notify.success(message);
      } else {
        const message = this.$I18n.trans('expenses.fail_expense_updated');
        notification = this.$notify.error(message);
      }
    },
    resetForm(formName) {
      this.$refs[formName].resetFields();
    },
    async goBackToListing(formName) {
      this.resetForm(formName);
      await this.$router.push(ExpensesRoute);
    },
  },

  async mounted() {
    await this.fetchExpense(this.id);
  },
}
</script>

<style scoped>
/* Chrome, Safari, Edge, Opera */
>>> input::-webkit-outer-spin-button,
>>> input::-webkit-inner-spin-button {
  -webkit-appearance: none;
  margin: 0;
}

/* Firefox */
>>> input[type=number] {
  -moz-appearance: textfield;
}
</style>
