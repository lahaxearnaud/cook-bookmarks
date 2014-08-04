<?php

/*
|--------------------------------------------------------------------------
| Application & Route Filters
|--------------------------------------------------------------------------
|
| Below you will find the "before" and "after" events for the application
| which may be used to do any work before or after a request into your
| application. Here you may also register your custom route filters.
|
*/

App::before(function (Symfony\Component\HttpFoundation\Request $request) {
    //
});

App::after(function (Symfony\Component\HttpFoundation\Request $request, Symfony\Component\HttpFoundation\Response $response) {
    Event::fire('apiLog', array($response->getStatusCode()));
});

/*
|--------------------------------------------------------------------------
| Authentication Filters
|--------------------------------------------------------------------------
|
| The following filters are used to verify that the user of the current
| session is logged into this application. The "basic" filter easily
| integrates HTTP Basic authentication for quick, simple checking.
|
*/

Route::filter('auth', function () {
    if (Auth::guest()) {
        if (Request::ajax()) {
            Event::fire('apiLog', array(401));

            return Response::make('Unauthorized', 401);
        } else {
            return Redirect::guest('login');
        }
    }
});

Route::filter('auth.basic', function () {
    return Auth::basic();
});

App::error(function (AuthTokenNotAuthorizedException $exception) {
    Event::fire('apiLog', array($exception->getCode()));

    return Response::json(array('error' => $exception->getMessage()), $exception->getCode());
});

/*
|--------------------------------------------------------------------------
| Guest Filter
|--------------------------------------------------------------------------
|
| The "guest" filter is the counterpart of the authentication filters as
| it simply checks that the current user is not logged in. A redirect
| response will be issued if they are, which you may freely change.
|
*/

Route::filter('guest', function () {
    if (Auth::check()) return Redirect::to('/');
});

/*
|--------------------------------------------------------------------------
| CSRF Protection Filter
|--------------------------------------------------------------------------
|
| The CSRF filter is responsible for protecting your application against
| cross-site request forgery attacks. If this special token in a user
| session does not match the one given in this request, we'll bail.
|
*/

Route::filter('csrf', function () {
    if (Session::token() != Input::get('_token')) {
        throw new Illuminate\Session\TokenMismatchException;
    }
});

/*
|--------------------------------------------------------------------------
| Api database logs listener
|--------------------------------------------------------------------------
*/
Event::listen('apiLog', function ($httpCode) {
    $repository = App::make('LogsRepository');

    $inputs = array();

    if(!in_array(Route::currentRouteName(), Config::get('api.noParamsLogRoutesNames'))) {
        $inputs = Input::all();
    }

    $repository->create(array(
        'url'      => Request::url(),
        'route'    => Route::currentRouteName(),
        'params'   => json_encode($inputs),
        'method'   => Request::method(),
        'httpCode' => $httpCode,
        'user_id'  => Auth::guest() ? NULL : Auth::User()->id,
        'ip' => Request::getClientIp()
    ));
});
