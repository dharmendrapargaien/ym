<?php

/*
|--------------------------------------------------------------------------
| Api Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::post('authenticate', 'AuthController@authenticate');
Route::post('signup', 'AuthController@signup');
Route::post('forgot-password', 'AuthController@forgotPassword');
Route::post('activate', 'AuthController@activate');

Route::group(['middleware' => []], function () {

});