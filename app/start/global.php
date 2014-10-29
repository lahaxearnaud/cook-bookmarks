<?php

/*
|--------------------------------------------------------------------------
| Register The Laravel Class Loader
|--------------------------------------------------------------------------
|
| In addition to using Composer, you may use the Laravel class loader to
| load your controllers and models. This is useful for keeping all of
| your classes in the "global" namespace without Composer updating.
|
*/

ClassLoader::addDirectories(array(

    app_path().'/commands',
    app_path().'/controllers',
    app_path().'/models',
    app_path().'/database/seeds',

));

/*
|--------------------------------------------------------------------------
| Application Error Logger
|--------------------------------------------------------------------------
|
| Here we will configure the error logger setup for the application which
| is built on top of the wonderful Monolog library. By default we will
| build a basic log file setup which creates a single file for logs.
|
*/

Log::useFiles(storage_path().'/logs/laravel.log');

/*
|--------------------------------------------------------------------------
| Application Error Handler
|--------------------------------------------------------------------------
|
| Here you may handle any errors that occur in your application, including
| logging them or displaying custom views for specific errors. You may
| even register several error handlers to handle different types of
| exceptions. If nothing is returned, the default error view is
| shown, which includes a detailed stack trace during debug.
|
*/

App::error(function (Exception $exception, $code) {
    Event::fire('apiLog', array($exception->getCode()));

    Log::error($exception);

});

App::error(function (Illuminate\Database\Eloquent\ModelNotFoundException $e) {
    Event::fire('apiLog', array(404));

    return Response::make(array(
        'error' => $e->getMessage()
    ), 404);
});

/*
|--------------------------------------------------------------------------
| Maintenance Mode Handler
|--------------------------------------------------------------------------
|
| The "down" Artisan command gives you the ability to put an application
| into maintenance mode. Here, you will define what is displayed back
| to the user if maintenance mode is in effect for the application.
|
*/

App::down(function () {
    return Response::make("Be right back!", 503);
});

/*
|--------------------------------------------------------------------------
| Require The Filters File
|--------------------------------------------------------------------------
|
| Next we will load the filters file for the application. This gives us
| a nice separate location to store our route and application filter
| definitions instead of putting them all in the main routes file.
|
*/

require app_path().'/filters.php';

/*
|--------------------------------------------------------------------------
| Dependencies Injection
|--------------------------------------------------------------------------
*/

App::bind('ArticleSeeker', function ($app) {
    return new \Repositories\Seekers\ArticleSeeker(new Article());
});

App::singleton('ArticlesRepository', function ($app) {
    return new Repositories\ArticlesRepository(new Article(), array('author', 'category'), Auth::User(), App::make('ArticleSeeker'));
});

App::singleton('LogsRepository', function ($app) {
    return new Repositories\LogsRepository(new ApiLog(), []);
});

App::singleton('CategoriesRepository', function ($app) {
    return new Repositories\CategoriesRepository(new Category(), array('user'), Auth::User());
});

App::singleton('NotesRepository', function ($app) {
    return new Repositories\NotesRepository(new Note(), array('user'), Auth::User());
});

App::singleton('UsersRepository', function ($app) {
    return new Repositories\UsersRepository(new User(), []);
});

App::bind('ArticlesController', function ($app) {
    return new ArticlesController(
        App::make('ArticlesRepository'),
        new ArticleExtractor(),
        new Html2Markdown()
    );
});

App::bind('CategoriesController', function ($app) {
    return new CategoriesController(
        App::make('CategoriesRepository'),
        App::make('ArticlesRepository')
    );
});

App::bind('NotesController', function ($app) {
    return new NotesController(
        App::make('NotesRepository')
    );
});

App::bind('UsersController', function ($app) {
    return new UsersController(
        App::make('UsersRepository')
    );
});

App::bind('AutocompleteController', function ($app) {
    return new AutocompleteController(
        App::make('ArticleSeeker')
    );
});

/*
|--------------------------------------------------------------------------
| Observers
|--------------------------------------------------------------------------
*/

Article::observe(new Observers\Models\ArticleObserver(new ArticleIndexer()));
Category::observe(new Observers\Models\CategoryObserver(new ArticleIndexer()));
Note::observe(new Observers\Models\NoteObserver(new ArticleIndexer()));

Event::subscribe(new Observers\Repositories\ArticlesRepositoryObserver);
Event::subscribe(new Observers\Repositories\CategoriesRepositoryObserver);
Event::subscribe(new Observers\Repositories\NotesRepositoryObserver);
Event::subscribe(new Observers\AuthObserver);
