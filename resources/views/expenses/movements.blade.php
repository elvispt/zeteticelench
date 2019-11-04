@extends('layouts/app')

@section('title') @lang($title) @endsection

@php
function context($amount)
{
  if ($amount < -50) {
    return 'table-danger';
  } elseif ($amount < -10) {
    return 'table-warning';
  } elseif ($amount > 0) {
    return 'table-success';
  }
  return '';
}
@endphp

@section('content')
  <div class="container">
    @include('expenses.top-submenu')
    <div class="row">
      <div class="col-12">
        @if (empty($account))
          <div class="alert alert-danger" role="alert">
            @lang('expenses.no_accounts_exist')
          </div>
        @else
          {{ setlocale(LC_MONETARY, 'pt_PT') }}
          <div class="text-right">€ {{ number_format($account->balance(), 2, '.', ' ') }}</div>
        @endif

        <br>

        <div class="table-responsive">
          <table class="table table-sm">
            <caption>@lang('expenses.movements_list')</caption>
            <thead>
              <tr>
                <th scope="col">@lang('expenses.movement_date')</th>
                <th scope="col">@lang('expenses.movement_description')</th>
                <th scope="col" class="text-right"
                >@lang('expenses.movement_amount')</th>
              </tr>
            </thead>
            <tbody>
              @foreach ($movements as $movement)
                <tr data-id="{{ $movement->id }}" class="{{ context($movement->amount)  }}">
                  <td>{{ \Illuminate\Support\Carbon::createFromFormat('Y-m-d H:i:s', $movement->created_at)->format('Y-m-d H:i') }}</td>
                  <td>{{ $movement->description }}</td>
                  <td class="text-right">{{ $movement->amount }}</td>
                </tr>
              @endforeach
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
@endsection
