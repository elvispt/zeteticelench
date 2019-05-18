@extends('layouts/app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <ul class="list-group">
          @foreach($stories as $index => $story)
            <li class="list-group-item list-group-item-action flex-column align-items-start {{ preg_match("/remote/mi", $story->title) ? "list-group-item-success" : "" }}">
              <div class="d-flex w-100 justify-content-between">
                <a href="{{ data_get($story, 'url', '#') }}" target="story-{{$index}}" class="text-body">{{ $story->title }}</a>
                <span class="badge">{{ \Illuminate\Support\Carbon::createFromTimestamp($story->time)->diffForHumans() }}</span>
              </div>
            </li>
          @endforeach
        </ul>
      </div>
    </div>
  </div>
@endsection
