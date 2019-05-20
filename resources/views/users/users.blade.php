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
      <div class="col-8">
        @error('user-id')
          <div class="alert alert-danger alert-dismissible fade show">
            {{ $message }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
        @enderror
      </div>
      <div class="col-12">
        <table class="table table-hover mt-3">
          <thead>
          <tr>
            <th>#</th>
            <th>@lang('users.name')</th>
            <th>@lang('users.email')</th>
            <th>@lang('users.created_at')</th>
            <th>@lang('users.updated_at')</th>
            <th></th>
          </tr>
          </thead>

          <tbody>
          @foreach($users as $user)
            <tr class="{{ $user->id === $currentUserId ? 'table-success' : '' }}">
              <td>{{ $user->id }}</td>
              <td>{{ $user->name }}</td>
              <td>{{ $user->email }}</td>
              <td title="{{ $user->created_at }}">
                {{ \Illuminate\Support\Carbon::make($user->created_at)->diffForHumans() }}
              </td>
              <td title="{{ $user->updated_at }}">
                {{ \Illuminate\Support\Carbon::make($user->updated_at)->diffForHumans() }}
              </td>
              <td class="text-right">
                <div class="btn-group btn-group-sm mr-2" role="group">
                  <a href="{{ route('users-edit', ['id' => $user->id]) }}" class="btn btn-link btn-outline-info">@lang('users.edit')</a>
                  @if ($user->id !== $currentUserId)
                    <a href="#" class="btn btn-link text-danger btn-outline-danger"
                       onclick="event.preventDefault(); if (confirm('Are you want to delete user ({{ $user->id }}) {{ $user->name }}?')) { document.getElementById('delete_user_{{ $user->id }}').submit(); }"
                    >@lang('users.delete')</a>

                    <form id="delete_user_{{ $user->id }}"
                          action="{{ route('users-destroy') }}"
                          method="POST" style="display: none;">
                      <input type="hidden" name="user-id" value="{{ $user->id }}">
                      @method('delete')
                      @csrf
                    </form>
                  @endif
                </div>
              </td>
            </tr>
          @endforeach
          </tbody>
        </table>
      </div>
    </div>
  </div>
@endsection
