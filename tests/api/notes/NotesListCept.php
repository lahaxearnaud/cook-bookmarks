<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/07/14
 * Time: 19:01
 */

$I = new Ninja($scenario);
$I->wantTo('list all categories');
$I->call('notes');
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {

    $api->isType('per_page', 'INTEGER', $response['per_page']);
    $api->isType('from', 'INTEGER', $response['from']);
    $api->isType('total', 'INTEGER', $response['total']);
    $api->isType('last_page', 'INTEGER', $response['last_page']);
    $api->isType('current_page', 'INTEGER', $response['current_page']);
    $api->isType('to', 'INTEGER', $response['to']);

    foreach($response['data'] as $article) {
        $api->isType('id', 'INTEGER', $article['id']);
        $api->isType('user', 'ARRAY', $article['user']);
        $api->isType('user.username', 'STRING', $article['user']['username']);
        $api->isType('user.id', 'INTEGER', $article['user']['id']);
        $api->isType('user.email', 'EMAIL', $article['user']['email']);

        $api->isType('body', 'STRING', $article['body']);



        $api->isHyperMedia('show', $article);
        $api->isHyperMedia('delete', $article);
        $api->isHyperMedia('update', $article);
    }
});