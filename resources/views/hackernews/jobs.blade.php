@extends('layouts/app')

@section('content')
  <div class="container">
    @include('hackernews.top-submenu')
    <div class="row">
      <div class="col-12">
        <ul class="list-group">
          @foreach($stories as $index => $story)
            <li class="list-group-item list-group-item-action flex-column align-items-start {{ preg_match("/remote/mi", $story->title) ? "list-group-item-success" : "" }}">
              <div class="d-flex w-100 justify-content-between">
                <a href="{{ data_get($story, 'url', '#') }}" target="story-{{$index}}" class="text-body">{{ $story->title }}</a>
                <span class="badge">{{ \Illuminate\Support\Carbon::create($story->created_at)->diffForHumans() }}</span>
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
  </div>
@endsection
