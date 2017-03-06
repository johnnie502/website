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
Route::resource('nodes', 'NodeController', [
    'only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy'],
    'parameters' => ['node' => 'slug'],
]);

# ------------------ Topics ------------------------
Route::resource('topics', 'TopicController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('tag/{slug}', 'TopicController@tags')->name('topics.tags');

# ------------------ Posts ------------------------
Route::resource('topics.posts', 'PostController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

# ------------------ Comments ------------------------
Route::resource('topics.posts.comments', 'CommentController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('wikis.comments', 'CommentController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

# ------------------ Wiki ------------------------
Route::resource('wiki', 'WikiController', [
    'only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy'],
    'parameters' => ['wiki' => 'title'],
]);
Route::get('wiki/{name}/history', 'WikiController@history')->name('wikis.history');
Route::get('wikis.new.old', 'WikiController@diff')->name('wikis.diff');

# ------------------ Users ------------------------
Route::resource('users', 'UserController', [
	'only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy'],
	'parameters' => ['user' => 'username'],
]);
Route::get('user/{name}/home', 'UserController@home')->name('users.home');
Route::get('user/{name}/topics', 'UserController@topics')->name('users.topics');
Route::get('user/{name}/replies', 'UserController@replies')->name('users.replies');
Route::get('user/{name}/created_wiki', 'UserController@created_wiki')->name('users.created_wiki');
Route::get('user/{name}/edited_wiki', 'UserController@edited_wiki')->name('users.edited_wiki');
Route::get('user/{name}/comments', 'UserController@comments')->name('users.comments');
Route::get('user/{name}/followers', 'UserController@followers')->name('users.followers');
Route::get('user/{name}/following', 'UserController@following')->name('users.following');
Route::get('user/{name}/profile', 'UserController@profile')->name('users.profile');
Route::post('user/{name}/profile', 'UserController@update')->name('users.profile');
Route::get('user/{name}/votes', 'UserController@votes')->name('users.votes');
Route::get('user/{name}/favicons', 'UserController@favicons')->name('users.favicons');
Route::get('user/{name}/notifications', 'UserController@notifications')->name('users.notifications');

//Fix ueditor server
Route::any('/laravel-ueditor/server', '\Stevenyangecho\UEditor\Controller@server');