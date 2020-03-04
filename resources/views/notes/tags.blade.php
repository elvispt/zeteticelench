@extends('layouts/app')

@section('title') @lang('notes.tags') @endsection

@section('content')
  <div class="container">

    @include('notes.top-submenu')

    <div class="row">
      <div class="col-12">
        <div class="list-group mt-3">
          @foreach($tags as $tag)
            <a class="list-group-item d-flex justify-content-between align-items-center {{ $createdTag ===$tag->tag  ? 'list-group-item-info' : '' }}"
               href="{{ route('notesTags', ['tagId' => $tag->id]) }}"
            >
              {{ $tag->tag }}<span class="badge badge-dark badge-pill">{{ $tag->notes->count() }}</span>
            </a>
          @endforeach
        </div>
      </div>
    </div>

    @if ($currentTag)
      <div class="row justify-content-center">
        @foreach($currentTag->notes as $note)
          <div class="col-xs-12 col-md-6 mt-3">
            <div class="card shadow">
              <div class="card-body">
                <h5 class="card-title"><a href="{{ route('notesShow', ['noteId' => $note->id]) }}">{{ $note->extractTitle() }}</a></h5>
                <h6 class="card-subtitle mb-2 text-muted">
                  <small>#{{ $note->id }}</small>
                  <small>{{ \Illuminate\Support\Carbon::make($note->updated_at)->diffForHumans() }}</small>
                </h6>
                <p class="card-text">{{ $note->extractDescription() }}</p>
                <a href="{{ route('notesEdit', ['noteId' => $note->id]) }}"
                   class="card-link"
                >@lang('common.edit')</a>
              </div>
              <div class="card-footer text-right">
                <span class="badge badge-secondary">{!! implode('</span> <span class="badge badge-secondary">', $note->tags->pluck('tag')->toArray()) !!}</span>
              </div>
            </div>
          </div>
        @endforeach
      </div>
    @endif
  </div>
@endsection
