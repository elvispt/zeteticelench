@extends('layouts/master')

@section('content')
  <div>
    @foreach($notes as $note)
      <p>
        <a href="{{ route('notes', ['noteId' => $note->id]) }}">{{ $note->title }}</a>
      </p>
    @endforeach
  </div>

  <br>
  <a href="{{ route('notesCreate') }}">-- Create New --</a>
  <br>
  <br>

  @if ($currentNote)
    <div>
      <form action="{{ route('notesUpdate', ['noteId' => $note->id]) }}" method="post">
        @csrf
        @method('put')
        <div>
          <input
            type="text"
            name="title"
            maxlength="50"
            value="{{ $currentNote->title }}"
          >
        </div>
        <div>
          <small>Updated {{ $currentNote->updated_at->diffForHumans() }}</small>
          |
          <small>Created {{ $currentNote->created_at->diffForHumans() }}</small>
        </div>
        <textarea
          name="body"
          cols="100"
          rows="30"
        >{{ $currentNote->body }}</textarea>
        <div>
          <button type="submit">Save</button>
        </div>
      </form>

      <form action="{{ route('notesDestroy', ['noteId' => $currentNote->id]) }}" method="post">
          <span>
            @csrf
            @method('delete')
            <button type="submit">&times;&times;&times; DELETE &times;&times;&times;</button>
          </span>
      </form>
    </div>
  @endif
@endsection
