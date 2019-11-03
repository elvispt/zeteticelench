@extends('layouts.app')

@section('title') @lang('common.dashboard') @endsection

@section('content')
  <div class="container pt-4">
    <div class="row justify-content-center">

      <div class="col-sm-6">
        <div class="card mb-3 shadow">
          <div class="card-body">
            @include('common/inspire')
          </div>
        </div>

        <div class="card mb-3 shadow">
          <div class="card-header">@lang('system.info')</div>
          <div class="card-body">
            <p class="alert-info">
              @lang('system.uptime', [
                'up' => ucfirst($sysInfo['up']),
                'since' => $sysInfo['upSince'],
              ])
            </p>

            <p class="{{ $sysInfo['nQueueWorkersRunning'] === 0 ? 'alert-danger' : 'alert-success' }}">
              @lang('system.number_queue_workers', [
                'number' => $sysInfo['nQueueWorkersRunning']
              ])
            </p>

            <div class="pt-4">
              <table class="table table-sm">
                <caption>@lang('system.memory_info')</caption>
                <thead>
                  <tr>
                    <th>@lang('system.used')</th>
                    <th>@lang('system.free')</th>
                    <th>@lang('system.total')</th>
                  </tr>
                </thead>
                <tbody>
                  <tr>
                    <td>{{ $sysInfo['memory']['used'] }}</td>
                    <td>{{ $sysInfo['memory']['free'] }}</td>
                    <td>{{ $sysInfo['memory']['total'] }}</td>
                  </tr>
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card shadow mb-3">
          <div class="card-header">Next Holiday</div>
          <div class="card-body">
            @foreach($nextHolidays as $nextHoliday)
              <p>
                <span class="badge badge-dark">#</span>
                {{ $nextHoliday->name }},
                {{ \Illuminate\Support\Carbon::make($nextHoliday->date->iso)->diffForHumans() }}
                at {{ \Illuminate\Support\Carbon::make($nextHoliday->date->iso)->format('Y-m-d') }}
                @foreach ($nextHoliday->type as $tp)
                  <small>{{ $tp }}</small>
                @endforeach
              </p>
              <p>
                <small>{{ $nextHoliday->description }}</small>
              </p>

            @endforeach
          </div>
        </div>
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

@section('headers')
  @includeWhen(!empty($unsplash), 'common.unsplash')
@endsection
