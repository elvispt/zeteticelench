<template>
  <div id="navigation">
    <div class="row justify-content-center top-submenu">
      <div class="col-12 no-gutter-xs">
        <div class="btn-group d-flex mb-2">
          <router-link
            :to="expensesRoute"
            class="btn btn-group-sm w-100 inner-nav btn-secondary"
          >{{ $I18n.trans('expenses.expenses') }}</router-link>
          <router-link
            :to="expensesCreateRoute"
            class="btn btn-group-sm w-100 inner-nav btn-secondary"
          >{{ $I18n.trans('expenses.new_expense') }}</router-link>
        </div>
      </div>
    </div>
  </div>
</template>

<script>
import {
  ExpensesCreateRoute,
  ExpensesRoute
} from "../../router";

export default {
  name: "Navigation",

  data() {
    return {
      expensesRoute: ExpensesRoute,
      expensesCreateRoute: ExpensesCreateRoute,
    };
  },
}
</script>
