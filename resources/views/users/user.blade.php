@extends('layouts/app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <a href="{{ route('users-create') }}"
           class="btn btn-dark"
        >@lang('users.new-user')</a>
      </div>
    </div>
    <div class="row justify-content-center">
      <div class="col-12">
        <form action="{{ route('users-update') }}" method="post">
          @csrf
          @method('PUT')
          <div class="card mt-3">
            <div class="card-header text-center">
              @lang('users.users')
              |
              @if ($currentUserId === $user->id)
                <small class="text-success">you</small>
              @endif
            </div>
            <div class="card-body">
              <div class="form-group row">
                <label for="user-id" class="col-sm-2 col-form-label">#</label>
                <div class="col-sm-10">
                  <input id="user-id"
                         readonly
                         type="text"
                         name="user-id"
                         class="form-control-plaintext"
                         value="{{ $user->id }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">@lang('users.name')</label>
                <div class="col-sm-10">
                  <input type="text"
                         class="form-control"
                         id="name"
                         name="name"
                         value="{{ $user->name }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">@lang('users.email')</label>
                <div class="col-sm-10">
                  <input type="text"
                         class="form-control-plaintext"
                         id="email"
                         value="{{ $user->email }}">
                </div>
              </div>
              <div class="form-group row">
                <label for="email-verified" class="col-sm-2 col-form-label">@lang('users.email_verified_at')</label>
                <div class="col-sm-10">
                  <input id="email-verified"
                         readonly
                         type="text"
                         class="form-control-plaintext"
                         @if ($user->email_verified_at)
                           value="{{ $user->email_verified_at }} | {{ \Illuminate\Support\Carbon::make($user->email_verified_at)->diffForHumans() }}"
                         @else
                           placeholder="-"
                         @endif
                  >
                </div>
              </div>
              <div class="form-group row">
                <label for="created-at" class="col-sm-2 col-form-label">@lang('users.created_at')</label>
                <div class="col-sm-10">
                  <input id="created-at"
                         readonly
                         type="text"
                         class="form-control-plaintext"
                         @if ($user->created_at)
                           value="{{ $user->created_at }} | {{ \Illuminate\Support\Carbon::make($user->created_at)->diffForHumans() }}"
                         @else
                           placeholder="-"
                         @endif

                  >
                </div>
              </div>
              <div class="form-group row">
                <label for="updated-at" class="col-sm-2 col-form-label">@lang('users.updated_at')</label>
                <div class="col-sm-10">
                  <input id="updated-at"
                         readonly
                         type="text"
                         class="form-control-plaintext"
                         @if ($user->updated_at)
                           value="{{ $user->updated_at }} | {{ \Illuminate\Support\Carbon::make($user->updated_at)->diffForHumans() }}"
                         @else
                           placeholder="-"
                         @endif
                  >
                </div>
              </div>
            </div>
            <div class="card-footer text-muted">
              <button type="submit" class="btn btn-primary">@lang('users.save')</button>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>
@endsection
