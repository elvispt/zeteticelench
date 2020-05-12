<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  @hasSection('title')
    <title>@yield('title') - {{ config('app.name', 'Laravel') }}</title>
  @else
    <title>{{ config('app.name', 'Laravel') }}</title>
  @endif

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Inconsolata:wght@400;700&family=Nunito&display=swap" rel="stylesheet">

  <!-- Styles -->
  <link href="{{ mix('css/app.css') }}" rel="stylesheet">

  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">

  @hasSection('meta')
    @yield('meta')
  @endif
</head>
<body>
<div id="app">
  <nav class="navbar navbar-expand-md navbar-light navbar-laravel">
    @php $currentRouteName = Route::getCurrentRoute()->getName(); @endphp
    <div class="container">
      <a class="navbar-brand" href="{{ url('/') }}">
        {{ config('app.name', 'Laravel') }}
      </a>
      <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent"
              aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <!-- Left Side Of Navbar -->
        <ul class="navbar-nav mr-auto">
          @if (\Illuminate\Support\Facades\Auth::check())
            <li class="nav-item">
              <a class="nav-link {{ \Illuminate\Support\Str::startsWith($currentRouteName, 'notes') ? 'text-primary' : '' }}"
                 href="{{ route('notes') }}"
              >@lang('notes.notes')</a>
            </li>

            <li class="nav-item">
              <a class="nav-link {{ \Illuminate\Support\Str::startsWith($currentRouteName, 'hackernews') ? 'text-primary' : '' }}"
                 href="{{ route('hackernews') }}"
              >@lang('hackernews.hackernews')</a>
            </li>

            <li class="nav-item">
              <a class="nav-link {{ \Illuminate\Support\Str::startsWith($currentRouteName, 'users') ? 'text-primary' : '' }}"
                 href="{{ route('users-list') }}"
              >@lang('users.users')</a>
            </li>
          @endif
        </ul>

        <div class="d-none d-md-block">
          @include('common.inspire')
        </div>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">
          @if (\Illuminate\Support\Facades\Auth::check())
            <li class="nav-item">
              <a class="nav-link"
                 href="#"
                 onclick="event.preventDefault();document.getElementById('logout-form').submit();"
              >@lang('users.logout')</a>
              <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                @csrf
              </form>
            </li>
          @endif
        </ul>

      </div>
    </div>
  </nav>

  <main class="pb-4">
    @include('common.errors')
    @yield('content')
  </main>
</div>
<!-- Scripts -->
@stack('scripts')
</body>
</html>