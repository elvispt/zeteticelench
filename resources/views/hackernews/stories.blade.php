@extends('layouts/app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <ul class="list-group">
          @foreach($stories as $index => $story)
            <li class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <a href="{{ data_get($story, 'url', '#') }}" target="story-{{$index}}" class="text-body">{{ $story->title }}</a>
                <span class="badge">{{ \Illuminate\Support\Carbon::make($story->created_at)->diffForHumans() }}</span>
              </div>
              <small class="text-muted">@lang('hackernews.points', ['points' => $story->score])</small>
              |
              <a href="{{ route('hackernews-item', ['id' => $story->id]) }}"><small>@lang('hackernews.comments', ['comments' => data_get($story, 'descendants', '-')])</small></a>
              |
              <a href="{{ sprintf($hnPostUrlFormat, $story->id) }}"
                 target="hncomments-{{ $story->id }}"
                 class="text-info"
              ><small>@lang('hackernews.hnpost')</small></a>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
@endsection
