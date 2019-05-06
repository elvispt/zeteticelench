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


  <div>
    <form action="{{ route('notesAdd') }}" method="post">
      @csrf
      <div>
        <input
          type="text"
          name="title"
          maxlength="50"
          class="form-control form-text"
        >
      </div>
      <textarea
        name="body"
        cols="100"
        rows="30"
        class="form-control form-text"
      ></textarea>
      <div>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>

@endsection
