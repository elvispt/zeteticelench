@extends('layouts/app')

@section('title') @lang($title) @endsection

@section('meta')
  <meta name="route-hackernews-bookmark-add" content="{{ route('hackernews-bookmark-destroy') }}">
  <meta name="route-hackernews-bookmark-destroy" content="{{ route('hackernews-bookmark-add') }}">
@endsection

@section('content')
  <div class="container">
    @include('hackernews.top-submenu')
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
                      <small class="text-muted">({{ $story->domain }})</small>
                    </a>
                  @endif
                </span>
                <span class="d-block d-md-none">
                  <a href="#"
                     data-story-id="{{ $story->id }}"
                     data-bookmarked="{{ $story->bookmarked ? 'true' : 'false' }}"
                     class="bookmark-story"
                  >{{ $story->bookmarked ? "⚫" : "⚪️" }}</a>
                </span>
                <span class="badge d-none d-md-block">{{ \Illuminate\Support\Carbon::make($story->created_at)->diffForHumans() }}</span>
              </div>
              <div class="d-none d-md-block">
                <small class="text-muted">@lang('hackernews.points', ['points' => $story->score])</small>
                |
                <a href="{{ sprintf($hnPostUrlFormat, $story->id) }}"
                   target="hncomments-{{ $story->id }}"
                   class="text-info"
                   title="@lang('hackernews.hnpost')"
                ><small>@lang('hackernews.comments', ['comments' => data_get($story, 'descendants', '-')])</small></a>
                |
                <a href="#"
                   data-story-id="{{ $story->id }}"
                   data-bookmarked="{{ $story->bookmarked ? 'true' : 'false' }}"
                   class="bookmark-story"
                >{{ $story->bookmarked ? "⚫" : "⚪️" }}</a>
              </div>
            </li>

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

    <div class="row justify-content-center">
      <div class="col-12">
        @includeWhen($bookmarkStore ?? false, 'hackernews.bookmark-manual')
      </div>
    </div>
    @push('scripts')
      <script src="{{ mix('/js/mods/bookmark.js') }}" defer async></script>
    @endpush
  </div>
@endsection
