@extends('layouts/app')

@section('title') @lang('notes.edit') @endsection

@section('content')
  <div class="container">

    @include('notes.top-submenu')

    <div class="row justify-content-center">
      <div class="col-sm">
        @if ($currentNote)

          <div class="card p-3 mt-3">
            <div class="text-right">
              <small class="text-muted">@lang('notes.updated') {{ $currentNote->updated_at->diffForHumans() }}</small>
              <small class="text-muted">|</small>
              <small class="text-muted">@lang('notes.created') {{ $currentNote->created_at->diffForHumans() }}</small>
            </div>

            <form action="{{ route('notesUpdate', ['noteId' => $currentNote->id]) }}" method="post">
              @csrf
              @method('put')
              <div>
                @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
              </div>
              @error('body')
              <div class="alert alert-danger">{{ $message }}</div>
              @enderror
              <div>
                <textarea
                  id="note-body"
                  name="body"
                  class="form-control form-text"
                  cols="100"
                  rows="15"
                >{{ $currentNote->body }}</textarea>
                <small class="form-text text-muted">
                  <a class="text-muted" href="https://commonmark.org/help/" target="_CommonMark">CommonMark</a>
                </small>
              </div>
              @if ($errors->has('tags.*'))
                @foreach($errors->get('tags.*') as $msg)
                  <div class="alert alert-danger">{{ Arr::first($msg) }}</div>
                @endforeach
              @endif
              <div class="mt-3">
                <legend class="col-form-label pt-0">@lang('notes.tags')</legend>
                @foreach($tags as $tag)
                  <div class="form-check form-check-inline">
                    <input type="checkbox"
                           value="{{ $tag->id }}"
                           id="tag-{{ $tag->id }}"
                           name="tags[]"
                           class="form-check-input"
                      {{ $currentNote->tags->contains('id', $tag->id) ? 'checked' : '' }}
                    >
                    <label for="tag-{{ $tag->id }}"
                           class="form-check-label"
                    >{{ $tag->tag }}</label>
                  </div>
                @endforeach
              </div>
              <button type="submit" class="btn btn-primary">@lang('notes.save')</button>
            </form>
            <form action="{{ route('notesDestroy', ['noteId' => $currentNote->id]) }}"
                  method="post"
                  class="mt-3 text-right"
            >
              @csrf
              @method('delete')
              <button type="submit" class="btn btn-danger mt-3">@lang('notes.delete')</button>
            </form>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
