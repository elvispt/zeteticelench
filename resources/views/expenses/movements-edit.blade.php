@extends('layouts/app')

@section('title') @lang($title) @endsection

@section('content')
  <div class="container">
    @include('expenses.top-submenu')
    <div class="row">
      <div class="col-12">
        <form method="POST" action="{{ route('movementsUpdate') }}">
          @csrf
          @method('PUT')
          <input type="hidden" name="id" value="{{ $movement->id }}">
          <div class="form-row">
            <div class="col">
              <label for="date">@lang('expenses.movement_date')</label>
              <input type="date"
                     class="form-control"
                     id="date"
                     name="date"
                     placeholder="@lang('expenses.enter_date')"
                     value="{{ old('date', $movement->amount_date->format('Y-m-d')) }}"
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
                     value="{{ old('time', $movement->amount_date->format('H:i')) }}"
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
              rows="3">{{ old('description', $movement->description) }}</textarea>
          </div>

          <div class="form-group">
            <div class="form-row">
              @foreach($tags as $tag)
                <div class="btn-group btn-group-toggle col-6 col-sm-4 col-md-3 col-lg-2 mb-1" data-toggle="buttons">
                  <label class="btn btn-outline-secondary {{ in_array($tag->id, old('tags', $movementTags)) ? 'active' : '' }}">
                    <input type="checkbox"
                           name="tags[]"
                           value="{{ $tag->id }}"
                           autocomplete="off"
                           {{ in_array($tag->id, old('tags', $movementTags)) ? 'checked' : '' }}
                    > {{ $tag->tag }}
                  </label>
                </div>
              @endforeach
            </div>
          </div>

          <div class="form-group">
            <label for="amount">@lang('expenses.amount')</label>
            <input type="number"
                   class="form-control"
                   id="amount"
                   name="amount"
                   step="0.01"
                   placeholder="@lang('expenses.enter_amount')"
                   value="{{ old('amount', $movement->amount) }}"
            >
          </div>
          <button type="submit" class="btn btn-primary">@lang('common.update')</button>
        </form>
      </div>
    </div>
  </div>
@endsection
