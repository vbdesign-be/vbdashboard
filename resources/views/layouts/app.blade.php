<!DOCTYPE html>
<html lang="en">
<head>
    <title>@yield('title')</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,wght@0,400;0,500;0,700;1,400&display=swap">
    <link rel="stylesheet" href="css/tailwind/tailwind.min.css">
    <link rel="stylesheet" href="{{ URL::asset('css/tailwind/tailwind.min.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/main.css') }}">
    <link rel="stylesheet" href="{{ URL::asset('css/app.css') }}">
    <link rel="icon" type="image/png" sizes="16x16" href="favicon-tailwind.png">
    <script src="js/main.js"></script>
    
  </head>
  <body class="antialiased bg-body text-body font-body">

    @yield('content')

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
    <script src="js/charts-demo.js"></script>
    <script src="{{ URL::asset('js/app.js') }}"></script>
    <script type="text/javascript" src="https://assets.calendly.com/assets/external/widget.js"></script>
    
</body>
</html>