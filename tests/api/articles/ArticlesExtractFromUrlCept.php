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
    'url'   => 'http://laravel.com/docs/quick',
    'markdown' => false,
), 200);
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], TRUE);

    $api->isType('title', 'STRING', $response['title']);
    $api->isEquals('title', $response['title'], 'laravel/laravel · GitHub');

    $api->isType('body', 'STRING', $response['body']);
});


$I->wantTo('Extract article from an url in markdown');
$I->call('articles/extractFromUrl', 'POST', array(
    'url'   => 'http://laravel.com/docs/quick',
    'markdown' => true,
), 200);
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], TRUE);

    $api->isType('title', 'STRING', $response['title']);
    $api->isEquals('title', $response['title'], 'Laravel - The PHP Framework For Web Artisans.');

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
    'url'   => 'http://dummy.laravel.com'
), 400);
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], FALSE);
});
