@extends('vuejs.layouts.app')

@section('title') @lang('notes.notes') @endsection

@push('scripts')
  <script src="{{ mix('js/manifest.js') }}" defer></script>
  <script src="{{ mix('js/vendor.js') }}" defer></script>
  <script src="{{ mix('js/notes/app.js') }}" defer></script>
@endpush

@section('content')
  <div class="container">
    <!-- views are injected here -->
    <router-view/>
  </div>
@endsection
