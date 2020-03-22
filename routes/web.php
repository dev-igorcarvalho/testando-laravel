<?php

use Illuminate\Support\Facades\Route;

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();
Route::get('/home', 'PostController@index');

//Follows
Route::post('/follow/{user}', 'FollowsController@store')->name('follows.store');

//Post
Route::post('/post', 'PostController@store')->name('post.store');
Route::get('/post/create', 'PostController@create')->name('post.create');
//Obs rotas com o caminho hardcoded devem vir antes de rotas com o caminho variavel
//caso contrario o laravel se confunde e usa o caminho como variavel passa para a funcao da rota
Route::get('/post/{post}', 'PostController@show')->name('post.show');

//Profile
Route::get('/profile/{user}', 'ProfilesController@index')->name('profile.show');
Route::patch('/profile/{user}', 'ProfilesController@update')->name('profile.update');
Route::get('/profile/{user}/edit', 'ProfilesController@edit')->name('profile.edit');
