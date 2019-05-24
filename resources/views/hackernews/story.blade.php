@extends('layouts/app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <p class="lead">
          {{ $story->title }}
          <a href="{{ data_get($story, 'url', '#') }}" target="story-{{ $story->id }}" class="text-body">
            <b>[↗]</b>
          </a>
        </p>
        @if (data_get($story, 'text'))
          <p>{!! $story->text !!}</p>
        @endif
        <small class="text-muted">@lang('hackernews.points', ['points' => $story->score])</small>
        <span class="text-muted">|</span>
        <small class="text-muted">@lang('hackernews.comments', ['comments' => $story->descendants])</small>
        <span class="text-muted">|</span>
        <small class="text-muted">{{ \Illuminate\Support\Carbon::create($story->created_at)->diffForHumans() }}</small>
        <span class="text-muted">|</span>
        <a href="{{ sprintf($hnPostUrlFormat, $story->id) }}"
           target="hncomments-{{ $story->id }}"
           class="text-info"
        ><small>@lang('hackernews.hnpost')</small></a>
      </div>
    </div>
    <div class="row">
      <div class="col-12">
        @foreach($story->sub as $sub)
          @component('hackernews.comment', ['item' => $sub])@endcomponent
        @endforeach
      </div>
    </div>
  </div>
@endsection
