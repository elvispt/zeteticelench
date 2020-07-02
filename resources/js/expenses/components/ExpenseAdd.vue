<template>
  <div class="add-expense">
    <el-form
      :inline="true"
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
          v-model.number="expense.amount"
          clearable
          min="0"
          step="0.01"
        ></el-input>
      </el-form-item>
      <el-form-item>
        <el-button
          type="primary"
          @click="onSubmit('refExpenseForm')"
        >{{ $I18n.trans('common.add') }}</el-button>
      </el-form-item>
    </el-form>
  </div>
</template>

<script>
import { mapActions } from 'vuex';

export default {
  name: "ExpenseAdd",

  data() {
    return {
      expense: {
        description: null,
        amount: null,
      },
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
            type: 'number',
            message: this.$I18n.trans('expenses.please_set_valid_amount'),
            trigger: 'change',
          },
        ],
      },
    };
  },

  methods: {
    ...mapActions(['addExpense']),
    onSubmit(ref) {
      this.$refs[ref].validate((valid) => {
        if (valid) {
          this.createExpense();
          return true;
        } else {
          return false;
        }
      });
    },
    async createExpense() {
      const success = await this.addExpense(this.expense);
      let notification;
      if (success) {
        const message = this.$I18n.trans('expenses.success_expense_added');
        notification = this.$notify.success(message);
        this.expense.description = '';
        this.expense.amount = '';
      } else {
        const message = this.$I18n.trans('expenses.fail_expense_added');
        notification = this.$notify.error(message);
      }
    }
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
