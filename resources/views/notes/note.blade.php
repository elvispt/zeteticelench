@extends('layouts/app')

@section('title') @lang('notes.note') @endsection

@section('content')
  <div class="container">

    @include('notes.top-submenu')

    <div class="row justify-content-center">
      <div class="col-12">
        <div class="mt-3">{!! $note->bodyToHtml() !!}</div>
      </div>
    </div>

    <div class="row justify-content-center">
      <div class="col-12">
        <div class="mt-3">
          <a href="{{ route('notesEdit', ['noteId' => $note->id]) }}"
             class="btn btn-primary"
          >@lang('notes.edit')</a>
        </div>
      </div>
    </div>
  </div>
@endsection
