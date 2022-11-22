<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css">
<link rel="stylesheet" href="/css/admin_create.css" type="text/css">
<link rel="stylesheet" href="/sass/register_button.scss" type="text/scss">
<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->
    <link rel="dns-prefetch" href="//fonts.gstatic.com">
    <link href="https://fonts.bunny.net/css?family=Nunito" rel="stylesheet">

    <!-- Scripts -->
    @vite(['resources/sass/app.scss', 'resources/sass/register_button.sass','resources/js/app.js','resources/js/register_button.js'])
</head>
<body>
    <div id="app">
        <nav class="navbar navbar-expand-md navbar-light bg-white shadow-sm">
            <div class="container">
                <a class="navbar-brand" href="{{ url('/') }}">
                    {{ __('MARUOKUN') }}
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="{{ __('Toggle navigation') }}">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <!-- Left Side Of Navbar -->
                    <ul class="navbar-nav me-auto">

                    </ul>

                    <!-- Right Side Of Navbar -->
                    <ul class="navbar-nav ms-auto">
                        <!-- Authentication Links -->
                        @if(!Auth::check() && (!isset($authgroup) || !Auth::guard($authgroup)->check()))
                            @if (Route::has('login'))
                                <li class="nav-item">
                                    @isset($authgroup)
                                    <a class="nav-link" href="{{ url("$authgroup/login") }}">{{ __('Login') }}</a>
                                    @else
                                    <a class="nav-link" href="{{ route('parttimer/login') }}">{{ __('Login') }}</a>
                                    @endisset
                                </li>
                            @endif

                            @if (Route::has('register'))
                                @isset($authgroup)
                                        @if (Route::has("$authgroup-register"))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route("$authgroup-register") }}">{{ __('Register') }}</a>
                                            </li>
                                        @endif
                                    @else
                                        @if (Route::has('register'))
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{ route('parttimer-register') }}">{{ __('Register') }}</a>
                                            </li>
                                        @endif
                                @endisset
                            @endif
                        @else
                            <li class="nav-item dropdown">
                                <a id="navbarDropdown" class="nav-link dropdown-toggle" href="#" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" v-pre>
                                    @isset($authgroup)
                                    {{ Auth::guard($authgroup)->user()->name }}
                                    @else
                                    {{ Auth::user()->name }}
                                    @endisset
                                </a>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>

        <main class="py-4">
            @yield('content')
        </main>
    </div>
</body>
</html>
