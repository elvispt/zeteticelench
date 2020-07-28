<template>
  <div id="expenses-list">
    <div class="row">
      <div class="col-12 mt-3 no-gutter-xs">
        <div v-loading="loading">
          <el-table
            style="width: 100%"
            :data="expensesList"
            show-summary
            :summary-method="getSummaries"
            :empty-text="$I18n.trans('expenses.failed_to_obtain_expenses')"
          >
            <el-table-column
              prop="description"
              min-width="250"
              :label="$I18n.trans('expenses.what')"
            ></el-table-column>
            <el-table-column
              prop="updated_at"
              :formatter="formatDate"
              min-width="220"
              :label="$I18n.trans('expenses.when')"
            ></el-table-column>
            <el-table-column
              prop="amount"
              align="right"
              width="100"
              :label="$I18n.trans('expenses.amount')"
              :formatter="formatCurr"
              fixed="right"
            ></el-table-column>
          </el-table>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import { mapGetters, mapActions } from 'vuex';
import numeral from 'numeral';
import moment from 'moment';

export default {
  name: "ExpensesList",

  data() {
    return {
      loading: true,
    };
  },

  computed: mapGetters(['expensesList']),

  methods: {
    ...mapActions(['fetchExpenses']),
    getSummaries({columns, data}) {
      const sums = [];

      columns.forEach((col, index) => {
        if (index === 0) {
          sums[index] = this.$I18n.trans('expenses.total');
        } else if (index === 1) {
          sums[index] = '';
        } else {
          const values = data.map(item => Number(item[col.property]));
          const summed = values.reduce((prev, curr) => {
            const value = Number(curr);

            return isNaN(value) ? prev : prev + curr;
          }, 0);
          sums[index] = numeral(summed).format('$ 0,0[.]00')
        }
      });

      return sums;
    },
    formatCurr(row, col, cellValue, index) {
      return numeral(Number(cellValue)).format('$ 0,0[.]00');
    },
    formatDate(row, col, cellValue, index) {
      const objDate = moment(cellValue);
      const date = objDate.format('YYYY-MM-DD');
      const diff = objDate.fromNow();
      return `${diff} on ${date}`;
    },
  },

  mounted() {
    this.fetchExpenses().then(res => this.loading = false);
  },
}
</script>
