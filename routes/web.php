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
Route::get('/about', 'PageController@about');

# ------------------ Auth ------------------------
Auth::routes();
Route::post('/login', 'Auth\LoginController@postLogin');
Route::post('/register', 'Auth\RegisterController@postRegister');

# ------------------ Node ------------------------
Route::resource('nodes', 'NodeController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

Route::resource('files', 'FileController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

# ------------------ Topic ------------------------
Route::resource('topics', 'TopicController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

# ------------------ Post ------------------------
Route::resource('posts', 'PostController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);

# ------------------ Tags ------------------------
Route::get('/tag/{slug}', 'TagsController@show')->name('tag');

# ------------------ User ------------------------
Route::resource('users', 'UserController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);
Route::resource('wikis', 'WikiController', ['only' => ['index', 'show', 'create', 'store', 'update', 'edit', 'destroy']]);