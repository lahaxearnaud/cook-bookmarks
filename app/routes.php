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
Route::model('category', 'Category');


Route::resource('articles', 'ArticlesController');


Route::group(array('prefix' => 'api/v1'), function () {

    Route::get('auth', [ 'as' => 'api.v1.users.get', 'uses' => 'Tappleby\AuthToken\AuthTokenController@index']);
    Route::post('auth', [ 'as' => 'api.v1.users.login', 'uses' => 'Tappleby\AuthToken\AuthTokenController@store']);
    Route::delete('auth', [ 'as' => 'api.v1.users.logout', 'uses' => 'Tappleby\AuthToken\AuthTokenController@destroy']);

    Route::get('users/{user}', [ 'as' => 'api.v1.users.show', 'uses' => 'Tappleby\AuthToken\AuthTokenController@index']);


    Route::resource('articles', 'ArticlesController');
    Route::post('articles/url', [ 'as' => 'articles.url', 'uses' => 'ArticlesController@url']);
    Route::get('articles/user/{user}', [ 'as' => 'articles.user', 'uses' => 'ArticlesController@user']);
    Route::get('articles/search/{query}', [ 'as' => 'articles.search', 'uses' => 'ArticlesController@search']);


    Route::resource('categories', 'CategoriesController');
    Route::get('categories/user/{user}', [ 'as' => 'categories.user', 'uses' => 'CategoriesController@user']);
    Route::get('categories/search/{query}', [ 'as' => 'categories.search', 'uses' => 'CategoriesController@search']);

});
