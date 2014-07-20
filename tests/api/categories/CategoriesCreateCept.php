<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/07/14
 * Time: 19:01
 */

$title = 'Dummy title';

$I = new Ninja($scenario);
$I->wantTo('Create an category');
$I->call('categories', 'POST', array(
    'user_id'   => 1,
    'name'        => $title,
), 201);

$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], TRUE);
});