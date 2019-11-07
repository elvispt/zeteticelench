@extends('layouts/app')

@section('title') @lang($title) @endsection

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
          <h4>{{ $account->name }}
          <small><span class="text-right">€ {{ number_format($account->balance(), 2, '.', ' ') }}</span></small></h4>
        @endif

        <br>

        <form method="POST" action="{{ route('movementsAdd') }}">
          @csrf

          <div class="btn-group btn-group-toggle" data-toggle="buttons">
            @php
            switch (old('credit-debit')) {
              case \App\Repos\Expenses\Movements::CREDIT:
                $val = \App\Repos\Expenses\Movements::CREDIT;
                break;
              case \App\Repos\Expenses\Movements::DEBIT:
              default:
                $val = \App\Repos\Expenses\Movements::DEBIT;
            }
            @endphp
            <label class="btn btn-primary {{ $val == \App\Repos\Expenses\Movements::DEBIT ? 'active' : '' }}">
              <input type="radio"
                     name="credit-debit"
                     value="{{ \App\Repos\Expenses\Movements::DEBIT }}"
                     autocomplete="off"
                     {{ $val == \App\Repos\Expenses\Movements::DEBIT ? 'checked' : '' }}
              > @lang('expenses.debit')
            </label>
            <label class="btn btn-primary {{ $val == \App\Repos\Expenses\Movements::CREDIT ? 'active' : '' }}">
              <input type="radio"
                     name="credit-debit"
                     value="{{ \App\Repos\Expenses\Movements::CREDIT }}"
                     autocomplete="off"
                     {{ $val == \App\Repos\Expenses\Movements::CREDIT ? 'checked' : '' }}
              > @lang('expenses.credit')
            </label>
          </div>

          <div class="form-row">
            <div class="col">
              <label for="date">@lang('expenses.movement_date')</label>
              <input type="date"
                     class="form-control"
                     id="date"
                     name="date"
                     placeholder="@lang('expenses.enter_date')"
                     value="{{ old('date') ? old('date') : date('Y-m-d') }}"
                     required
              >
            </div>
            <div class="col">
              <label for="time">@lang('expenses.movement_time')</label>
              <input type="time"
                     class="form-control"
                     id="time"
                     name="time"
                     placeholder="@lang('expenses.enter_time')"
                     value="{{ old('time') ? old('time') : date('H:i') }}"
                     required
              >
            </div>
          </div>
          <div class="form-group">
            <label for="description">@lang('expenses.movement_description')</label>
            <textarea
              class="form-control"
              id="description"
              name="description"
              rows="3">{{ old('description') }}</textarea>
          </div>
          <div class="form-group">
            <label for="amount">@lang('expenses.amount')</label>
            <input type="number"
                   class="form-control"
                   id="amount"
                   name="amount"
                   step="0.01"
                   placeholder="@lang('expenses.enter_amount')"
                   min="0"
                   value="{{ old('amount') }}"
            >
          </div>
          <button type="submit" class="btn btn-primary">@lang('common.add')</button>
        </form>

      </div>
    </div>
  </div>
@endsection
