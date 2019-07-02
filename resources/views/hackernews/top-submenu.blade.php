<div class="row justify-content-center top-submenu">
  <div class="col-12 text-center">
    <div class="btn-group d-flex mb-2">
      @php $currentRouteName = Route::currentRouteName(); @endphp
      <a
        class="btn btn-group-sm w-100 {{ $currentRouteName === 'hackernews-top' ? 'btn-primary' : 'btn-secondary'}}"
        href="{{ route('hackernews-top') }}"
      >@lang('hackernews.top')</a>
      <a
        class="btn btn-group-sm w-100 {{ $currentRouteName === 'hackernews-best' ? 'btn-primary' : 'btn-secondary'}}"
        href="{{ route('hackernews-best') }}"
      >@lang('hackernews.best')</a>
      <a
        class="btn btn-group-sm w-100 {{ $currentRouteName === 'hackernews-new' ? 'btn-primary' : 'btn-secondary'}}"
        href="{{ route('hackernews-new') }}"
      >@lang('hackernews.new')</a>
      <a
        class="btn btn-group-sm w-100 {{ $currentRouteName === 'hackernews-bookmark-list' ? 'btn-primary' : 'btn-secondary'}}"
        href="{{ route('hackernews-bookmark-list') }}"
      >@lang('hackernews.bookmarked')</a>
      <a
        class="btn btn-group-sm w-100 {{ $currentRouteName === 'hackernews-jobs' ? 'btn-primary' : 'btn-secondary'}}"
        href="{{ route('hackernews-jobs') }}"
      >@lang('hackernews.jobs')</a>
    </div>
  </div>
</div>
