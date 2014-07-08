<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/07/14
 * Time: 19:01
 */

$I = new Ninja($scenario);
$I->wantTo('get an article');
$I->call('articles/1');
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('id', 'INTEGER', $response['id']);
    $api->isType('author', 'ARRAY', $response['author']);
    $api->isType('author.username', 'STRING', $response['author']['username']);
    $api->isType('author.id', 'INTEGER', $response['author']['id']);
    $api->isType('author.email', 'EMAIL', $response['author']['email']);
    $api->isType('title', 'STRING', $response['title']);
    $api->isType('url', 'STRING', $response['url']);
    $api->isType('slug', 'STRING', $response['slug']);
    $api->isType('body', 'STRING', $response['body']);
});