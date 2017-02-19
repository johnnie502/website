<?php
/*
  * Breadcrumbs for Laravel
   */

# ------------------ Page ------------------------
Breadcrumbs::register('index', function($breadcrumbs)
{
    $breadcrumbs->push('主页', route('index'));
});

Breadcrumbs::register('about', function($breadcrumbs)
{
    $breadcrumbs->parent('index');
    $breadcrumbs->push('关于', route('about'));
});

# ------------------ Topic ------------------------
Breadcrumbs::register('topics.index', function($breadcrumbs)
{
    $breadcrumbs->parent('index');
    $breadcrumbs->push('社区', route('topics.index'));
});

Breadcrumbs::register('topics.create', function($breadcrumbs)
{
    $breadcrumbs->parent('topics.index');
    $breadcrumbs->push('发表主题', route('topics.create'));
});

Breadcrumbs::register('topics.show', function($breadcrumbs)
{
    $breadcrumbs->parent('topics.index');
    $breadcrumbs->push('查看主题', route('topics.show'));
});

Breadcrumbs::register('topics.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('topics.index');
    $breadcrumbs->push('编辑主题', route('topics.edit'));
});

# ------------------ Wiki ------------------------
Breadcrumbs::register('wiki.index', function($breadcrumbs)
{
    $breadcrumbs->parent('index');
    $breadcrumbs->push('百科', route('wiki.index'));
});

Breadcrumbs::register('wiki.create', function($breadcrumbs)
{
    $breadcrumbs->parent('wiki.index');
    $breadcrumbs->push('创建条目', route('wiki.create'));
});

Breadcrumbs::register('wiki.show', function($breadcrumbs)
{
    $breadcrumbs->parent('wiki.index');
    $breadcrumbs->push('查看条目', route('wiki.show'));
});

Breadcrumbs::register('wiki.edit', function($breadcrumbs)
{
    $breadcrumbs->parent('wiki.index');
    $breadcrumbs->push('编辑条目', route('wiki.edit'));
});

# ------------------ User ------------------------
Breadcrumbs::register('users', function($breadcrumbs)
{
    $breadcrumbs->push('用户中心', route('users.index'));
});

# ------------------ Auth ------------------------
Breadcrumbs::register('login', function($breadcrumbs)
{
    $breadcrumbs->parent('users');
    $breadcrumbs->push('登录', route('login'));
});

Breadcrumbs::register('register', function($breadcrumbs)
{
    $breadcrumbs->parent('users');
    $breadcrumbs->push('注册', route('register'));
});