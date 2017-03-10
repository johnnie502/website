<?php
/*
  * Breadcrumbs for Laravel
   */

# ------------------ Pages ------------------------
Breadcrumbs::register('index', function($breadcrumbs)
{
    $breadcrumbs->push(Lang::get('global.home'), route('index'));
});

Breadcrumbs::register('about', function($breadcrumbs)
{
    $breadcrumbs->parent('index');
    $breadcrumbs->push(Lang::get('global.about'), route('about'));
});

Breadcrumbs::register('search', function($breadcrumbs)
{
    $breadcrumbs->parent('index');
    $breadcrumbs->push(Lang::get('global.search'), route('search'));
});

Breadcrumbs::register('search.result', function($breadcrumbs, $query)
{
    $breadcrumbs->parent('search');
    $breadcrumbs->push('搜索结果:' . $query, route('search.result', $query));
});

Breadcrumbs::register('sign', function($breadcrumbs)
{
    $breadcrumbs->parent('index');
    $breadcrumbs->push('签到', route('sign'));
});

# ------------------ Nodes ------------------------
Breadcrumbs::register('nodes.index', function($breadcrumbs)
{
    $breadcrumbs->parent('index');
    $breadcrumbs->push(Lang::get('global.nodes'), route('nodes.index'));
});

Breadcrumbs::register('nodes.create', function($breadcrumbs)
{
    $breadcrumbs->parent('nodes.index');
    $breadcrumbs->push('新建节点', route('nodes.create'));
});

Breadcrumbs::register('nodes.show', function($breadcrumbs, $node)
{
    if (isset($topic->id)) {
        $breadcrumbs->parent('nodes.index');
        $breadcrumbs->push('查看节点: ' . $node->name, route('nodes.show', $node->slug));
    }
});

Breadcrumbs::register('nodes.edit', function($breadcrumbs, $node)
{
    if (isset($topic->id)) {
        $breadcrumbs->parent('nodes.index');
        $breadcrumbs->push('编辑节点: ' . $node->name, route('nodes.edit', $node));
    }
});

# ------------------ Topics ------------------------
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

# ------------------ Posts ------------------------
Breadcrumbs::register('topics.posts.index', function($breadcrumbs)
{
    $breadcrumbs->parent('topics.index');
    $breadcrumbs->push(Lang::get('global.posts'), route('topics.posts.index'));
});

Breadcrumbs::register('topics.posts.create', function($breadcrumbs)
{
    $breadcrumbs->parent('topics.posts.index');
    $breadcrumbs->push('发表回复', route('topics.posts.create'));
});

Breadcrumbs::register('topics.posts.show', function($breadcrumbs, $topic, $post)
{
    if (isset($topic->id)) {
        $breadcrumbs->parent('topics.posts.index');
        $breadcrumbs->push('查看主题: ' . $topic->title, route('topics.posts..show', $topic->id, $post->id));
    }
});

Breadcrumbs::register('topics.posts.edit', function($breadcrumbs, $topic)
{
    if (isset($topic->id)) {
        $breadcrumbs->parent('topics.posts.index');
        $breadcrumbs->push('编辑回复: ' . $topic->title, route('topics.posts.edit', $topic, $post));
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

# ------------------ Tags/Categories ------------------------
Breadcrumbs::register('topics.tags', function($breadcrumbs, $topic)
{
    if (isset($topic->id)) {
        $breadcrumbs->parent('topics.index');
        $breadcrumbs->push('标签:' . $topic, route('topics.tags', $topic));
    }
});

# ------------------ Users ------------------------
Breadcrumbs::register('users.index', function($breadcrumbs)
{
    $breadcrumbs->parent('index');
    $breadcrumbs->push(Lang::get('global.users'), route('users.index'));
});

Breadcrumbs::register('users.show', function($breadcrumbs, $user)
{
    if (isset($user->id)) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push('查看用户:' . $user->username, route('users.show', $user));
    }
});

Breadcrumbs::register('users.edit', function($breadcrumbs, $user)
{
    if (isset($user->id)) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push('编辑用户:' . $user->username, route('users.edit', $user));
    }
});

Breadcrumbs::register('users.topics', function($breadcrumbs, $user)
{
    if (isset($user->id)) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push('查看用户:' . $user->username, route('users.topics', $user));
    }
});

Breadcrumbs::register('users.replies', function($breadcrumbs, $user)
{
    if (isset($user->id)) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push('查看用户:' . $user->username, route('users.replies', $user));
    }
});

Breadcrumbs::register('users.created_wiki', function($breadcrumbs, $user)
{
    if (isset($user->id)) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push('查看用户:' . $user->username, route('users.created_wiki', $user));
    }
});

Breadcrumbs::register('users.edited_wiki', function($breadcrumbs, $user)
{
    if (isset($user->id)) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push('查看用户:' . $user->username, route('users.edited_wiki', $user));
    }
});

Breadcrumbs::register('users.followers', function($breadcrumbs, $user)
{
    if (isset($user->id)) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push('查看用户:' . $user->username, route('users.followers', $user));
    }
});

Breadcrumbs::register('users.following', function($breadcrumbs, $user)
{
    if (isset($user->id)) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push('查看用户:' . $user->username, route('users.following', $user));
    }
});

Breadcrumbs::register('users.votes', function($breadcrumbs, $user)
{
    if (isset($user->id)) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push('查看用户:' . $user->username, route('users.votes', $user));
    }
});

Breadcrumbs::register('users.favicons', function($breadcrumbs, $user)
{
    if (isset($user->id)) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push('查看用户:' . $user->username, route('users.favicons', $user));
    }
});

Breadcrumbs::register('users.profile', function($breadcrumbs, $user)
{
    if (isset($user->id)) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push('查看用户:' . $user->username, route('users.profile', $user));
    }
});

Breadcrumbs::register('users.points', function($breadcrumbs, $user)
{
    if (isset($user->id)) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push('查看用户:' . $user->username, route('users.points', $user));
    }
});

Breadcrumbs::register('users.notifications', function($breadcrumbs, $user)
{
    if (isset($user->id)) {
        $breadcrumbs->parent('users.index');
        $breadcrumbs->push('查看用户:' . $user->username, route('users.notifications', $user));
    }
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