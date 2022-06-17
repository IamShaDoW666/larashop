<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta value="{{ csrf_token() }}">

  <title inertia>{{ config('app.name', 'Laravel') }}</title>

  <!-- Fonts -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
  <!-- Styles -->
  <link rel="stylesheet" href="{{ mix('css/app.css') }}">



  <!-- Scripts -->
  @routes
  <script src="{{ mix('js/app.js') }}" defer></script>
  @inertiaHead
</head>

<body class="antialiased">
  @inertia

  <!-- @env ('local')
  <script src="http://localhost:8080/js/bundle.js"></script>
  @endenv -->
  <link href="https://cdn.lineicons.com/3.0/lineicons.css" rel="stylesheet">
  <script src="https://kit.fontawesome.com/0406cef030.js" crossorigin="anonymous"></script>
</body>

</html>