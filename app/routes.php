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
Route::model('note', 'Note');

Route::group(array('prefix' => 'api/v1'), function () {
    Route::post('auth', ['as' => 'api.v1.users.login', 'uses' => 'Tappleby\AuthToken\AuthTokenController@store']);
    Route::post('users/subscribe', ['as' => 'api.v1.user.subscribe', 'uses' => 'UsersController@subscribe']);
    Route::post('users/passwordlost', ['as' => 'api.v1.user.password.lost', 'uses' => 'UsersController@askNewPasswordToken']);
    Route::post('users/passwordchange', ['as' => 'api.v1.user.password.change', 'uses' => 'UsersController@changeLostPassword']);

    Route::get('articles/extractFromUrl', ['as' => 'api.v1.articles.extractFromUrl', 'uses' => 'ArticlesController@extractFromUrl']);
    Route::post('articles/extractFromUrl', ['as' => 'api.v1.articles.extractFromUrl', 'uses' => 'ArticlesController@extractFromUrl']);

    Route::group(array('before' => 'auth.token'), function () {

        Route::get('autocomplete', ['as' => 'autocomplete.query', 'uses' => 'AutocompleteController@query']);

        Route::get('auth', ['as' => 'api.v1.users.get', 'uses' => 'Tappleby\AuthToken\AuthTokenController@index']);
        Route::delete('auth', ['as' => 'api.v1.users.logout', 'uses' => 'Tappleby\AuthToken\AuthTokenController@destroy']);
        Route::get('users/{user}', ['as' => 'api.v1.users.show', 'uses' => 'Tappleby\AuthToken\AuthTokenController@index']);
        Route::post('users/password', ['as' => 'user.password', 'uses' => 'UsersController@changePassword']);


        Route::get('articles/user/{user}', ['as' => 'articles.user', 'uses' => 'ArticlesController@user']);
        Route::get('articles/existNoCategory', ['as' => 'articles.existNoCategory', 'uses' => 'ArticlesController@existsWithNoCategory']);
        Route::get('articles/noCategory', ['as' => 'articles.noCategory', 'uses' => 'ArticlesController@noCategory']);
        Route::get('articles/export/{article}', ['as' => 'articles.export', 'uses' => 'ArticlesController@export']);

        Route::get('articles/search', ['as' => 'articles.search', 'uses' => 'ArticlesController@search']);
        Route::resource('articles', 'ArticlesController');

        Route::resource('categories', 'CategoriesController');
        Route::get('categories/{category}/articles', ['as' => 'categories.articles', 'uses' => 'CategoriesController@articles']);
        Route::get('categories/user/{user}', ['as' => 'categories.user', 'uses' => 'CategoriesController@user']);

        Route::resource('notes', 'NotesController');
        Route::get('articles/{article}/notes', ['as' => 'notes.article', 'uses' => 'NotesController@article']);


    });
});
