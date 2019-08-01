@extends('layouts/app')

@section('title') @lang('notes.notes') @endsection

@section('content')
  <div class="container">

    @include('notes.top-submenu')

    <div class="row justify-content-center">
      <div class="col-12">
        <form class="form-inline justify-content-center"
              action="{{ route('notes') }}"
              method="get">
          <label class="sr-only" for="query">@lang('notes.search')</label>
          <input type="text"
                 class="form-control w-50"
                 id="query"
                 name="query"
                 placeholder="@lang('notes.search')"
                 value="{{ old('query', $query ?? '') }}"
          >
          &nbsp;
          <img src="{{ asset('search-by-algolia.svg') }}" alt="search by algolia">
        </form>
      </div>
    </div>

    <div class="row justify-content-center">

      @foreach($notes as $note)
        <div class="col-xs-12 col-md-6 mt-3">
          <div class="card shadow">
            <div class="card-body">
              <h5 class="card-title"><a href="{{ route('notesShow', ['noteId' => $note->id, 'query' => $query]) }}">{{ $note->title }}</a></h5>
              <h6 class="card-subtitle mb-2 text-muted">
                <small>#{{ $note->id }}</small>
                <small>@lang('notes.updated') {{ \Illuminate\Support\Carbon::make($note->updated_at)->diffForHumans() }}</small>
              </h6>
              <p class="card-text">{{ $note->description }}</p>
              <a href="{{ route('notesEdit', ['noteId' => $note->id]) }}"
                 class="card-link"
              >@lang('common.edit')</a>
            </div>
            <div class="card-footer text-right">
              <span class="badge badge-secondary">{!! implode('</span> <span class="badge badge-secondary">', $note->tags) !!}</span>
            </div>
          </div>
        </div>
      @endforeach
    </div>
  </div>
@endsection
