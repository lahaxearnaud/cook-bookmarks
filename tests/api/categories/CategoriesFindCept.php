<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/07/14
 * Time: 19:01
 */

$I = new Ninja($scenario);
$I->wantTo('get an category');

$I->amGoingTo('Get an article with a good id');
$I->call('categories/1');
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('id', 'INTEGER', $response['id']);
    $api->isType('user', 'ARRAY', $response['user']);
    $api->isType('user.username', 'STRING', $response['user']['username']);
    $api->isType('user.id', 'INTEGER', $response['user']['id']);
    $api->isType('user.email', 'EMAIL', $response['user']['email']);

    $api->isType('name', 'STRING', $response['name']);
    $api->isType('user_id', 'INTEGER', $response['user_id']);
    $api->isType('id', 'INTEGER', $response['id']);

    $api->isHyperMedia('show', $response);
    $api->isHyperMedia('delete', $response);
    $api->isHyperMedia('update', $response);
});

$I->amGoingTo('Get an category with a bad id');
$I->call('categories/1000', $method = 'GET', $params = array(), $httpCode = 404);

$I->amGoingTo('Get an category with a string');
$I->call('categories/aaa', $method = 'GET', $params = array(), $httpCode = 404);

