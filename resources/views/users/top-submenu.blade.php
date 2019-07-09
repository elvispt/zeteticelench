<div class="row justify-content-center top-submenu">
  <div class="col-12 text-center">
    <div class="btn-group d-flex mb-2">
      <a
        class="btn btn-group-sm w-100 @submenuactive('users-list')"
        href="{{ route('users-list') }}"
      >@lang('users.users')</a>
      <a
        class="btn btn-group-sm w-100 @submenuactive('users-create')"
        href="{{ route('users-create') }}"
      >@lang('users.new-user')</a>
    </div>
  </div>
</div>
