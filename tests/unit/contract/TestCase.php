<?php
/**
 * Created by PhpStorm.
 * User: arnaud
 * Date: 23/07/14
 * Time: 07:28
 */

class TestCase extends \PHPUnit_Framework_TestCase
{
    public function setUp()
    {
        parent::setUp();
        Artisan::call('db:seed');
    }
}
