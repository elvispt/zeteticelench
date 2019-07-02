<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">

  <!-- CSRF Token -->
  <meta name="csrf-token" content="{{ csrf_token() }}">

  <title>{{ config('app.name', 'Laravel') }}</title>

  <!-- Scripts -->
  <script src="{{ asset('js/app.js') }}" defer></script>

  <!-- Fonts -->
  <link rel="dns-prefetch" href="//fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css?family=Nunito" rel="stylesheet" type="text/css">

  <!-- Styles -->
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">

  <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="/favicon-16x16.png">
  <link rel="manifest" href="/site.webmanifest">
  <link rel="mask-icon" href="/safari-pinned-tab.svg" color="#5bbad5">
  <meta name="msapplication-TileColor" content="#da532c">
  <meta name="theme-color" content="#ffffff">
  @yield('headers')
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
                 href="{{ route('hackernews-top') }}"
              >@lang('hackernews.hackernews')</a>
            </li>
          @endif
        </ul>

        <div class="d-none d-md-block">
          @include('common/inspire')
        </div>

        <!-- Right Side Of Navbar -->
        <ul class="navbar-nav ml-auto">

          <li class="nav-item">
            <a class="nav-link {{ \Illuminate\Support\Str::startsWith($currentRouteName, 'users') ? 'text-primary' : '' }}"
               href="{{ route('users-list') }}"
            >@lang('users.users')</a>
          </li>

          <!-- Authentication Links -->
          @guest
            <li class="nav-item">
              <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
            </li>
            @if (Route::has('register'))
              <li class="nav-item">
                <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
              </li>
            @endif
          @else
            <li class="nav-item dropdown">
              <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown"
                 aria-haspopup="true" aria-expanded="false" v-pre>
                {{ Auth::user()->name }} <span class="caret"></span>
              </a>

              <div class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdown">
                <a class="dropdown-item"
                   href="{{ route('users-edit', ['id' => \Illuminate\Support\Facades\Auth::id()]) }}"
                >@lang('users.user-edit')
                </a>
                <a class="dropdown-item" href="{{ route('logout') }}"
                   onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                  @lang('users.logout')
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                  @csrf
                </form>
              </div>
            </li>
          @endguest
        </ul>
      </div>
    </div>
  </nav>

  <main class="pb-4">
    @include('common.errors')
    @yield('content')
  </main>
</div>
</body>
</html>
