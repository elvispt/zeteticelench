@extends('layouts/app')

@section('title') @lang('notes.edit') @endsection

@section('content')
  <div class="container">

    @include('notes.top-submenu')

    <div class="row justify-content-center">
      <div class="col-sm">
        @if ($currentNote)

          <div class="card p-3 mt-3 shadow">
            <div class="text-right">
              <small class="text-muted">{{ $currentNote->updated_at->diffForHumans() }}</small>
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

            <div class="mt-3 text-right">
              <button type="button" id="btn_delete_note" class="btn btn-danger mt-3">@lang('notes.delete')</button>
            </div>

            <div id="overlay"
                 class="d-none position-absolute bg-light rounded shadow"
                 style="height: calc(100% - 1rem); width: calc(100% - 1rem); top: .5rem; left: .5rem;"
            ></div>

            <dialog id="confirmation_dialog" class="shadow bg-light border-secondary rounded d-none">
              <h3 class="text-center">@lang('notes.confirm_delete')</h3>
              <form action="{{ route('notesDestroy', ['noteId' => $currentNote->id]) }}"
                    method="post"
                    class="p-2 px-5"
              >
                @csrf
                @method('delete')
                <button type="button"
                        id="btn_delete_cancel"
                        class="btn btn-primary mr-3">@lang('common.cancel')</button>
                <button type="submit"
                        class="btn btn-danger">@lang('notes.delete')</button>
              </form>
            </dialog>

            <script type="text/javascript">
              (function () {
                document.addEventListener('DOMContentLoaded', function () {
                  var hideClass = 'd-none';
                  var dialog = document.getElementById('confirmation_dialog');
                  var overlay = document.getElementById('overlay');
                  var btnDelete = document.getElementById('btn_delete_note');
                  var btnDeleteCancel = document.getElementById('btn_delete_cancel');

                  if (btnDelete && btnDeleteCancel) {
                    btnDelete.addEventListener('click', function () {
                      dialog.classList.remove(hideClass);
                      dialog.setAttribute('open', true);
                      overlay.classList.remove(hideClass);
                    });
                    btnDeleteCancel.addEventListener('click', function () {
                      dialog.classList.add(hideClass);
                      dialog.removeAttribute('open');
                      overlay.classList.add(hideClass);
                    });
                  }
                });
              })();
            </script>
          </div>
        @endif
      </div>
    </div>
  </div>
@endsection
