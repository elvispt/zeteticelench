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
            @lang('system.uptime', [
              'up' => ucfirst($sysInfo['up']),
              'since' => $sysInfo['upSince'],
            ])
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
    </div>
  </div>
@endsection

@section('headers')
  @includeWhen(!empty($unsplash), 'common.unsplash')
@endsection
