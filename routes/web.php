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
Route::get('search', 'PageController@search')->name('search');
Route::post('search', 'PageController@postSearch');
Route::get('search/{$query}', 'PageController@searchResult')->name('search.result');
Route::get('sign', 'PageController@sign')->name('sign');
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

# ------------------ Posts ------------------------
Route::resource('topics.posts', 'PostController', ['only' => ['show', 'create', 'store', 'update', 'edit', 'destroy']]);

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

# ------------------ Users ------------------------
Route::resource('users', 'UserController', [
    'only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy'],
    'parameters' => ['users' => 'username'],
]);

//Fix ueditor server
Route::any('/laravel-ueditor/server', '\Stevenyangecho\UEditor\Controller@server');