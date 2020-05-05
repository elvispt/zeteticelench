@extends('vuejs.layouts.app')

@section('title') @lang('common.dashboard') @endsection

@push('scripts')
  <script src="{{ mix('js/mods/manifest.js') }}" defer></script>
  <script src="{{ mix('js/mods/vendor.js') }}" defer></script>
  <script src="{{ mix('js/dashboard/app.js') }}" defer></script>
@endpush

@section('content')
  <div class="container pt-4">
    <div class="row justify-content-center">

      <div class="col-sm-6 no-gutter-xs">
        <inspire></inspire>
        <system-info lang-system-info="@lang('system.info')"
                     lang-since="@lang('system.since')"
                     lang-number-queue-workers="@lang('system.number_queue_workers')"
                     lang-memory-info="@lang('system.memory_info')"
                     lang-used="@lang('system.used')"
                     lang-free="@lang('system.free')"
                     lang-total="@lang('system.total')"
        ></system-info>
      </div>

      <div class="col-sm-6 no-gutter-xs">
        <weather></weather>
        <next-holidays
          lang-next-holiday="@lang('holidays.next_holidays')"
        ></next-holidays>
      </div>

      <div class="col-sm-12 no-gutter-xs">
        <remote-jobs
          lang-remote-jobs="@lang('jobs.remote_jobs')"
        ></remote-jobs>
      </div>

    </div>
  </div>
@endsection
