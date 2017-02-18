<!--
______                            _              _                                     _
| ___ \                          | |            | |                                   | |
| |_/ /___ __      __ ___  _ __  | |__   _   _  | |      __ _  _ __  __ _ __   __ ___ | |
|  __// _ \\ \ /\ / // _ \| '__| | '_ \ | | | | | |     / _` || '__|/ _` |\ \ / // _ \| |
| |  | (_) |\ V  V /|  __/| |    | |_) || |_| | | |____| (_| || |  | (_| | \ V /|  __/| |
\_|   \___/  \_/\_/  \___||_|    |_.__/  \__, | \_____/ \__,_||_|   \__,_|  \_/  \___||_|
                                          __/ |
                                         |___/
  =====================================================================================
                                       mpcblab.com                                     
  -------------------------------------------------------------------------------------
                                     Laravel: v5.4.x                                   
-->
<!DOCTYPE html>
<html lang="{{ App::getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Pjax -->
    <!-- TitleBar for Chrome on Android -->
    <meta name="theme-color" content="#689F38">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="/css/app.css" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery.pjax/1.9.6/jquery.pjax.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    {{-- <script src="{{ elixir('js/app.js') }}"></script> --}}
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        $(document).pjax('a', '#pjax-container');
        $(document).on("pjax:timeout", function(event) {
        // 阻止超时导致链接跳转事件发生
            event.preventDefault()
        });
    </script>
</head>

<body>
    <div id="app">
        <header>
        <nav class="navbar navbar-default navbar-static-top">
            <div class="container">
                <div class="navbar-header">
                    <!-- Collapsed Hamburger -->
                    <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#app-navbar-collapse">
                        <span class="sr-only">Toggle Navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!-- Branding Image -->
                    <a class="navbar-brand" href="{{ url('/') }}">
                        {{ config('app.name') }}
                    </a>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="{{ url('/topics') }}">Topic</a></li>
                        <li><a href="{{ url('/wiki') }}">Wiki</a></li>
                        <li><a href="{{ url('/about') }}">About</a></li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Authentication Links -->
                        @if (Auth::guest())
                            <li><a href="{{ url('/login') }}">Login</a></li>
                            <li><a href="{{ url('/register') }}">Register</a></li>
                        @else
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">
                                    {{ Auth::user()->name }} <span class="caret"></span>
                                </a>

                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            Logout
                                        </a>

                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </li>
                                </ul>
                            </li>
                        @endif
                    </ul>
                </div>
            </div>
        </nav>
        </header>
        <!-- Nav -->
        <div class="container">
            @if (Auth::check() && $user->status < 0)
            <div class="alert alert-danger">
                Your account was banned.
            </div>
            @else
                @if (Auth::check() && $user->status == 0)
                    <div class="alert alert-warning">
                        You have't confirm your email address yet.
                    </div>
                @endif
                @include('flash::message')
                @if (isset($errors) && count($errors) > 0)
                    <div class="alert alert-danger">
                        <p>There were some problems with your input.</p>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li><i class="glyphicon glyphicon-remove"></i> {{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <!-- Breadcrumbs -->
                <div class="main-content" id="pjax-container">
                    @yield('content')
                </div>
        @endif
    </div>
</div>
<!-- Scripts -->
<script src="/js/app.js"></script>
<footer>
    <div class="container small">
        <p class="pull-left">
            <i class="fa fa-heart-o"></i>&copy; 2014~2017 MPCBLAB</a>. <br>
            <i class="fa fa-lightbulb-o"></i>Inspired by v2ex & phphub.
        </p>
        <p class="pull-right">
            <i class="fa laravel"></i>Power By <a href="https://laravel.com/" title="Laravel 5" target="_blank"><img src="https://laravel.com/assets/img/laravel-logo.png" alt="Laravel 5"></a><br>
            <i class="fa laravel"></i>由<a href="https://laravel.com/" title="Laravel 5" target="_blank">Laravel</a>强力驱动
        </p>
    </div>
</footer>
</body>
</html>