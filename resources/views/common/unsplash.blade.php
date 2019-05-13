@if (!empty($unsplash))
  <style>
    body {
      background-size: cover !important;;
      background-image: url({{ $unsplash->url }}) !important;
      background-color: {{ $unsplash->bg }} !important;
    }
  </style>
@endif
