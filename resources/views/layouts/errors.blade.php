<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ mix('/css/errors.css') }}" />
        <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
        <title>pWire - @yield('title')</title>
    </head>
    <body>
        <div id="error">
            @yield('content')
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
