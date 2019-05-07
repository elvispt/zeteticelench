@extends('layouts/app')

@section('content')
  <div>
    @error('tag')
      <div class="alert alert-danger">{{ $message }}</div>
    @enderror
    <form action="{{ route('notesTagsAdd') }}" method="post">
      @csrf
      <label for="tag-name">Tag</label>
      <input
        type="text"
        id="tag-name"
        name="tag"
        class="form-control form-text"
        required
        maxlength="50"
      >
      <button type="submit" class="btn btn-primary">Save</button>
    </form>
  </div>
@endsection
