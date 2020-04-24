<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="stylesheet" href="{{ mix('/css/app.css') }}" />

        <title>pWire - @yield('title')</title>
    </head>
    <body>
        <nav class="navbar" role="navigation" aria-label="main navigation">
            <div class="navbar-brand">
                <a class="navbar-item" href="/">
                    <img src="/img/logo.svg" width="112" height="28" alt="pWire Logo">
                </a>

                <a role="button" class="navbar-burger burger" aria-label="menu" aria-expanded="false" data-target="pwireNavigationBar">
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                    <span aria-hidden="true"></span>
                </a>
            </div>

            <div id="pwireNavigationBar" class="navbar-menu">
                <div class="navbar-start">
                    <a class="navbar-item">
                        Dashboard
                    </a>

                    <a class="navbar-item">
                        Event Log
                    </a>

                    <div class="navbar-item has-dropdown is-hoverable">
                        <a class="navbar-link">
                            Settings
                        </a>

                        <div class="navbar-dropdown">
                            <a class="navbar-item">
                                User Settings
                            </a>
                            <a class="navbar-item">
                                Plattform Settings
                            </a>
                        </div>
                    </div>

                    <a class="navbar-item" href="/add_sensor">
                        Add Sensor
                     </a>
                </div>

                <div class="navbar-end">
                    <div class="navbar-item">
                        <div class="buttons">
                            <a class="button is-light">
                                Log in
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <div id="app">
            <div class="container">
                @yield('content')
            </div>
        </div>
        <script src="{{ mix('/js/app.js') }}"></script>
    </body>
</html>
