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

Route::prefix('auth')->group(function () {
    Route::livewire('', 'auth')->layout('layouts.auth')->middleware('guest')->name('auth');
    Route::post('logout', 'LogoutController')->middleware('auth')->name('auth.logout');
});

Route::middleware('auth')->group(function () {
    Route::redirect('', 'apps')->name('home');

    Route::livewire('account', 'account')->name('account');

    Route::livewire('apps', 'apps.index')->name('apps.index');
    Route::livewire('apps/{app}', 'apps.show')->name('apps.show');
    Route::livewire('apps/{app}/edit', 'apps.edit')->name('apps.edit');

    Route::livewire('log', 'log')->middleware('can:administrate')->name('log');

    Route::livewire('users', 'users.index')->name('users.index');
});
