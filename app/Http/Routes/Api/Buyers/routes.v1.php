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

Route::get('test', function(){
	return 'test buyer okay';
});

Route::post('authenticate', 'AuthController@authenticate');
Route::post('signup', 'AuthController@signup');
Route::post('forgot-password', 'AuthController@forgotPassword');
Route::get('activate/{confirmation_code}', 'AuthController@activate');

Route::group(['middleware' => []], function () {

});
