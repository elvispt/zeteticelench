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

  @if ($currentNote)
    <div>
      <form action="{{ route('notesUpdate', ['noteId' => $currentNote->id]) }}" method="post">
        @csrf
        @method('put')
        <div>
          @error('title')
            <div class="alert alert-danger">{{ $message }}</div>
          @enderror
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
          @if ($currentNote->tags->isNotEmpty())
            |
            @foreach ($currentNote->tags as $tag)
              <span class="badge badge-secondary">{{ $tag->tag }}</span>
            @endforeach
          @endif
        </div>
        @error('body')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <textarea
          name="body"
          class="form-control form-text"
          cols="100"
          rows="20"
        >{{ $currentNote->body }}</textarea>
        <br>
        @if ($errors->has('tags.*'))
          @foreach($errors->get('tags.*') as $msg)
            <div class="alert alert-danger">{{ Arr::first($msg) }}</div>
          @endforeach
        @endif
        <select name="tags[]" id="tags" multiple class="form-control">
          @foreach($tags as $tag)
            <option
              value="{{ $tag->id }}"
              {{ $currentNote->tags->contains('id', $tag->id) ? 'selected' : '' }}
            >{{ $tag->tag }}</option>
          @endforeach
        </select>
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
