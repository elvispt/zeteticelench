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
            <div class="card-header">
              <small class="text-secondary">#{{ $note->id }}</small>
              <a href="{{ route('notesEdit', ['noteId' => $note->id]) }}">{{ $note->title }}</a>
            </div>

            <div class="card-body">
              <span
                class="badge badge-secondary">{!! implode('</span> <span class="badge badge-secondary">', $note->tags) !!}
              </span>
              <small>@lang('notes.updated') {{ \Illuminate\Support\Carbon::make($note->updated_at)->diffForHumans() }}</small>
              <div>
                {{ mb_substr($note->body, 0, 200) }} ...
              </div>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
