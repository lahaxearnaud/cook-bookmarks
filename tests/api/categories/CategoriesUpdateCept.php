<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/07/14
 * Time: 19:02
 */

$title = uniqid('title-');

$I = new Ninja($scenario);
$I->login('admin', 'admin');
$I->wantTo('update an category');
$I->call('categories/2', 'PUT', array(
    'name' => $title,
));
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) use ($I) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], true);
});

$I->amGoingTo('Check if update works');
$I->call('categories/2');
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) use ($title) {
    $api->isType('name', 'STRING', $response['name']);
    $api->isEquals('name', $response['name'], $title);
});
