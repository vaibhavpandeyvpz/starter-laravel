<?php

use App\Http\Controllers;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::view('/', 'home')->name('home');

Auth::routes(['verify' => true]);

Route::get('login/{provider}', [Controllers\Auth\LoginController::class, 'socialRedirect'])
    ->whereIn('provider', ['google'])
    ->name('login.socialite');
Route::get('login/{provider}/callback', [Controllers\Auth\LoginController::class, 'socialCallback']);

Route::middleware(['auth', 'enabled'])->group(function () {
    Route::view('/dashboard', 'dashboard')->name('dashboard');
    Route::get('/search', [Controllers\DashboardController::class, 'search'])->name('dashboard.search');

    Route::get('profile', [Controllers\ProfileController::class, 'edit'])->name('profile');
    Route::put('profile', [Controllers\ProfileController::class, 'update']);

    Route::resource('roles', Controllers\RoleController::class)->middleware('password.confirm');
    Route::resource('users', Controllers\UserController::class);
});
