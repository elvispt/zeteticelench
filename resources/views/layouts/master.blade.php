<html lang="en">
<head>
  <title>Notes</title>
</head>
<body>
@if (Auth::check())
  <a href="{{ route('logout') }}">Log me out</a>
@endif
@yield('content')
</body>
</html>
