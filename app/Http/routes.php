<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


Route::group(['namespace' => 'Api\V1', 'prefix' => 'api/v1', 'middleware'], function () {

	Route::post('authenticate', 'AuthController@authenticate');
	Route::post('signup', 'AuthController@signup');
	Route::post('forgot-password', 'AuthController@forgotPassword');
	Route::get('activate/{confirmation_code}', 'AuthController@activate');

	Route::group(['middleware' => ['']], function () {

	});
});

Route::group(['middleware' => ['web', 'auth'], 'namespace' => 'Admin'], function () {

	Route::get('users', ['as' => 'users.index', 'uses' => 'UserController@index']);
});
