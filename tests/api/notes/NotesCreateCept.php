<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/07/14
 * Time: 19:01
 */

$body = 'Dummy title';

$I = new Ninja($scenario);
$I->login('admin', 'admin');
$I->wantTo('Create an note');
$I->call('notes', 'POST', array(
    'user_id'   => 1,
    'article_id'   => 2,
    'body'        => $body,
), 201);

$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], TRUE);
});
