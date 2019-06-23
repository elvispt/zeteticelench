@extends('layouts/app')

@section('content')
  <div class="container">

    <div class="row">
      <div class="col-12">
        <ul class="list-group">
          @foreach($stories as $index => $story)
            <li class="list-group-item list-group-item-action flex-column align-items-start">
              <div class="d-flex w-100 justify-content-between">
                <span>
                  <a href="{{ route('hackernews-item', ['id' => $story->id]) }}"
                     class="text-body"
                  >{{ $story->title }}️</a>
                  @if ($story->domain)
                    <a href="{{ data_get($story, 'url', '#') }}"
                       target="story-{{$index}}"
                       class="text-body"
                    >
                      <small class="text-muted">({{ $story->domain }}) [↗]</small>
                    </a>
                  @endif
                </span>
                <span class="badge">{{ \Illuminate\Support\Carbon::make($story->created_at)->diffForHumans() }}</span>
              </div>
              <small class="text-muted">@lang('hackernews.points', ['points' => $story->score])</small>
              |
              <small>@lang('hackernews.comments', ['comments' => data_get($story, 'descendants', '-')])</small>
              |
              <a href="#"
                 onclick="event.preventDefault();document.getElementById('bookmark-{{ $story->id }}').submit();"
              >{{ $story->bookmarked ? trans('hackernews.remove_bookmark') : trans('hackernews.bookmark') }}</a>
              |
              <a href="{{ sprintf($hnPostUrlFormat, $story->id) }}"
                 target="hncomments-{{ $story->id }}"
                 class="text-info"
              ><small>@lang('hackernews.hnpost')</small></a>
            </li>
            <form id="bookmark-{{ $story->id }}" action="{{ route('hackernews-bookmark-add') }}" method="post">
              @csrf
              <input type="hidden" name="story_id" value="{{ $story->id }}">
            </form>
          @endforeach
        </ul>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-12">
        <nav class="mt-3">
          {{ $stories->links() }}
        </nav>
      </div>
    </div>
  </div>
@endsection
