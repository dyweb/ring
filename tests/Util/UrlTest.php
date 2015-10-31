<?php

/**
 * Created by PhpStorm.
 * User: gpl
 * Date: 15/10/31
 * Time: 上午11:02
 */
namespace Dy\Ring\Test\Util;

use Dy\Ring\Util\Url;

class UrlTest extends \PHPUnit_Framework_TestCase
{
    public function testCleanPath()
    {
        // http://stackoverflow.com/questions/249664/best-practices-to-test-protected-methods-with-phpunit
        // make the protect method public for test
        // http://stackoverflow.com/questions/11939166/how-to-override-trait-function-and-call-it-from-the-overriden-function

        $this->assertEquals('a/b', Url::cleanPath('a/b/'));
        $this->assertEquals('a/b', Url::cleanPath('a/b//'));
        // FIXME: it does not support .. and .
        // $this->assertEquals('b/c', $url->cleanPath('a/../b/c'));
    }

    public function testRelative()
    {
        $this->assertEquals('b/c', Url::relative('/usr/share/www/b/c', '/usr/share/www'));
    }

    public function testGetUrl()
    {
        $url = new Url('/usr/share/www','http://localhost:8000');
        $this->assertEquals('http://localhost:8000/a.jpg', $url->getUrl('/usr/share/www/a.jpg'));
    }
}