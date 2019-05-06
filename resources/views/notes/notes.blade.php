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
  <a href="{{ route('notesCreate') }}"
     class="btn btn-dark"
  >-- Create New --</a>
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
            class="form-control form-text"
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
          class="form-control form-text"
          cols="100"
          rows="30"
        >{{ $currentNote->body }}</textarea>
        <div>
          <button type="submit" class="btn btn-primary">Save</button>
        </div>
      </form>

      <form action="{{ route('notesDestroy', ['noteId' => $currentNote->id]) }}" method="post">
          <span>
            @csrf
            @method('delete')
            <button type="submit" class="btn btn-danger">&times;&times;&times; DELETE &times;&times;&times;</button>
          </span>
      </form>
    </div>
  @endif
@endsection
