<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/07/14
 * Time: 19:01
 */

$I = new Ninja($scenario);
$I->login('admin', 'admin');
$I->wantTo('list all articles');
$I->call('articles/user/1');
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {

    $api->isType('per_page', 'INTEGER', $response['per_page']);
    $api->isType('from', 'INTEGER', $response['from']);
    $api->isType('total', 'INTEGER', $response['total']);
    $api->isType('last_page', 'INTEGER', $response['last_page']);
    $api->isType('current_page', 'INTEGER', $response['current_page']);
    $api->isType('to', 'INTEGER', $response['to']);

    foreach($response['data'] as $article) {
        $api->isType('id', 'INTEGER', $article['id']);
        $api->isType('author', 'ARRAY', $article['author']);
        $api->isType('author.username', 'STRING', $article['author']['username']);
        $api->isType('author.id', 'INTEGER', $article['author']['id']);
        $api->isType('author.id', 'INTEGER', $article['author']['id']);
        $api->isEquals('author.id', 1, $article['author']['id']);
        $api->isType('author.email', 'EMAIL', $article['author']['email']);
        $api->isType('title', 'STRING', $article['title']);
        $api->isType('url', 'URL', $article['url']);
        $api->isType('slug', 'STRING', $article['slug']);
        $api->isType('body', 'STRING', $article['body']);

        $api->isHyperMedia('show', $article);
        $api->isHyperMedia('delete', $article);
        $api->isHyperMedia('update', $article);
    }
});
