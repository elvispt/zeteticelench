<div class="bookmark-manual">
  <a href="#"
     data-toggle="collapse"
     data-target="#collapse-manual-bookmark"
     class="pl-3"
  >@lang('hackernews.add_bookmark_by_id')</a>
  <div id="collapse-manual-bookmark" class="collapse">
    <form action="{{ route('hackernews-bookmark-manual-add') }}"
          method="post"
          class="form-inline"
    >
      @csrf
      <label class="sr-only" for="story-id">@lang('hackernews.bookmark_id')</label>
      <input type="number"
             class="form-control"
             id="story-id"
             name="story-id"
             min="1" step="1"
             placeholder="@lang('hackernews.bookmark_id')"
      >
      <button type="submit" class="btn btn-primary ml-3">@lang('hackernews.bookmark')</button>
    </form>
  </div>
</div>
