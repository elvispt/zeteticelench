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

    <!-- <div class="row justify-content-center"> -->
    <div class="row">
      <div class="col-12 mt-3">
        <div class="list-group list-group">
          @foreach($notes as $note)
            <li class="list-group-item list-group-item-action p-2 p-sm-3">
              <a class="text-secondary"
                 href="{{ route('notesShow', ['noteId' => $note->id, 'query' => $query]) }}">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ $note->title }}</h5>
                  <small class="d-none d-sm-block">{{ \Illuminate\Support\Carbon::make($note->updated_at)->diffForHumans() }}</small>
                </div>
              </a>
              <a href="{{ route('notesEdit', ['noteId' => $note->id]) }}"
                 class="card-link d-none d-sm-block"
              >@lang('common.edit')</a>
              <div>
                <span class="badge badge-secondary">{!! implode('</span> <span class="badge badge-secondary">', $note->tags) !!}</span>
              </div>
            </li>
          @endforeach
        </div>
      </div>
    </div>
  </div>
@endsection
