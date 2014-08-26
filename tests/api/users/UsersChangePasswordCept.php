<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/08/14
 * Time: 21:46
 */
Artisan::call('db:seed');


$I = new Ninja($scenario);
$I->wantTo('change my password');
$I->login('admin', 'admin');
$I->call('users/password', 'POST', array(
    'oldPassword'           => 'admin',
    'newPassword'           => 'azertyuiop',
    'newPassword_confirmation' => 'azertyuiop',
));

$I->validateResponseWithClosure(function (Codeception\Module\NinjaHelper $api, $response) {
    $api->isType('success', 'BOOLEAN', $response['success']);
    $api->isEquals('success', $response['success'], TRUE);
});

$I->amGoingTo('Test login with my new password');
$I->login('admin', 'azertyuiop');
