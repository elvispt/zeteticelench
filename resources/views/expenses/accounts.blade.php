@extends('layouts/app')

@section('title') @lang($title) @endsection

@section('content')
  <div class="container">
    @include('expenses.top-submenu')
    <div class="row">
      <div class="col-12">
        <div class="list-group">
          @if ($accounts->isEmpty())
            <div class="alert alert-danger" role="alert">
              @lang('expenses.no_accounts_exist')
            </div>
          @else
            @foreach($accounts as $account)
              <div class="list-group-item flex-column align-items-start">
                <div class="d-flex w-100 justify-content-between">
                  <h5 class="mb-1">{{ $account->name }}</h5>
                </div>
                <p class="mb-1">{{ $account->description }}</p>
                <span>@lang('expenses.balance'):</span>
                {{ setlocale(LC_MONETARY, 'pt_PT') }}
                <span>€ {{ number_format($account->balance(), 2, '.', ' ') }}</span>
              </div>
            @endforeach
          @endif
        </div>
      </div>
    </div>
  </div>
@endsection
