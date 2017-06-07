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
    <title>@yield('title') - {{ config('app.name') }}</title>
    <!-- Styles -->
    <link href="https://cdn.bootcss.com/iview/2.0.0-rc.16/styles/iview.css" rel="stylesheet">
    <link href="https://cdn.bootcss.com/social-share.js/1.0.16/css/share.min.css" rel="stylesheet">
    <link href="/css/mint.css" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://cdn.bootcss.com/mithril/1.1.1/mithril.min.js"></script>
    <script src="https://cdn.bootcss.com/vue/2.3.3/vue.min.js"></script>
    <script src="https://cdn.bootcss.com/iview/2.0.0-rc.16/iview.min.js"></script>
    <script src="https://cdn.bootcss.com/social-share.js/1.0.16/js/social-share.min.js"></script>
    <script>
        window.Laravel = {!! json_encode([
            'csrfToken' => csrf_token(),
        ]) !!};
        // Pjax and progress.
        document.addEventListener('pjax:start', function() {
            this.$Loading.start();
        });
        document.addEventListener('pjax:end', function() {
            this.$Loading.finish();
        });
        // Prevent timeout event jump to links.
        document.addEventListener("pjax:timeout", function(event) {
            event.preventDefault();
            this.$Loading.error();
        });
        // Piwik
        var _paq = _paq || [];
        /* tracker methods like "setCustomDimension" should be called before "trackPageView" */
        _paq.push(['trackPageView']);
        _paq.push(['enableLinkTracking']);
        (function() {
            var u="{{ Config('piwik.piwik_url') }}";
            _paq.push(['setTrackerUrl', u+'piwik.php']);
            _paq.push(['setSiteId', {{ Config('piwik.site_id') }}]);
            var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
            g.type='text/javascript';
            g.async=true; g.defer=true;
            g.src='https://cdn.bootcss.com/piwik/3.0.3-b2/piwik.js';
            s.parentNode.insertBefore(g,s);
        })();
    </script>
</head>

<body>
    <div id="app">
        <header>
            <template>
                <!-- Nav -->
                <nav>
                    <!-- Menus -->
                    <menu mode="horizontal" :theme="light" active-name="index">
                        <menu-item name="index">{{ config('app.name') }}</menu-item>
                        <menu-item name="topics"><a href="{{ route('topics.index') }}">@lang('global.topics')</a></menu-item>
                        <menu-item name="wiki"><a href="{{ route('wiki.index') }}">@lang('global.wiki')</a></menu-item>
                        <menu-item name="about"><a href="{{ route('about') }}">@lang('global.about')</a></menu-item>
                    </menu>
                    <!-- Search -->
                    <form class="nav-form" action="{{ route('search') }}" method="POST" class="form-inline" target="_blank">
                        <input type="text" name="query" required class="form-control" placeholder="@lang('global.search')">
                    </form>
                    <!-- Authentication Links -->
                    @if (Auth::guest())
                        <li><a href="{{ url('/login') }}">@lang('global.login')</a></li>
                        <li><a href="{{ url('/register') }}">@lang('global.register')</a></li>
                    @else
                        <a href="{{ route('users.show', $account->username) }}"><img alt="avatar" src="/avatars/{{ $account->id }}.png" width="32" height="32"></a>
                        <a href="{{ route('users.show', $account->username) . '#notifications' }}"><span class="badge">{{ $account->notification_count }}</span></a>
                        <template>
                            <dropdown>
                                <a href="#" class="dropdown-toggle">
                                    {{ $account->username }} <span class="caret"></span>
                                </a>
                                <dropdown-menu slot="list">
                                    <dropdown-item>
                                        <a href="{{ url('/logout') }}"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            @lang('global.logout')
                                        </a>
                                        <form id="logout-form" action="{{ url('/logout') }}" method="POST" style="display: none;">
                                            {{ csrf_field() }}
                                        </form>
                                    </dropdown-item>
                                </dropdown-menu>
                            </dropdown>
                        </template>
                    @endif
                </nav>
            </template>
        </header>
        <div class="container">
            @if (Auth::check() && $account->status <= -3)
            <template>
                <alert type="error" show-icon closeable>
                    @lang('global.user_banned')
                </alert>
            </template>
            @else
                @if (Auth::check() && $account->status == 0)
                    <template>
                        <alert type="warning" show-icon closeable>
                            @lang('global.confirm_email_request')
                        </alert>
                    </template>
                @endif
                <div class="main-content" id="pjax-container">
                    @include('flash::message')
                    @if (isset($errors) && count($errors) > 0)
                        <template>
                            <alert type="error" show-icon closeable>
                                There were some problems with your input.
                                <span slot="desc">
                                    @foreach ($errors->all() as $error)
                                        {{ $error }}
                                    @endforeach
                                </span>
                            </alert>
                        </template>
                    @endif
                    <!-- Breadcrumbs -->
                    @if (Breadcrumbs::exists(Route::currentRouteName()))
                        {!! Breadcrumbs::renderIfExists() !!}
                    @endif
                    @yield('content')
                    <!-- SideBar -->
                    <div class="col-md-3 side-bar">
                        @include('layouts.sidebar')
                    </div>
                </div>
            @endif
        </div>
    </div>
<!-- Scripts -->
<script src="https://cdn.bootcss.com/mathjax/2.7.0/MathJax.js"></script>
<script src="/js/app.js"></script>
<footer>
    <div class="container small">
        <p class="pull-left">
            <i class="fa fa-heart-o"></i>&copy; 2014~2017 MPCBLAB</a>. <br>
            <i class="fa fa-lightbulb-o"></i>Inspired by v2ex & phphub.
        </p>
        <p class="pull-right">
            <i class="fa laravel"></i>Powered By <a href="https://laravel.com/" title="Laravel 5" target="_blank"><img src="https://laravel.com/assets/img/laravel-logo.png" alt="Laravel 5"></a><br>
            <i class="fa laravel"></i>由<a href="https://laravel.com/" title="Laravel 5" target="_blank">Laravel</a>强力驱动
        </p>
    </div>
</footer>
</body>
</html>