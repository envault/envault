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
    Route::get('', App\Http\Livewire\Auth::class)->middleware('guest')->name('auth');
    Route::post('logout', function () {
        auth()->logout();

        return redirect('/');
    })->middleware('auth')->name('auth.logout');
});

Route::middleware('auth')->group(function () {
    Route::redirect('', 'apps');

    Route::get('account', App\Http\Livewire\Account::class)->name('account');

    Route::get('apps', App\Http\Livewire\Apps\Index::class)->name('apps.index');
    Route::get('apps/{app}', App\Http\Livewire\Apps\Show::class)->name('apps.show');
    Route::get('apps/{app}/edit', App\Http\Livewire\Apps\Edit::class)->name('apps.edit');

    Route::get('log', App\Http\Livewire\Log::class)->middleware('can:administrate')->name('log');

    Route::get('users', App\Http\Livewire\Users\index::class)->name('users.index');
});
