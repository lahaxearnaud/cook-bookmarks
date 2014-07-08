<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/07/14
 * Time: 19:02
 */

$title = uniqid('title-');

$I = new Ninja($scenario);
$I->wantTo('update an article');
$I->call('articles/2', 'PUT', array(
    'title' => $title
));
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], true);
});


$I->amGoingTo('Check if update works');
$I->call('articles/2');
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) use ($title) {
    $api->isType('title', 'STRING', $response['title']);
    $api->isEquals('title', $response['title'], $title);
});