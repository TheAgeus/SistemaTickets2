<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Sistema Tickets 2</title>

        <link rel="stylesheet" href="/css/welcome-view/main.css">

    </head>

    <body class="">

        <div class="toggle-color-mode-btn">
            Light Mode
        </div>

        <h1>
            Sistema de Tickets 2
        </h1>

        @if (Route::has('login'))
                <div class="welcome-links">
                    @auth
                        <a href="{{ url('/dashboard') }}">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}">Log in</a>

                        @if (Route::has('register'))
                            <a href="{{ route('register') }}">Register</a>
                        @endif
                    @endauth
                </div>
            @endif
    </body>

    <script src="{{asset("/js/welcome-view/main.js")}}"></script>

</html>
