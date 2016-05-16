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

Route::auth();

// Registration routes...
Route::get('register', 'Auth\AuthController@getRegister');
Route::post('register', 'Auth\AuthController@postRegister');

Route::group(['middleware' => ['auth:sellers']], function () {

	//Route::get('sellers', ['as' => 'sellers.index', 'uses' => 'SellerController@index']);

	Route::get('sellers', function() {
		dd(Auth::guard('sellers')->user());
		return "u are in a right track";
	});

});