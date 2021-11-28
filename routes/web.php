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

Route::view('/', 'home')->name('home');

Route::redirect('/admin', '/backend');

Auth::routes(['verify' => true]);

Route::get('login/{provider}', 'Auth\LoginController@redirect')->name('login.socialite');
Route::get('login/{provider}/callback', 'Auth\LoginController@callback');

Route::middleware('auth')->namespace('Backend')->prefix('backend')->group(function () {
    Route::view('/', 'backend.dashboard')->name('backend.dashboard');

    Route::resource('users', 'UserController', ['as' => 'backend']);
    Route::resource('roles', 'RoleController', ['as' => 'backend'])->middleware('password.confirm');

    Route::get('profile', 'ProfileController@show')->name('backend.profile');
    Route::put('profile', 'ProfileController@update');
});
