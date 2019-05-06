@extends('layouts/app')

@section('content')
  <div>
    @foreach($tags as $tag)
      <a class="btn btn-link btn-outline-dark mb-1"
         href="{{ route('notesTags', ['tagId' => $tag->id]) }}"
      >
        {{ $tag->tag }} <span class="badge badge-light">{{ $tag->notes->count() }}</span>
      </a>
    @endforeach
  </div>

  @if ($currentTag)
    @foreach($currentTag->notes as $note)
      <p>
        <a class="btn btn-link" href="{{ route('notes', ['noteId' => $note->id]) }}">{{ $note->title }}</a>
      </p>
    @endforeach
  @endif

@endsection
