@extends('vuejs/layouts.app')

@section('title') @lang('common.dashboard') @endsection

@section('content')
  <div class="container pt-4">
    <div class="row justify-content-center">

      <div class="col-sm-6">
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

      <div class="col-sm-6">
        <next-holidays
          lang-next-holiday="@lang('holidays.next_holidays')"
        ></next-holidays>
      </div>

      <div class="col-sm-12">

        <div class="card mb-3 shadow">
          <div class="card-header">@lang('jobs.remote_jobs')</div>
          <div class="card-body">
            <div class="list-group list-group-flush">
              @foreach($jobs as $job)
                <div class="list-group-item list-group-item-action">
                  <div class="d-flex w-100 justify-content-between">
                    <h6 class="mb-1 pointer"
                        data-toggle="collapse"
                        data-target="#collapse-{{ $job->id }}"
                    >{{ $job->title }}</h6>
                    <small class="text-muted">{{ $job->time->diffForHumans() }}</small>
                  </div>
                  <div id="collapse-{{ $job->id }}" class="collapse mt-2 pl-2">
                    <div>
                      <a href="{{ $job->url }}" target="_blank">@lang("jobs.source-$job->source")</a>
                    </div>
                    <div>{!! $job->howToApply !!}</div>
                    @if (!is_null($job->companyUrl))
                      <div>
                        <a href="{{ $job->companyUrl }}">{{ $job->companyUrl }}</a>
                      </div>
                    @endif
                    <div>{!! $job->text !!}</div>
                  </div>
                </div>
              @endforeach
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
@endsection
