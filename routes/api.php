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

Route::get('user', 'UserController@authed')->middleware('auth');
Route::get('users/committers', 'UserController@committers')->middleware('auth');

Route::namespace('Auth')->group(function () {
    Route::post('register', 'RegisterController@register');
    Route::post('login', 'LoginController@login');
    Route::post('logout', 'LoginController@logout');
    Route::post('verify', 'VerificationController@verify')->name('verification.verify');
    Route::post('resend', 'VerificationController@resend');

    Route::get('login/facebook', 'LoginController@facebook');
});

Route::apiResource('grids', 'GridController')->middleware('auth');

Route::post('commitments/{grid}', 'GridCommitmentController@store')->middleware('auth');
Route::put('commitments/{grid}', 'GridCommitmentController@update')->middleware('auth');
Route::delete('commitments/{grid}', 'GridCommitmentController@destroy')->middleware('auth');
