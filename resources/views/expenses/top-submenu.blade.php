<div class="row justify-content-center top-submenu">
  <div class="col-12 text-center">
    <div class="btn-group d-flex mb-2">
      <a
        class="btn btn-group-sm w-100 text-nowrap @submenuactive('movements')"
        href="{{ route('movements') }}"
      >@lang('expenses.movements')</a>

      <a
        class="btn btn-group-sm w-100 text-nowrap @submenuactive('movementsCreate')"
        href="{{ route('movementsCreate') }}"
      >@lang('expenses.movements_create')</a>

      <a
        class="btn btn-group-sm w-100 text-nowrap @submenuactive('expensesAccounts')"
        href="{{ route('expensesAccounts') }}"
      >@lang('expenses.accounts')</a>
    </div>
  </div>
</div>
