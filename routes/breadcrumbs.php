<?php
/*
  * Breadcrumbs for Laravel
   */

# ------------------ Page ------------------------
Breadcrumbs::register('index', function($breadcrumbs)
{
    $breadcrumbs->push(Lang::get('global.home'), route('index'));
});

Breadcrumbs::register('about', function($breadcrumbs)
{
    $breadcrumbs->parent('index');
    $breadcrumbs->push(Lang::get('global.about'), route('about'));
});

# ------------------ Topic ------------------------
Breadcrumbs::register('topics.index', function($breadcrumbs)
{
    $breadcrumbs->parent('index');
    $breadcrumbs->push(Lang::get('global.topics'), route('topics.index'));
});

Breadcrumbs::register('topics.create', function($breadcrumbs)
{
    $breadcrumbs->parent('topics.index');
    $breadcrumbs->push('发表主题', route('topics.create'));
});

Breadcrumbs::register('topics.show', function($breadcrumbs, $topic)
{
    if (isset($topic->id)) {
        $breadcrumbs->parent('topics.index');
        $breadcrumbs->push('查看主题: ' . $topic->title, route('topics.show', $topic->id));
    }
});

Breadcrumbs::register('topics.edit', function($breadcrumbs, $topic)
{
    if (isset($topic->id)) {
        $breadcrumbs->parent('topics.index');
        $breadcrumbs->push('编辑主题: ' . $topic->title, route('topics.edit', $topic));
    }
});

# ------------------ Wiki ------------------------
Breadcrumbs::register('wiki.index', function($breadcrumbs)
{
    $breadcrumbs->parent('index');
    $breadcrumbs->push(Lang::get('global.wiki'), route('wiki.index'));
});

Breadcrumbs::register('wiki.create', function($breadcrumbs)
{
    $breadcrumbs->parent('wiki.index');
    $breadcrumbs->push('创建条目', route('wiki.create'));
});

Breadcrumbs::register('wiki.show', function($breadcrumbs, $wiki)
{
    if (isset($wiki->id)) {
        $breadcrumbs->parent('wiki.index');
        $breadcrumbs->push('查看条目:' . $wiki->title, route('wiki.show', $wiki));
    }
});

Breadcrumbs::register('wiki.edit', function($breadcrumbs, $wiki)
{
    if (isset($wiki->id)) {
        $breadcrumbs->parent('wiki.index');
        $breadcrumbs->push('编辑条目:' . $wiki, route('wiki.edit', $wiki));
    }
});

# ------------------ User ------------------------
Breadcrumbs::register('users', function($breadcrumbs)
{
    $breadcrumbs->push(Lang::get('global.users'), route('users.index'));
});

# ------------------ Auth ------------------------
Breadcrumbs::register('login', function($breadcrumbs)
{
    $breadcrumbs->parent('index');
    $breadcrumbs->push(Lang::get('global.login'), route('login'));
});

Breadcrumbs::register('register', function($breadcrumbs)
{
    $breadcrumbs->parent('index');
    $breadcrumbs->push(Lang::get('global.register'), route('register'));
});

Breadcrumbs::register('password.request', function($breadcrumbs)
{
    $breadcrumbs->parent('index');
    $breadcrumbs->push(Lang::get('global.reset_password'), route('password.request'));
});