<div class="comment card mt-3">
  <div class="card-body">
    <h6 class="card-subtitle mb-2 text-muted">
      <a role="button"
         class="btn btn-sm btn-outline-secondary"
         style="cursor: pointer"
         data-toggle="collapse"
         data-target="#collapse-{{ $item->id }}"
      >↕️️</a> @lang('hackernews.by', ['by' => $item->by]),
      <small class="text-muted">{{ \Illuminate\Support\Carbon::create($item->created_at)->diffForHumans() }}</small>
    </h6>

    <div id="collapse-{{ $item->id }}" class="collapse show">
      <p class="card-text">{!! $item->text !!}</p>
      @foreach(data_get($item, 'sub', []) as $sub)
        @component('hackernews.comment', ['item' => $sub])@endcomponent
      @endforeach
    </div>
  </div>
</div>
