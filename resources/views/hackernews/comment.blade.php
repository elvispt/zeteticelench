<div class="comment card mt-3">
  <div class="card-body">
    <h6 class="card-subtitle mb-2 text-muted">
      @lang('hackernews.by', ['by' => $item->by]),
      <small class="text-muted">{{ \Illuminate\Support\Carbon::create($item->created_at)->diffForHumans() }}</small>
    </h6>

    <p class="card-text">{!! $item->text !!}</p>
    @foreach(data_get($item, 'sub', []) as $sub)
      @component('hackernews.comment', ['item' => $sub])@endcomponent
    @endforeach
  </div>
</div>
