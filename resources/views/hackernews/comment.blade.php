<div class="comment card mt-3">
  <div class="card-body px-2 px-md-3 shadow">
    <h6 class="card-subtitle mb-2 text-muted">
      <a role="button"
         class="btn btn-sm btn-outline-secondary"
         style="cursor: pointer"
         data-toggle="collapse"
         data-target="#collapse-{{ $item->id }}"
      >↕️️</a>
      <span class="{{ $op === $item->by ? 'text-success' : '' }}">@lang('hackernews.by', ['by' => $item->by]),</span>
      <small class="text-muted">{{ \Illuminate\Support\Carbon::create($item->created_at)->diffForHumans() }}</small>
    </h6>

    <div id="collapse-{{ $item->id }}" class="collapse show">
      <p class="card-text">{!! $item->text !!}</p>
      @foreach(data_get($item, 'sub', []) as $sub)
        @component('hackernews.comment', ['item' => $sub, 'op' => $op])@endcomponent
      @endforeach
    </div>
  </div>
</div>
