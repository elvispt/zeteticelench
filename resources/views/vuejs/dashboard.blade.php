@extends('app')

@section('title') @lang('common.dashboard') @endsection

@push('scripts')
  <script src="{{ mix('js/manifest.js') }}" defer></script>
  <script src="{{ mix('js/vendor.js') }}" defer></script>
  <script src="{{ mix('js/dashboard/app.js') }}" defer></script>
@endpush

@section('content')
  <div class="container pt-4">
    <div class="row justify-content-center">

      <div class="col-sm-6 no-gutter-xs">
        <inspire></inspire>
        <system-info></system-info>
      </div>

      <div class="col-sm-6 no-gutter-xs">
        <weather></weather>
        <next-holidays></next-holidays>
      </div>

    </div>
  </div>
@endsection
