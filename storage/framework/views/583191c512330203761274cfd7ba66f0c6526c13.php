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
<html lang="<?php echo e(App::getLocale()); ?>">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Pjax -->
    <!-- TitleBar for Chrome on Android -->
    <meta name="theme-color" content="#689F38">
    <!-- CSRF Token -->
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e(config('app.name')); ?></title>
    <!-- Styles -->
    <link rel="stylesheet" type="text/css" href="https://cdn.bootcss.com/bootstrap/3.3.6/css/bootstrap.min.css">
    <link href="/css/app.css" rel="stylesheet">
    <link href="/css/style.css" rel="stylesheet">
    <!-- Scripts -->
    <script src="https://cdn.bootcss.com/jquery/2.2.4/jquery.min.js"></script>
    <script src="https://cdn.bootcss.com/jquery.pjax/1.9.6/jquery.pjax.min.js"></script>
    <script src="https://cdn.bootcss.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    
    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>;
        $(document).pjax('a', '#pjax-container');
        $(document).on("pjax:timeout", function(event) {
        // 阻止超时导致链接跳转事件发生
            event.preventDefault()
        });
        // Flash
        $('#flash-overlay-modal').modal();
        $('div.alert').not('.alert-important').delay(3000).fadeOut(350);
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
                    <a class="navbar-brand" href="<?php echo e(url('/')); ?>">
                        <?php echo e(config('app.name')); ?>

                    </a>
                </div>
                <div class="collapse navbar-collapse" id="app-navbar-collapse">
                    <!-- Left Side Of Navbar -->
                    <ul class="nav navbar-nav">
                        <li><a href="<?php echo e(route('topics.index')); ?>"><?php echo app('translator')->getFromJson('global.topics'); ?></a></li>
                        <li><a href="<?php echo e(route('wiki.index')); ?>"><?php echo app('translator')->getFromJson('global.wiki'); ?></a></li>
                        <li><a href="<?php echo e(route('about')); ?>"><?php echo app('translator')->getFromJson('global.about'); ?></a></li>
                    </ul>
                    <!-- Right Side Of Navbar -->
                    <ul class="nav navbar-nav navbar-right">
                        <!-- Search -->
                        <li>
                            <form class="nav-form" action="<?php echo e(route('search')); ?>" method="POST" class="form-inline" target="_blank">
                                <input type="text" name="query" required class="form-control" placeholder="<?php echo app('translator')->getFromJson('global.search'); ?>">
                            </form>
                        </li>
                        <!-- Authentication Links -->
                        <?php if(Auth::guest()): ?>
                            <li><a href="<?php echo e(url('/login')); ?>"><?php echo app('translator')->getFromJson('global.login'); ?></a></li>
                            <li><a href="<?php echo e(url('/register')); ?>"><?php echo app('translator')->getFromJson('global.register'); ?></a></li>
                        <?php else: ?>
                            <a href="<?php echo e(route('users.show', $account->username)); ?>"><img alt="avatar" src="/avatars/<?php echo e($account->id); ?>.png" width="32" height="32" /></a>
                            <a href="<?php echo e(route('users.show', $account->username) . '#notifications'); ?>"><span class="badge"><?php echo e($account->notification_count); ?></span></a>
                            <li class="dropdown">
                                <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                    <?php echo e($account->username); ?> <span class="caret"></span>
                                </a>
                                <ul class="dropdown-menu" role="menu">
                                    <li>
                                        <a href="<?php echo e(url('/logout')); ?>"
                                            onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();">
                                            <?php echo app('translator')->getFromJson('global.logout'); ?>
                                        </a>
                                        <form id="logout-form" action="<?php echo e(url('/logout')); ?>" method="POST" style="display: none;">
                                            <?php echo e(csrf_field()); ?>

                                        </form>
                                    </li>
                                </ul>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </nav>
        </header>
        <!-- Nav -->
        <div class="container">
            <?php if(Auth::check() && $account->status < 0): ?>
            <div class="alert alert-danger">
                <?php echo app('translator')->getFromJson('global.user_banned'); ?>
            </div>
            <?php else: ?>
                <?php if(Auth::check() && $account->status == 0): ?>
                    <div class="alert alert-warning">
                        <?php echo app('translator')->getFromJson('global.confirm_email_request'); ?>
                    </div>
                <?php endif; ?>
                <div class="main-content" id="pjax-container">
                    <?php echo $__env->make('flash::message', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    <?php if(isset($errors) && count($errors) > 0): ?>
                        <div class="alert alert-danger">
                            <p>There were some problems with your input.</p>
                            <ul>
                                <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><i class="glyphicon glyphicon-remove"></i> <?php echo e($error); ?></li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    <?php endif; ?>
                    <!-- Breadcrumbs -->
                    <?php if(Breadcrumbs::exists(Route::currentRouteName())): ?>
                        <?php echo Breadcrumbs::renderIfExists(); ?>

                    <?php endif; ?>
                    <?php echo $__env->yieldContent('content'); ?>
                    <!-- SideBar -->
                    <!--<div class="pull-right">
                        <?php echo $__env->make('layouts.sidebar', array_except(get_defined_vars(), array('__data', '__path')))->render(); ?>
                    </div>-->
                </div>
        <?php endif; ?>
    </div>
</div>
<!-- Scripts -->
<script src="/js/app.js"></script>
<script src="https://cdn.bootcss.com/mathjax/2.7.0/MathJax.js"></script>
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