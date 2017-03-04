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
Route::get('/about', 'PageController@about')->name('about');
Route::get('/search', 'PageController@search')->name('search');
Route::post('search', 'PageController@postSearch');
Route::get('search/{$query}', 'PageController@searchResult')->name('search.result');

# ------------------ Auth ------------------------
Auth::routes();
Route::post('login', 'Auth\LoginController@postLogin');
Route::post('register', 'Auth\RegisterController@postRegister');

# ------------------ Nodes ------------------------
Route::resource('nodes', 'NodeController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

# ------------------ Topics ------------------------
Route::resource('topics', 'TopicController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('tag/{slug}', 'TopicController@tags')->name('tag');

# ------------------ Posts ------------------------
Route::resource('topics.posts', 'PostController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

# ------------------ Comments ------------------------
Route::resource('topics.posts.comments', 'CommentController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('wiki.comments', 'CommentController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

# ------------------ Wiki ------------------------
Route::resource('wiki', 'WikiController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('wiki/{name}/history', 'WikiController@history')->name('wiki.history');
Route::get('wiki.new.old', 'WikiController@diff')->name('wiki.diff');

# ------------------ Users ------------------------
Route::resource('users', 'UserController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('user/{name?}/home', 'UserController@home')->name('user.home');
Route::get('user/{name?}/profiles', 'UserController@profile')->name('user.profile');
Route::get('user/{name?}/topics', 'UserController@topics')->name('user.topics');
Route::get('user/{name?}/replies', 'UserController@replies')->name('user.replies');
Route::get('user/{name?}/nofitications', 'UserController@nofitications')->name('user.nofitications');
Route::get('user/{name?}/followers', 'UserController@followers')->name('user.followers');
Route::get('user/{name?}/following', 'UserController@following')->name('user.following');

//Fix ueditor server
Route::any('/laravel-ueditor/server', '\Stevenyangecho\UEditor\Controller@server');