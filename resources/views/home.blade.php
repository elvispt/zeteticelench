@extends('layouts.app')

@section('content')
  <div class="container">
    <div class="row justify-content-center">

      <div class="col-sm-6">
        <div class="card">
          <div class="card-header">Dashboard</div>

          <div class="card-body">
            @if (session('status'))
              <div class="alert alert-success" role="alert">
                {{ session('status') }}
              </div>
            @endif

            You are logged in!
          </div>
        </div>
      </div>

      <div class="col-sm-6">
        <div class="card">
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

@includeWhen(!empty($unsplash), 'common.unsplash')
