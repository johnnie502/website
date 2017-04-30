<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

# ------------------ Pages ------------------------
Route::get('/', 'PageController@index')->name('index');
Route::get('about', 'PageController@about')->name('about');
Route::get('search', 'PageController@getSearch')->name('search');
Route::post('search', 'PageController@postSearch');
Route::get('search/{$query}', 'PageController@searchResult')->name('search.result');
Route::get('sign', 'PageController@getSign')->name('sign');
Route::post('sign', 'PageController@postSign');

# ------------------ Auth ------------------------
Auth::routes();
Route::post('login', 'Auth\LoginController@postLogin');
Route::post('register', 'Auth\RegisterController@postRegister');

# ------------------ Nodes ------------------------
Route::resource('nodes', 'NodeController', [
    'only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy'],
    'parameters' => ['nodes' => 'slug'],
]);

# ------------------ Topics ------------------------
Route::resource('topics', 'TopicController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('tag/{slug}', 'TopicController@tags')->name('topics.tags');
Route::get('upvote', 'TopicController@getUpvote');
Route::post('upvote', 'TopicController@postUpvote');
Route::get('downvote', 'TopicController@getDownvote');
Route::post('downvote', 'TopicController@postDownvote');

# ------------------ Posts ------------------------
Route::resource('topics.posts', 'PostController', ['only' => ['show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('upvote', 'PostController@getUpvote');
Route::post('upvote', 'PostController@postUpvote');
Route::get('downvote', 'TopicController@getDownvote');
Route::post('downvote', 'TopicController@postDownvote');

# ------------------ Comments ------------------------
Route::resource('topics.posts.comments', 'CommentController', ['only' => ['show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('wikis.comments', 'CommentController', ['only' => ['show', 'create', 'store', 'update', 'edit', 'destroy']]);

# ------------------ Wiki ------------------------
Route::resource('wiki', 'WikiController', [
    'only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy'],
    'parameters' => ['wiki' => 'title'],
]);
Route::get('wiki/Category/{slug}', 'WikiController@category')->name('wiki.categories');
Route::get('wiki/{title}/history', 'WikiController@history')->name('wikis.history');
Route::get('wiki.new.old', 'WikiController@diff')->name('wikis.diff');
Route::get('star', 'WikiController@getStar');
Route::post('star', 'WikiController@postStar');
Route::get('unstar', 'WikiController@getUnstar');
Route::post('unstar', 'WikiController@postUnstar');

# ------------------ Users ------------------------
Route::resource('users', 'UserController', [
    'only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy'],
    'parameters' => ['users' => 'username'],
]);
Route::get('follow', 'UserController@getFollow');
Route::post('follow', 'UserController@postFollow');
Route::get('unfollow', 'UserController@getUnfollow');
Route::post('unfollow', 'UserController@postUnfollow');

//Fix ueditor server
Route::any('/laravel-ueditor/server', '\Stevenyangecho\UEditor\Controller@server');