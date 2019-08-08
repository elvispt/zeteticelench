@extends('layouts/app')

@section('title') {{ $story->title }} @endsection

@section('meta')
  <meta name="route-hackernews-bookmark-add"
        content="{{ route('hackernews-bookmark-destroy') }}">
  <meta name="route-hackernews-bookmark-destroy"
        content="{{ route('hackernews-bookmark-add') }}">
  <meta name="route-hackernews-item-comments-collapse"
        content="{{ route('hackernews-item-comments-collapse', ['id' => $story->id]) }}">
@endsection

@section('content')
  <div class="container">

    @include('hackernews.top-submenu')

    <div class="row">
      <div class="col-12">
        <p class="lead">
          {{ $story->title }}
          @if ($story->domain)
            <a href="{{ data_get($story, 'url', '#') }}"
               target="story-{{ $story->id }}"
               class="text-body"
            >
              <small class="text-muted">({{ $story->domain }}) [↗]</small>
            </a>
          @endif
        </p>
        @if (data_get($story, 'text'))
          <p>{!! $story->text !!}</p>
        @endif
        <small class="text-muted">@lang('hackernews.points', ['points' => $story->score])</small>
        <span class="text-muted">|</span>
        <a href="{{ sprintf($hnPostUrlFormat, $story->id) }}"
           target="hncomments-{{ $story->id }}"
           class="text-info"
        ><small>@lang('hackernews.comments', ['comments' => $story->descendants])</small></a>
        <span class="text-muted">|</span>
        <small class="text-muted">{{ \Illuminate\Support\Carbon::create($story->created_at)->diffForHumans() }}</small>
        <span class="text-muted">|</span>
        <small class="text-muted">@lang('hackernews.by', ['by' => $story->by])</small>
        <span class="text-muted">|</span>
        <a href="#"
           data-story-id="{{ $story->id }}"
           data-bookmarked="{{ $story->bookmarked ? 'true' : 'false' }}"
           class="bookmark-story"
        >{{ $story->bookmarked ? "⚫" : "⚪️" }}</a>
      </div>

    </div>
    <div class="row">
      <div class="col-12">
        @foreach($story->sub as $sub)
          @component('hackernews.comment', [
            'item' => $sub,
            'op' => $story->by,
            'collapsedComments' => $collapsedComments
            ])@endcomponent
        @endforeach
      </div>
    </div>
    @push('scripts')
      <script src="{{ mix('/js/mods/bookmark.js') }}" defer></script>
      <script src="{{ mix('/js/mods/collapse.js') }}" defer></script>
    @endpush
  </div>
@endsection
