@extends('layouts/app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <a href="{{ route('notesCreate') }}"
           class="btn btn-dark"
        >@lang('notes.new')</a>
      </div>
    </div>
    <div class="row justify-content-center">

      @foreach($notes as $note)
        <div class="col-xs-12 col-md-6 mt-3">
          <div class="card">
            <div class="card-body">
              <h5 class="card-title">{{ $note->title }}</h5>
              <h6 class="card-subtitle mb-2 text-muted">
                <small>#{{ $note->id }}</small>
                <small>@lang('notes.updated') {{ \Illuminate\Support\Carbon::make($note->updated_at)->diffForHumans() }}</small>
              </h6>
              <p class="card-text">
                {{ mb_substr($note->body, 0, 200) }} ...
              </p>
              <a href="{{ route('notesEdit', ['noteId' => $note->id]) }}"
                 class="card-link"
              >Edit</a>
            </div>
            <div class="card-footer text-right">
              <span class="badge badge-secondary">{!! implode('</span> <span class="badge badge-secondary">', $note->tags) !!}</span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
