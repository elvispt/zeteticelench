@extends('layouts/app')

@section('title') {{ $story->title }} @endsection

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

      <script type="text/javascript">
        (function () {
          var iconBookmarked = "⚫";
          var iconNotBookmarked = "⚪️";

          document.addEventListener('DOMContentLoaded', function () {
            $.ajaxSetup({
              headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
              }
            });
            $('.bookmark-story').on('click', function (event) {
              event.preventDefault();
              var el = $(this);
              var id = el.data('story-id');
              var isBookmarked = el.data('bookmarked');

              if (isBookmarked) {
                $.ajax({
                  method: 'post',
                  url: '{{ route('hackernews-bookmark-destroy') }}',
                  data: {
                    _method: 'DELETE',
                    story_id: id,
                  },
                }).done(function () {
                  el.text(iconNotBookmarked);
                  el.data('bookmarked', false);
                });
              } else {
                $.ajax({
                  method: 'post',
                  url: '{{ route('hackernews-bookmark-add') }}',
                  data: {
                    story_id: id,
                  },
                }).done(function () {
                  el.text(iconBookmarked);
                  el.data('bookmarked', true);
                });
              }
            });
          });
        })();
      </script>

    </div>
    <div class="row">
      <div class="col-12">
        @foreach($story->sub as $sub)
          @component('hackernews.comment', ['item' => $sub, 'op' => $story->by])@endcomponent
        @endforeach
      </div>
    </div>
  </div>
@endsection
