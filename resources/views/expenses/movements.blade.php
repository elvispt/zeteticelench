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
            @foreach($movementsGroupedByDate->totalAmountPerTag as $tag)
              <div class="row">
                <div class="col-6 text-right">
                  <span class="badge badge-primary pointer _js--tags"
                        data-id="{{ $tag->id }}"
                  >{{ $tag->name }}</span>
                </div>
                <div class="col-6 text-left">€ {{ $tag->amount }}</div>
              </div>
            @endforeach
            <form action="{{ route('movements') }}" method="get" id="_js--movements-filters">
              <div class="form-row">
                <div class="col">
                  <label for="fromDate">@lang('expenses.from')</label>
                  <input type="date"
                         class="form-control"
                         id="fromDate"
                         name="fromDate"
                         placeholder="from"
                         value="{{ $filters->get('fromDate') }}"
                  >
                </div>
                <div class="col"><label for="toDate">@lang('expenses.to')</label>
                  <input type="date"
                         class="form-control"
                         id="toDate"
                         name="toDate"
                         placeholder="to"
                         value="{{ $filters->get('toDate') }}"
                  >
                </div>
              </div>
              <div class="form-row">
                <div class="col col-md-6 offset-md-3">
                  <button type="submit" class="btn btn-primary my-1 btn-block mt-2">Submit</button>
                </div>
              </div>
            </form>
          </div>
          @foreach ($movementsGroupedByDate->movements as $amountDate => $movements)
            <div class="list-group list-group-flush">
              <div class="list-group-item">
                <div class="row">
                  <div class="col-sm-3"><b>{{ $amountDate }}</b></div>
                  <div class="col-sm-9">
                    @foreach($movements->movements as $movement)
                      <div class="row mb-1 {{ $loop->even ? 'bg-light' : '' }}" data-id="{{ $movement->id }}">
                        <div class="col-8">
                          <div class="text-truncate">
                            <a class="d-block text-decoration-none"
                               href="{{ route('movementsEdit', ['id' => $movement->id]) }}"
                            >{{ $movement->description ?? '*'  }}</a>
                          </div>
                          @if ($movement->tags->isNotEmpty())
                            <div>
                              @foreach($movement->tags()->orderBy('tag')->get() as $tag)
                                <span class="badge badge-primary"
                                >{{ $tag->tag }}</span>
                              @endforeach
                            </div>
                          @endif
                        </div>
                        <div class="col-4">
                          <div class="text-right text-nowrap">€ {{ $movement->amount }}</div>
                        </div>
                      </div>
                    @endforeach
                  </div>
                </div>
                <div class="row">
                  <div class="offset-sm-3 col-sm-9">
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
  @push('scripts')
    <script src="{{ mix('/js/mods/expenses-tags.js') }}" defer></script>
  @endpush
@endsection
