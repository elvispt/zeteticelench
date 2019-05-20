@extends('layouts/app')

@section('content')
  <div class="container">
    <div class="row">
      <div class="col-12">
        <a href="#"
           class="btn btn-dark"
        >@lang('users.new-user')</a>
      </div>
    </div>
    <div class="row justify-content-center">
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
                    <a href="#" class="btn btn-link text-danger btn-outline-danger">@lang('users.delete')</a>
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
