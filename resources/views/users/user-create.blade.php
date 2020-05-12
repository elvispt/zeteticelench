@extends('app')

@section('title') @lang('users.new-user') @endsection

@section('content')
  <div class="container">

    @include('users.top-submenu')

    <div class="row justify-content-center">
      <div class="col-12">
        <form action="{{ route('users-create') }}" method="post">
          @csrf
          <div class="card mt-3 shadow">
            <div class="card-header text-center">
              @lang('users.users')
            </div>
            <div class="card-body">
              <div class="form-group row">
                <label for="name" class="col-sm-2 col-form-label">@lang('users.name')</label>
                <div class="col-sm-10">
                  <input type="text"
                         class="form-control"
                         id="name"
                         name="name"
                         value="{{ old('name') }}"
                         required
                  >
                  @error('name')
                    <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="email" class="col-sm-2 col-form-label">@lang('users.email')</label>
                <div class="col-sm-10">
                  <input type="email"
                         inputmode="email"
                         autocomplete="email"
                         class="form-control"
                         id="email"
                         name="email"
                         value="{{ old('email') }}"
                         required
                  >
                  @error('email')
                    <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="password" class="col-sm-2 col-form-label">@lang('users.password')</label>
                <div class="col-sm-10">
                  <input type="password"
                         class="form-control"
                         id="password"
                         name="password"
                         required
                  >
                  @error('password')
                    <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
                </div>
              </div>
              <div class="form-group row">
                <label for="password_confirmation" class="col-sm-2 col-form-label">@lang('users.password_confirmation')</label>
                <div class="col-sm-10">
                  <input type="password"
                         class="form-control"
                         id="password_confirmation"
                         name="password_confirmation"
                         required
                  >
                  @error('password_confirmation')
                    <small class="form-text text-danger">{{ $message }}</small>
                  @enderror
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
