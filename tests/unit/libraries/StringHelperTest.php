<?php

class StringHelperTest extends TestCase
{

    public static $content = "Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.";

    public function testNormal()
    {
        $this->assertEquals('Lorem ipsum dolor sit amet,...', String::extract(self::$content, 5));
    }

    public function testNormalSmallerThanNeeded()
    {
        $this->assertEquals('coucou Haha', String::extract('coucou Haha', 5));
    }

    public function testNormalBalise()
    {
        $this->assertEquals('coucou Haha', String::extract('<span>coucou</span> <i>Haha</i>', 5));
    }

    public function testError()
    {
        $this->assertEquals('', String::extract(self::$content, -1));
        $this->assertEquals('', String::extract(self::$content, 0));
    }

    public function testTitle()
    {
        $this->assertEquals('Lorem Ipsum Dolor', String::title('Lorem ipsum dolor'));
        $this->assertEquals('Lorem', String::title('lorem'));
        $this->assertEquals('', String::title(''));
    }

    public function testTidy()
    {
        if (class_exists('tidy')) {
            $test1 = String::tidy('<p>Lorem</i> ipsum dolor');
            $test2 = String::tidy('<section>Lorem</div> ipsum dolor');


            $this->assertTrue(strpos('</p>', $test1) > 0);
            $this->assertFalse(strpos('</i>', $test1));

            $this->assertTrue(strpos('</section>', $test2) > 0);
            $this->assertFalse(strpos('</div>', $test2));
        }
    }

}