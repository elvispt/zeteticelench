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
  <a href="{{ route('notesCreate') }}">-- Create New --</a>
  <br>
  <br>


  <div>
    <form action="{{ route('notesAdd') }}" method="post">
      @csrf
      <div>
        <input
          type="text"
          name="title"
          maxlength="50"
        >
      </div>
      <textarea
        name="body"
        cols="100"
        rows="30"
      ></textarea>
      <div>
        <button type="submit">Save</button>
      </div>
    </form>
  </div>

@endsection
