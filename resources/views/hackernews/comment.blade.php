<div class="comment card mt-3">
  <div class="card-body px-2 px-md-3 shadow {{ in_array($item->id, $collapsedComments) ? 'opacity-5' : '' }}">
    <h6 class="card-subtitle mb-2 text-muted">
      <a role="button"
         class="btn btn-sm btn-outline-secondary {{ in_array($item->id, $collapsedComments) ? 'collapsed' : '' }}"
         style="cursor: pointer"
         data-toggle="collapse"
         data-item-id="{{ $item->id }}"
         data-target="#collapse-{{ $item->id }}"
      >↕️️</a>
      <span class="{{ $op === $item->by ? 'text-success' : (in_array($item->by, ['dang', 'sctb']) ? 'text-danger' : '') }}"
      >@lang('hackernews.by', ['by' => $item->by]),</span>
      <small class="text-muted">{{ \Illuminate\Support\Carbon::create($item->created_at)->diffForHumans() }}</small>
    </h6>

    <div id="collapse-{{ $item->id }}" class="collapse {{ in_array($item->id, $collapsedComments) ? '' : 'show' }}">
      <p class="card-text">{!! $item->text !!}</p>
      @foreach(data_get($item, 'sub', []) as $sub)
        @component('hackernews.comment', [
          'item' => $sub,
          'op' => $op,
          'collapsedComments' => $collapsedComments
          ])@endcomponent
      @endforeach
    </div>
  </div>
</div>
