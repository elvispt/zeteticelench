<div class="row justify-content-center top-submenu">
  <div class="col-12 text-center">
    <div class="btn-group d-flex mb-2">
      <a
        class="btn btn-group-sm w-100 text-nowrap @submenuactive('hackernews-top')"
        href="{{ route('hackernews-top') }}"
      >@lang('hackernews.top')</a>
      <a
        class="btn btn-group-sm w-100 text-nowrap @submenuactive('hackernews-best')"
        href="{{ route('hackernews-best') }}"
      >@lang('hackernews.best')</a>
      <a
        class="btn btn-group-sm w-100 text-nowrap @submenuactive('hackernews-new')"
        href="{{ route('hackernews-new') }}"
      >@lang('hackernews.new')</a>
      <a
        class="btn btn-group-sm w-100 text-nowrap @submenuactive('hackernews-bookmark-list')"
        href="{{ route('hackernews-bookmark-list') }}"
      >@lang('hackernews.bookmarked')&nbsp;<span id="bookmark-count" class="badge badge-light">{{ $nBookmarkedStories }}</span></a>
      <a
        class="btn btn-group-sm w-100 text-nowrap @submenuactive('hackernews-jobs')"
        href="{{ route('hackernews-jobs') }}"
      >@lang('hackernews.jobs')</a>
    </div>
  </div>
</div>
