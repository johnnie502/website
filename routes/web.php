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
Route::get('wiki/{name}/history', 'WikiController@history')->name('wikis.history');
Route::get('wikis.new.old', 'WikiController@diff')->name('wikis.diff');
Route::resource('wiki', 'WikiController', [
    'only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy'],
    'parameters' => ['wiki' => 'title'],
]);

# ------------------ Users ------------------------
Route::get('users/{username}/home', 'UserController@home')->name('users.home');
Route::get('users/{username}/topics', 'UserController@topics')->name('users.topics');
Route::get('users/{username}/replies', 'UserController@replies')->name('users.replies');
Route::get('users/{username}/created_wiki', 'UserController@created_wiki')->name('users.created_wiki');
Route::get('users/{username}/edited_wiki', 'UserController@edited_wiki')->name('users.edited_wiki');
Route::get('users/{username}/comments', 'UserController@comments')->name('users.comments');
Route::get('users/{username}/followers', 'UserController@followers')->name('users.followers');
Route::get('users/{username}/following', 'UserController@following')->name('users.following');
Route::get('users/{username}/votes', 'UserController@votes')->name('users.votes');
Route::get('users/{username}/favicons', 'UserController@favicons')->name('users.favicons');
Route::get('users/{username}/profile', 'UserController@profile')->name('users.profile');
Route::post('users/{username}/profile', 'UserController@profile');
Route::post('users/{username}/points', 'UserController@points')->name('users.points');
Route::get('users/{username}/notifications', 'UserController@notifications')->name('users.notifications');
Route::resource('users', 'UserController', [
	'only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy'],
	'parameters' => ['users' => 'username'],
]);

//Fix ueditor server
Route::any('/laravel-ueditor/server', '\Stevenyangecho\UEditor\Controller@server');