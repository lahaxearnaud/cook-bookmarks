<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 08/08/14
 * Time: 21:45
 */

$I = new Ninja($scenario);
$I->login('admin', 'admin');

$I->call('articles');
