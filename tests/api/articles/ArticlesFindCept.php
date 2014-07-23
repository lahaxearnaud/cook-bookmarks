<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/07/14
 * Time: 19:01
 */

$I = new Ninja($scenario);
$I->wantTo('get an article');

$I->amGoingTo('Get an article with a good id');
$I->call('articles/1');
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('id', 'INTEGER', $response['id']);
    $api->isType('author', 'ARRAY', $response['author']);
    $api->isType('author.username', 'STRING', $response['author']['username']);
    $api->isType('author.id', 'INTEGER', $response['author']['id']);
    $api->isType('author.email', 'EMAIL', $response['author']['email']);

    $api->isType('category', 'ARRAY', $response['category']);
    $api->isType('category.name', 'STRING', $response['category']['name']);
    $api->isType('category.user_id', 'INTEGER', $response['category']['user_id']);
    $api->isType('category.id', 'INTEGER', $response['category']['id']);

    $api->isType('title', 'STRING', $response['title']);
    $api->isType('url', 'STRING', $response['url']);
    $api->isType('slug', 'STRING', $response['slug']);
    $api->isType('body', 'STRING', $response['body']);

    $api->isHyperMedia('show', $response);
    $api->isHyperMedia('delete', $response);
    $api->isHyperMedia('update', $response);

});

$I->amGoingTo('Get an article with a bad id');
$I->call('articles/1000', $method = 'GET', $params = array(), $httpCode = 404);

$I->amGoingTo('Get an article with a string');
$I->call('articles/aaa', $method = 'GET', $params = array(), $httpCode = 404);
