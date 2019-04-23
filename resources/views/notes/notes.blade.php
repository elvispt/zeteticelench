@extends('layouts/app')

@section('content')
  <div>
    @foreach($notes as $note)
      <p>
        <a href="{{ route('notes', ['noteId' => $note->id]) }}">{{ $note->title }}</a>
      </p>
    @endforeach
  </div>

  <br>
  <br>

  @if ($currentNote)
    <div>
      <h1>
        <label for="note">{{ $currentNote->title }}</label>
      </h1>
      <div>
        <small>Updated {{ $currentNote->updated_at->diffForHumans() }}</small>
        |
        <small>Created {{ $currentNote->created_at->diffForHumans() }}</small>
      </div>
      <textarea name="note" id="note" cols="100" rows="30">{{ $currentNote->body }}</textarea>
    </div>
  @endif
@endsection
