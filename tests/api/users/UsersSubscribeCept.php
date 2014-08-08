<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/08/14
 * Time: 21:46
 */

$I = new Ninja($scenario);
$I->wantTo('Subscribe');
$I->call('users/subscribe', 'POST', array(
    'email'   => 'test@test.fr',
    'username' => 'tester',
    'password'       => 'azertyuiop',
));

$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], TRUE);
});
