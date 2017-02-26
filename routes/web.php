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
Route::post('/search', 'PageController@postSearch');
Route::get('/search/{$query}', 'PageController@searchResult')->name('search.result');

# ------------------ Auth ------------------------
Auth::routes();
Route::post('/login', 'Auth\LoginController@postLogin');
Route::post('/register', 'Auth\RegisterController@postRegister');

# ------------------ Nodes ------------------------
Route::resource('nodes', 'NodeController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

# ------------------ Topics ------------------------
Route::resource('topics', 'TopicController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::get('/tag/{slug}', 'TopicController@tags')->name('tag');

# ------------------ Posts ------------------------
Route::resource('topics/{$topic}/posts/{$post}', 'PostController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

# ------------------ Comments ------------------------
Route::resource('topics/{$topic}/posts/{$post}/comments/{comment}', 'CommentController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('wiki/{slug}/comments/{comment}', 'CommentController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

# ------------------ Wiki ------------------------
Route::resource('wiki', 'WikiController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

# ------------------ Users ------------------------
Route::resource('users', 'UserController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

//Fix ueditor server
Route::any('/laravel-ueditor/server', '\Stevenyangecho\UEditor\Controller@server');