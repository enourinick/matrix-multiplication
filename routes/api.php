<?php

use Illuminate\Http\Request;
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

Route::group([
    'middleware' => ['cors']
], function() {
    // add OPTIONS route to fire cors middleware for preflight
    Route::options('{any}');
});

Route::middleware(['auth:api', 'cors'])->get('/user', function (Request $request) {
    return $request->user();
});

Route::as('api.')->group(function () {
    Route::middleware('auth:api')->group(function () {
        Route::post('multiply', 'MultiplyController@multiply')->name('multiply');

        Route::as('me.')->prefix('me')->group(function () {
            Route::get('', 'UserController@show')->name('show');
            Route::put('', 'UserController@update')->name('update');
        });
    });

    Route::apiResource('user', 'UserController', ['only' => ['index', 'store']]);

    Route::post('token', 'ApiTokenController@issueToken');
});
