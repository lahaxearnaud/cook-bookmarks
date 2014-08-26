<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/07/14
 * Time: 19:01
 */

$I = new Ninja($scenario);
$I->login('admin', 'admin');
$I->wantTo('list all categories');
$I->call('categories');
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {

    foreach($response as $article) {
        $api->isType('id', 'INTEGER', $article['id']);

        $api->isType('name', 'STRING', $article['name']);
        $api->isType('user_id', 'INTEGER', $article['user_id']);
        $api->isType('id', 'INTEGER', $article['id']);

        $api->isHyperMedia('show', $article);
        $api->isHyperMedia('delete', $article);
        $api->isHyperMedia('update', $article);
    }
});
