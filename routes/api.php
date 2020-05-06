<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::name('v1.')->namespace('v1')->prefix('v1')->group(function () {
    Route::post('/apps/{app}/setup/{token}', 'SetupAppController')->name('apps.setup');
    Route::post('/apps/{app}/update', 'UpdateAppController')->middleware('auth:sanctum')->name('apps.update');
});
