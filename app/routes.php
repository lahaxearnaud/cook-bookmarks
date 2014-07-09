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


Route::group(array('prefix' => 'api/v1'), function () {

    Route::get('auth', 'Tappleby\AuthToken\AuthTokenController@index');
    Route::post('auth', 'Tappleby\AuthToken\AuthTokenController@store');
    Route::delete('auth', 'Tappleby\AuthToken\AuthTokenController@destroy');

    Route::resource('articles', 'ArticlesController');
    Route::post('articles/url', [ 'as' => 'articles.url', 'uses' => 'ArticlesController@url']);
    Route::get('articles/user/{user}', [ 'as' => 'articles.user', 'uses' => 'ArticlesController@user']);
    Route::get('articles/search/{query}', [ 'as' => 'articles.search', 'uses' => 'ArticlesController@search']);

});
