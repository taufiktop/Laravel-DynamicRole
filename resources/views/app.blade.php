<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8" />
    <meta name="app_key" content="{{ config('app.key') }}">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0" />
    <link href="https://cdn.jsdelivr.net/npm/animate.css@3.5.1" rel="stylesheet" type="text/css">
    <link rel="shortcut icon" type="image/png" sizes="96x96"
      href="{{ url('/favicon.ico') }}" 
    >
   
    <link href="{{ url(mix('/css/app.css')) }}" rel="stylesheet" />
    <script src="{{ url(mix('/js/app.js')) }}" defer></script>
    @routes
  </head>
  <body class="antialiased text-gray-900">
    @inertia
  </body>
</html>
