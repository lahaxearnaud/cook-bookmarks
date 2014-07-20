<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/07/14
 * Time: 19:02
 */

$I = new Ninja($scenario);
$I->wantTo('delete an category');
$I->call('categories/1', 'DELETE');
$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], true);
});