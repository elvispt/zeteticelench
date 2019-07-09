@extends('layouts/app')

@section('title') @lang('notes.new-tag') @endsection

@section('content')
  <div class="container">

    @include('notes.top-submenu')

    <div class="row justify-content-center">
      <div class="col-12">
        @error('tag')
          <div class="alert alert-danger">{{ $message }}</div>
        @enderror
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-sm-6">
        <form action="{{ route('notesTagsAdd') }}" method="post">
          @csrf
          <div class="form-group">
            <label for="tag-name">@lang('notes.tag')</label>
            <input
              type="text"
              id="tag-name"
              name="tag"
              class="form-control"
              required
              maxlength="50"
              placeholder="tag"
            >
            <small class="form-text text-muted">The tag name. Use lowercase. 50 char max.</small>
          </div>
          <button type="submit" class="btn btn-primary">Save</button>
        </form>
      </div>
    </div>
  </div>
@endsection
