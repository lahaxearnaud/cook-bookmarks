<?php
use Codeception\Util\Stub;
use AspectMock\Test as test;

class DummyTest extends TestCase
{

    protected function _after()
    {
        test::clean();
    }

    // tests
    public function testMe()
    {
        $user = new User;
        $this->assertTrue(true);
    }

    public function testFacade()
    {
        $article = new Article();
        $this->assertTrue(true);
    }

}