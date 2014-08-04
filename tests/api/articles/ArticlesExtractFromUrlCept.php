<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 04/08/14
 * Time: 12:17
 */

$I = new Ninja($scenario);
$I->wantTo('Extract article from an url');
$I->call('articles/extractFromUrl', 'POST', array(
    'url'   => 'https://github.com/laravel/laravel',
    'markdown' => false,
), 200);
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], TRUE);

    $api->isType('title', 'STRING', $response['title'], '', true);
    $api->isEquals('title', $response['title'], 'laravel/laravel · GitHub');

    $api->isType('body', 'STRING', $response['body']);
});


$I->wantTo('Extract article from an url in markdown');
$I->call('articles/extractFromUrl', 'POST', array(
    'url'   => 'https://github.com/laravel/laravel',
    'markdown' => true,
), 200);
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], TRUE);

    $api->isType('title', 'STRING', $response['title'], '', true);
    $api->isEquals('title', $response['title'], 'laravel/laravel · GitHub');

    $api->isType('body', 'STRING', $response['body']);
});

$I->wantTo('Extract article from empty url');
$I->call('articles/extractFromUrl', 'POST', array(
    'url'   => ''
), 400);
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], FALSE);
});

$I->wantTo('Extract article from empty url');
$I->call('articles/extractFromUrl', 'POST', array(
    'url'   => 'https://github.com/dummy/dummy'
), 400);
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], FALSE);
});
