<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the Closure to execute when that URI is requested.
|
*/

Route::model('user', 'User');
Route::model('article', 'Article');


Route::resource('articles', 'ArticlesController');


Route::get('/', function()
{
	return View::make('hello');
});

Route::group(array('prefix' => 'api/v1'), function() {

	Route::get('auth', 'Tappleby\AuthToken\AuthTokenController@index');
	Route::post('auth', 'Tappleby\AuthToken\AuthTokenController@store');
	Route::delete('auth', 'Tappleby\AuthToken\AuthTokenController@destroy');

	Route::group(array('before' => 'auth.token'), function() {
		Route::resource('articles', 'ArticlesController');
	});

});