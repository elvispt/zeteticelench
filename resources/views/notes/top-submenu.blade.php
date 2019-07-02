<div class="row justify-content-center top-submenu">
  <div class="col-12">
    <div class="btn-group d-flex mb-2">
      <a
        class="btn btn-group-sm w-100 @submenuactive('notes')"
        href="{{ route('notes') }}"
      >@lang('notes.notes')</a>
      <a
        class="btn btn-group-sm w-100 @submenuactive('notesCreate')"
        href="{{ route('notesCreate') }}"
      >@lang('notes.new-note')</a>
      <a
        class="btn btn-group-sm w-100 @submenuactive('notesTags')"
        href="{{ route('notesTags') }}"
      >@lang('notes.tags')</a>

      <a
        class="btn btn-group-sm w-100 @submenuactive('notesTagsCreate')"
        href="{{ route('notesTagsCreate') }}"
      >@lang('notes.new-tag')</a>
    </div>
  </div>
</div>
