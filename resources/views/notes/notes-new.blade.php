@extends('layouts/app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">
      <div class="col-sm">
        <div class="card p-3 mt-3">
          <h3>@lang('notes.new')</h3>

          <form action="{{ route('notesAdd') }}" method="post">
            @csrf
            <div>
              @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
              <div class="form-group">
                <label for="note-title">@lang('notes.title')</label>
                <input
                  type="text"
                  id="note-title"
                  name="title"
                  class="form-control form-text"
                  maxlength="50"
                  value="{{ old('title') }}"
                >
              </div>
            </div>
            @error('body')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div>
              <label for="note-body">@lang('notes.note')</label>
              <textarea
                id="note-body"
                name="body"
                class="form-control form-text"
                cols="100"
                rows="15"
              >{{ old('body') }}</textarea>
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
                  >
                  <label for="tag-{{ $tag->id }}"
                         class="form-check-label"
                  >{{ $tag->tag }}</label>
                </div>
              @endforeach
            </div>
            <button type="submit" class="btn btn-primary">@lang('notes.save')</button>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
