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
        @endif

        <br>

        @if (!empty($movementsGroupedByDate))
          <div class="jumbotron py-4 text-center">
            <h4 class="text-center">€ {{ $movementsGroupedByDate->total }}</h4>
            <p class="lead">{{ $account->name }}</p>
            <p>{{ $account->description }}</p>
          </div>
          @foreach ($movementsGroupedByDate->movements as $amountDate => $movements)
            <div class="list-group list-group-flush">
              <div class="list-group-item">
                <div class="row">
                  <div class="col-sm-2"><b>{{ $amountDate }}</b></div>
                  <div class="col-sm-10">
                    @foreach($movements->movements as $movement)
                      <div class="row mb-1 {{ $loop->even ? 'bg-light' : '' }}" data-id="{{ $movement->id }}">
                        <div class="col-8">
                          <div class="text-truncate text-secondary">
                            @if (empty($movement->description))
                              *
                            @else
                              {{ $movement->description }}
                            @endif
                          </div>
                        </div>
                        <div class="col-4">
                          <div class="text-right text-nowrap">€ {{ $movement->amount }}</div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
                <div class="row">
                  <div class="offset-sm-2 col-sm-10">
                    <div class="text-right"><b>€ {{ $movements->total }}</b></div>
                  </div>
                </div>
              </div>
            </div>
          @endforeach
        @endif
      </div>
    </div>
  </div>
@endsection
