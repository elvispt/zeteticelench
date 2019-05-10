@extends('layouts/app')

@section('content')
  <div>
    @foreach($notes as $note)
      <p>
        <a href="{{ route('notes', ['noteId' => $note->id]) }}">{{ $note->title }}</a>
        <small class="text-secondary">#{{ $note->id }}</small>
        <span class="badge badge-secondary">{!! implode('</span> <span class="badge badge-secondary">', $note->tags) !!}</span>
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
    @error('title')
      <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <form action="{{ route('notesAdd') }}" method="post">
      @csrf
      <div class="form-group">
        <input
          type="text"
          name="title"
          maxlength="50"
          class="form-control"
          value="{{ old('title') }}"
        >
      </div>
      @error('body')
        <div class="alert alert-danger">{{ $message }}</div>
      @enderror
      <textarea
        name="body"
        cols="100"
        rows="20"
        class="form-control"
        maxlength="10000"
      >{{ old('body') }}</textarea>
      <br>

      @if ($errors->has('tags.*'))
        @foreach($errors->get('tags.*') as $msg)
          <div class="alert alert-danger">{{ Arr::first($msg) }}</div>
        @endforeach
      @endif
      <select name="tags[]" id="tags" multiple class="form-control">
        @foreach($tags as $tag)
          <option value="{{ $tag->id }}">{{ $tag->tag }}</option>
        @endforeach
      </select>
      <div>
        <button type="submit" class="btn btn-primary">Save</button>
      </div>
    </form>
  </div>

@endsection
