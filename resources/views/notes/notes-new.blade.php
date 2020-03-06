@extends('layouts/app')

@section('title') @lang('notes.new-note') @endsection

@section('content')
  <div class="container note-change">

    @include('notes.top-submenu')

    <div class="row justify-content-center">
      <div class="col-sm">
        <div class="card shadow">

          <form action="{{ route('notesAdd') }}" method="post">
            @csrf
            <div>
              @error('title')
                <div class="alert alert-danger">{{ $message }}</div>
              @enderror
            </div>
            @error('body')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="textarea-container">
              <textarea
                id="note-body"
                name="body"
                class="form-control form-text m-0"
                cols="100"
                rows="15"
              >{{ old('body') }}</textarea>
            </div>
            <small class="form-text text-muted ml-3">
              <a class="text-muted" href="https://commonmark.org/help/" target="_CommonMark">CommonMark</a>
            </small>
            @if ($errors->has('tags.*'))
              @foreach($errors->get('tags.*') as $msg)
                <div class="alert alert-danger">{{ Arr::first($msg) }}</div>
              @endforeach
            @endif
            <div class="p-3 mt-3">
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
            <div class="px-3 pb-3">
              <button type="submit" class="btn btn-primary">@lang('notes.save')</button>
            </div>
          </form>
        </div>
      </div>
    </div>
  </div>
@endsection
